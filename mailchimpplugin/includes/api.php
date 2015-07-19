<?php

class MailchimpPlugin {

    /* NB: This apache config is necessary:
        Enable mod_rewrite, and:
        <Directory /Users/mine/Documents/websites/wordpress>
          Options FollowSymLinks
          AllowOverride FileInfo
          Require all granted
        </Directory>
    */


  private $mctool;

  /** Hook WordPress
   * @return void
   */
  public function __construct() {
    add_filter('query_vars', array($this, 'add_query_vars'), 0);
    add_action('parse_request', array($this, 'sniff_requests'), 0);
    add_action('init', array($this, 'add_endpoint'), 0);
  }

  /** Add public query vars
   * @param array $vars List of current public query vars
   * @return array $vars
   */
  public function add_query_vars($vars) {
    $vars[] = 'api';
    $vars[] = 'endpoint';
    $vars[] = 'json';
    return $vars;
  }

  /** Add API Endpoint
   * @return void
   *
   */
  public function add_endpoint() {
    add_rewrite_rule('^api/mailchimp/(.*)$', 'index.php?api=mc&endpoint=$matches[1]', 'top');
  }

  /**    Sniff Requests
   *    This is where we hijack all API requests
   *    If $_GET['api'] is set, we'll use our endpoint
   * @return die if API request
   */
  public function sniff_requests() {
    global $wp;

    // Test list ids:
    // 097da681eb - Headnet test Liste
    // f2d2ebbd8f - Test Liste

    if (isset($wp->query_vars['api']) && $wp->query_vars['api'] == 'mc') {
        require_once(plugin_dir_path(__FILE__) . '/Mailchimptool.php');
        require_once(plugin_dir_path(__FILE__) . '/curl.php');
        $this->mctool = new Mailchimptool('mailchimp hostname ', 'api key here');

        if ($wp->query_vars['endpoint'] == 'lists') {
            print($this->signupForm());
        } elseif ($wp->query_vars['endpoint'] == 'subscribe') {
            print($this->subscribeUser());
        } elseif ($wp->query_vars['endpoint'] == 'members') {
            print("In members area.");

            if (is_admin()) {
                // $data = json_decode(urldecode($wp->query_vars['json']));
                // $this->members($data);
                print("Hello admin - members corner!");
            } else {
                print("Du er ikke admin.");
            }
        } else {
            error_log("TEST: query vars here:\n" . print_r($wp->query_vars, true));
        }

        exit;
    }
  }


  private function signupForm() {
      header('Content-Type: text/plain');
      $response = json_decode($this->mctool->lists());

      if (is_object($response)) {
          $res = '<form action="/api/mailchimp/subscribe" method="post" name="mcsignup" id="mcsignup"><br/>';
          $res .= 'Liste<br/><select name="listid" id="listid">';
          foreach ($response->lists as $list) {
              $res .= '<option value="' . $list->id . '">' . $list->name . '</option>';
          }
          $res .= '</select><br/>';
          $res .= 'Email<br/><input type="email" name="email" id="email">';
          $res .= 'Fornavn<br/><input type="text" name="fname" id="fname">';
          $res .= 'Efternavn<br/><input type="text" name="lname" id="lname">';
          $res .= '<br/><input type="submit" name="submit" value="Tilmeld mig" id="submit">';
          $res .= '</form>';
          return $res;
      } else {
          return "Cant understand what mc said: " . print_r($response, true);
      }
  }

  private function subscribeUser() {

      $raw = file_get_contents('php://input');
      parse_str($raw, $data);
      if (is_array($data)) {
          $result = $this->mctool->subscribe($data['listid'], $data['email'], $data['fname'], $data['lname']);
          $decres = json_decode($result);
          if (is_object($decres) && property_exists($decres, 'status')) {
              if ($decres->status === 'pending') {
                  return("Tilmelding gik godt - du skal bare bekræfte den email der er sendt til " . $data->email);
              } elseif ($decres->status > 399 && strpos($decres->detail, 'already a list member') !== FALSE) {
                  error_log("\n\nInput: " . print_r($data,true) . "\n\nResult: " . print_r($result, true));
                  // return("Det ser ud til at du allerede er tilmeldt med emailen " . $data['email']);
                  wp_redirect("http://wordpress.meem.dk/?p=8");
                  exit;
              } else {
                  error_log("\n\nInput: " . print_r($data,true) . "\n\nResult: " . print_r($result, true));
                  return("Tilmelding gik galt.");
              }
          } else {
              error_log("Result of subscription is not intelligible.");
              error_log("\n\nInput: " . print_r($data,true) . "\n\nResult: " . print_r($result, true));
              return("Tilmelding gik galt");
          }
      } else {
          error_log("Post data not valid: " . print_r($raw, true));
          return("Tilmelding gik galt");
      }
  }
}

new MailchimpPlugin();

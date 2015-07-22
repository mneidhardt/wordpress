<?php

class MailchimpListsignup {

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

    if (isset($wp->query_vars['api']) && $wp->query_vars['api'] == 'mc') {
        require_once(plugin_dir_path(__FILE__) . '/Mailchimptool.php');
        require_once(plugin_dir_path(__FILE__) . '/curl.php');

        $mchost = get_option('mclistsignuphost');
        $mcapikey = get_option('mclistsignupapikey');

        $this->mctool = new Mailchimptool($mchost, $mcapikey);

        if ($wp->query_vars['endpoint'] == 'lists') {
            print($this->signupForm());
        } elseif ($wp->query_vars['endpoint'] == 'subscribe') {
            print($this->subscribeUser());
        }

        exit;
    }
  }


  private function signupForm() {
      header('Content-Type: text/plain');
      $raw = $this->mctool->lists();
      $response = json_decode($raw);

      if (is_object($response)) {
          $res = '<form action="javascript:void(0);" name="mcsignupform" id="mcsignupform"><br/>';
          $res .= 'Liste<br/><select name="mclistid" id="mclistid">';
          foreach ($response->lists as $list) {
              $res .= '<option value="' . $list->id . '">' . $list->name . '</option>';
          }
          $res .= '</select><br/>';
          $res .= 'Email<br/><input type="email" name="mcemail" id="mcemail">';
          $res .= 'Fornavn<br/><input type="text" name="mcfname" id="mcfname">';
          $res .= 'Efternavn<br/><input type="text" name="mclname" id="mclname">';
          $res .= '<br/><button onclick="signup();">Tilmeld mig</button>';
          $res .= '<input type=hidden name="mcformaction" value="' . get_home_url() . '/api/mailchimp/subscribe" id="mcformaction">';
          $res .= '</form><br/><div id="mcresponseinfo"></div>';
          return $res;
      } else {
          error_log('Unable to understand what mailchimp said: ' . $raw);
          return "Unable to understand what mailchimp said.";
      }
  }

  private function subscribeUser() {

      $raw = file_get_contents('php://input');
      $data = json_decode($raw);

      if (is_object($data)) {
          $result = $this->mctool->subscribe($data->mclistid, $data->mcemail, $data->mcfname, $data->mclname);
          $decres = json_decode($result);
          if (is_object($decres) && property_exists($decres, 'status')) {
              if ($decres->status === 'pending') {
                  return("Tilmelding gik godt - du skal bare bekræfte den email der er sendt til " . $data->mcemail);
              } elseif ($decres->status > 399 && strpos($decres->detail, 'already a list member') !== FALSE) {
                  return("Det ser ud til at du allerede er tilmeldt med emailen " . $data->mcemail);
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

      exit;
  }
}

new MailchimpListsignup();

<?php

class MoodlePlugin {

    /* NB: This apache config is necessary:
        Enable mod_rewrite, and:
        <Directory /Users/mine/Documents/websites/wordpress>
          Options FollowSymLinks
          AllowOverride FileInfo
          Require all granted
        </Directory>
    */


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
    $vars[] = 'json';
    return $vars;
  }

  /** Add API Endpoint
   * @return void
   *
   */
  public function add_endpoint() {
    add_rewrite_rule('^api/moodle/(.*)/?$', 'index.php?api=moodle&json=$matches[1]', 'top');
    add_rewrite_rule('^api/econ/(.*)/?$', 'index.php?api=econ&json=$matches[1]', 'top');
  }

  /**    Sniff Requests
   *    This is where we hijack all API requests
   *    If $_GET['api'] is set, we'll use our endpoint
   * @return die if API request
   */
  public function sniff_requests() {
    global $wp;

    if (isset($wp->query_vars['api'])) {
        if ($wp->query_vars['api'] == 'moodle') {
            $this->handle_post_request();
        } elseif ($wp->query_vars['api'] == 'econ') {
            // Hvad skal der ske her?
            // $this->handle_post_request();
        }
      //$this->handle_get_request($wp->query_vars);
      exit;
    }
  }

  protected function handle_get_request($args) {
      error_log(print_r($_REQUEST, true));
      print("_REQ=" . print_r($_REQUEST, true));
      print(" wp=" . print_r($args, true));
      exit;
  }


    protected function handle_post_request() {
        require_once(plugin_dir_path(__FILE__) . '/MoodleUsertool.php');
        require_once(plugin_dir_path(__FILE__) . '/curl.php');
        header('Content-Type: text/plain');
        echo "Howdy peer\n";
        /* Test af Moodle integration:
        $utool = new MoodleUsertool('http://moodle.meem.dk', 'token here');
        $list = $utool->listuser('lastname', 'vladko');
        if (is_object($list) && is_array($list->users)) {
            foreach ($list->users as $user) {
                print($user->id . ': ' . $user->email . "\n");
            }
        } else {
            print("Some error..." . print_r($list, true));
        }
        error_log("MoodleUsertool v. " . $utool->version() . "\n" . print_r($POSTDATA, true));
        */
        
         
        $POSTDATA = file_get_contents('php://input');
        error_log(print_r($POSTDATA, true));

        exit;
        /*
        $es_options = get_option('elasticsearch');
        $es_url = $es_options['server_url'] . $es_options['server_index'] . '/_search?pretty';

        # Example of input I expect for content below here:
        #       '{"query":{"query_string":{query:"uddrag"}}}';

        # The data from the POST, i.e. the query, comes from php://input, not in $_POST.
        $POSTDATA = file_get_contents('php://input');

        $options = array(
            'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => $POSTDATA
            ),
        );
        $context  = stream_context_create($options);
        header('Content-Type: application/json');
        $result = file_get_contents($es_url, false, $context);
        echo $result;
        exit;
        */
    }
}

new MoodlePlugin();

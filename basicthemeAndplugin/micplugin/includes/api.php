<?php

class MicProxy {

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
    $vars[] = 'esjson';
    return $vars;
  }

  /** Add API Endpoint
   * @return void
   *
   */
  public function add_endpoint() {
    // add_rewrite_rule('^/api/es/?(.*)?/?', 'index.php?__api=1&es-json=$matches[1]', 'top');
    add_rewrite_rule('^api/es/(.*)$', 'index.php?api=1&esjson=$matches[1]', 'top');
  }

  /**    Sniff Requests
   *    This is where we hijack all API requests
   *    If $_GET['api'] is set, we'll use our endpoint
   * @return die if API request
   */
  public function sniff_requests() {
    global $wp;

    if (isset($wp->query_vars['api'])) {
      //$this->handle_post_request();
      $this->handle_get_request($wp->query_vars);
      exit;
    } else {
        error_log("Sniffer says: api not found...");
    }
  }

  protected function handle_get_request($args) {
      error_log(print_r($_REQUEST, true));
      print("_REQ=" . print_r($_REQUEST, true));
      print(" wp=" . print_r($args, true));
      exit;
  }


    protected function handle_post_request() {
        $POSTDATA = file_get_contents('php://input');
        error_log(print_r($POSTDATA, true));

        header('Content-Type: text/plain');
        echo "Howdy peer";
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

new MicProxy();

<?php
/**
 * Code for doing things in Mailchimp.
 * Requires curl.php.
 */

class Mailchimptool {
    private $protocol = 'https';
    private $host;
    private $apikey;
    private $restpath = '/3.0/';
    private $url;

    function version() { return '0.1'; }

    function __construct($host, $apikey, $apiuser = 'dummyuser') {
        $this->host = $host;
        $this->apikey = $apikey;
        $this->url = $this->protocol . '://' . $apiuser . ':' . $this->apikey . '@' . $this->host . $this->restpath;
    }

    function basicinfo() {
        $curl = new curl;
        header('Content-Type: text/plain');
        return json_decode($curl->get($url));
    }

    function lists($listid = '') {
        return $this->restGet('lists/' . $listid);
    }

    function members($listid) {
        return $this->restGet('lists/' . $listid . '/members');
    }

    /* This subscribes a person, identified by email, and with first name and last name, to the list with id $listid.
     * Status = 'pending' means that the user must subsequently confirm the subscription.
     * Status = 'subscribed' means that the user is immediately subscribed.
     */
    function subscribe($listid, $email, $fname, $lname, $status = 'pending') {
        $data = json_encode(array('email_address' => $email,
                                  'status' => $status,
                                  'merge_fields' => array('FNAME' => $fname,
                                                          'LNAME' => $lname)
                                  )
                             );

        return $this->restPost('lists/' . $listid . '/members', $data);
    }

    function unsubscribe($listid, $email) {
        /* NB. This does not yet work.
           I made the patch function in curl.php, and that is probably not correct.

        return $this->restPatch('lists/' . $listid . '/members', json_encode(array('email_address' => $email, 'status' => 'unsubscribed')));
        */

        return('Not yet implemented.');
    }

    private function restGet($endpoint) {
        $curl = new curl;
        header('Content-Type: text/json');
        return $curl->get($this->url . $endpoint);
    }
    
    private function restPost($endpoint, $params) {
        $curl = new curl;
        header('Content-Type: text/json');

        return $curl->post($this->url . $endpoint, $params);
    }

    private function restPatch($endpoint, $params) {
        /* $curl = new curl;
        header('Content-Type: text/json');
        return $curl->patch($this->url . $endpoint, $params);
        // NB: This does not work...
        */
        return('Not yet implemented.');
    }
}

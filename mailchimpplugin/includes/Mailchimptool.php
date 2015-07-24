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

    function lists($listid = '') {
        return $this->restGET('lists/' . $listid);
    }

    /* Returns a list of member of the list, or, if $member contains
     * the md5 hash of a member's email, returns data for this specific member.
     */
    function members($listid, $member='') {
        return $this->restGET("lists/$listid/members/$member");
    }

    /* Returns a list of member of the list, or, if $member contains
     * the md5 hash of a member's email, returns data for this specific member.
     */
    function deletemember($listid, $email) {
        return $this->restDELETE("lists/$listid/members/" . md5($email));
    }

    /* This subscribes a person, identified by email, and with first name and last name, to the list with id $listid.
     * Status = 'pending' means that the user must subsequently confirm the subscription.
     * Status = 'subscribed' means that the user is immediately subscribed.
     */
    function subscribe($listid, $email, $fname, $lname, $status='pending') {
        $data = json_encode(array('email_address' => $email,
                                  'status' => $status,
                                  'merge_fields' => array('FNAME' => $fname,
                                                          'LNAME' => $lname)
                                  )
                             );

        return $this->restPOST('lists/' . $listid . '/members', $data);
    }

    function unsubscribe($listid, $email) {
        $md5 = md5($email);
        return $this->restPATCH("lists/$listid/members/" . md5($email) . '/', '{"status":"unsubscribed"}');
    }


    function updateSubscriptionstatus($listid, $email, $newstatus) {
        return $this->restPATCH("lists/$listid/members/" . md5($email) . '/', '{"status":"' . $newstatus . '"}');
    }

    private function restGET($endpoint) {
        $url = $this->url . $endpoint;
        $headers = array('Content-Type: application/json');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        return($response);
    }
    private function restPOST($endpoint, $data) {
        $url = $this->url . $endpoint;
        $headers = array('Content-Type: application/json');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        return($response);
    }
    private function restPATCH($endpoint, $data) {
        $url = $this->url . $endpoint;
        $headers = array('Content-Type: application/json');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        return($response);
    }

    private function restDELETE($endpoint) {
        $url = $this->url . $endpoint;
        $headers = array('Content-Type: application/json');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        curl_close($curl);
        return($response);
    }
}

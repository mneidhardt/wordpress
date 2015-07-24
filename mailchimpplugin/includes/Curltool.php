<?php
/**
 * Class for making curl calls.
 */

class Curltool {
    private $curl;

    function version() { return '0.1'; }

    /* $url is the full url, i.e. hostname and possible path.
     */
    function __construct($url) {
        $this->curl = curl_init($url);
        $headers = array('Content-Type: application/json');
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    }

    function doGET() {
        return $this->doit();
    }

    // $data is a JSON string.
    function doPOST($data) {
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        return $this->doit();
    }

    // $data is a JSON string.
    function doPATCH($data) {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        return $this->doit();
    }

    function doDELETE() {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->doit();
    }

    private function doit() {
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return($response);
    }
}

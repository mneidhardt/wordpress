<?php
/**
 * Code for managing Moodle users.
 * Requires curl.php.
 */

class MoodleUsertool {
    private $host;
    private $token;
    private $restpath = '/webservice/rest/server.php';

    function version() { return '0.1'; }

    function __construct($host, $token) {
        $this->host = $host;
        $this->token = $token;
    }

    function listuser($key, $value) {
        $params = array('criteria' => array(array('key' => $key, 'value' => $value)));
        $functionname = 'core_user_get_users';
        return $this->restcall($functionname, $params);
    }
    
    function listcourses() {
        $params = array('criteria' => array());
        $functionname = 'core_course_get_courses';
        return $this->restcall($functionname, $params);
    }
    
    /* Create 1 or more users.
     * $users is an array of 1 or more arrays, each with these
     * fields as a minimum:
     * username, password, firstname, lastname, email.
     *
     * E.g. to create a user, pass this in:
     * array(
     *    array('username' => 'mine',
     *          'password' => 'Password08!',
     *          'firstname' => 'Michael',
     *          'lastname' => 'Neidhardt',
     *          'email' => 'mine@headnet.dk')
     *    )
     */ 
    function createuser($users) {
        $functionname = 'core_user_create_users';
        return $this->restcall($functionname, array('users' => $users));
    }
    
    /* Delete 1 or more users.
     * $users is an array of userids to delete.
     */
    function deleteuser($userids) {
        $functionname = 'core_user_delete_users';
        $arg = array('userids' => $userids);
        return $this->restcall($functionname, $arg);
    }
    
    function enrolluser($enrollment) {
        $functionname = 'enrol_manual_enrol_users';
        return $this->restcall($functionname, $enrollment);
    }
    
    
    private function restcall($functionname, $params) {
        $serverurl = $this->host . $this->restpath .
                     '?wstoken=' . $this->token .
                     '&wsfunction=' . $functionname .
                     '&moodlewsrestformat=json';
        $curl = new curl;
        header('Content-Type: text/plain');
        return json_decode($curl->post($serverurl, $params));
    }
    
    
    /* Creates a test enrollment for use when creating a user.
     * Returns the data structure to pass to Moodle.
     */
    function getTestenrollments($userid, $courseid) {
        $enrollment = array('roleid' => 5,
                           'userid' => $userid,
                           'courseid' => $courseid);
        $enrollments = array('enrolments' => array($enrollment));
    
        return $enrollments;
    }
}

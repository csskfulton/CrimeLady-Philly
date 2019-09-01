<?php 


class ConnectObject{
    
    var $host = 'localhost';
    var $user = 'gerry';
    var $pass = 'Keithistheking';
    var $db = 'PhillyPolice';
    var $myconn;
    
    function connect() {
        $con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        if (!$con) {
            die('Could not connect to database!');
        } else {
            $this->myconn = $con;
        }
            return $this->myconn;
    }
    
    function close() {
        mysqli_close($myconn);
    }
    
    







}



?>
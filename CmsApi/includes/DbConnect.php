<?php
class DbConnect {
    private $connect;

    function __construct() { }

    function connect() {
        # Imports string values from Constants.php
        include_once dirname(__FILE__).'/Constants.php';

        # Initializes connection to CMS Database
        $this->connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        # Forwarded message if connection fails
        if (mysqli_connect_error()) {
            echo "Failed to connect to MySQL".mysqli_connect_error();
        }

        return $this->connect;
    }
}
<?php
class DbOperation {
    private $connect;

    function __construct() {
        require_once dirname(__FILE__).'/DbConnect.php';

        $database = new DbConnect();
        $this->connect = $database->connect();
    }

    // POST Request
    // Params: date_submitted (DATETIME), subject (STRING), message (STRING)
    // Inserts new announcement in cms_db
    function createAnnouncement($dateSubmitted, $subject, $message) {
        $statement = $this->connect->prepare("INSERT INTO announcements (date_submitted, subject, message) VALUES (?, ?, ?)");

        // SSS = STRING STRING STRING
        $statement->bind_param("sss", $dateSubmitted, $subject, $message);

        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // POST Request
    // Params: date_submitted (DATETIME), name (STRING), idNumber (STRING), cellphone_number (STRING),
    //         department (STRING)
    // Inserts new form in cms_db
    function createForm($dateSubmitted, $name, $idNumber, $cellphoneNumber, $department) {
        $statement = $this->connect->prepare("INSERT INTO forms (date_submitted, name, id_number, cellphone_number,
            department) VALUES (?, ?, ?, ?, ?)");

        // SSSSS = STRING STRING STRING STRING STRING
        $statement->bind_param("sssss", $dateSubmitted, $name, $idNumber, $cellphoneNumber, $department);

        if ($statement->execute()) {
            return true;
        }

        return false;
    }

    // GET Request
    // Params: None
    // Returns all announcements in cms_db
    function getAnnouncements() {
        $statement = $this->connect->prepare("SELECT * from announcements");
        $statement->execute();
        $statement->bind_result($dateSubmitted, $subject, $message);

        $announcements = array();

        // Fetches each announcement and inserts them into an array with appropriate labels
        while($statement->fetch()) {
            $announcement = array();
            $announcement['dateSubmitted'] = $dateSubmitted;
            $announcement['subject'] = $subject;
            $announcement['message'] = $message;

            // Inserts each announcement into an array of announcements
            array_push($announcements, $announcement);
        }

        return $announcements;
    }

    // GET Request
    // Params: None
    // Returns all forms in cms_db
    function getForms() {
        $statement = $this->connect->prepare("SELECT * from forms");
        $statement->execute();
        $statement->bind_result($dateSubmitted, $name, $idNumber, $cellphoneNumber, $department);

        $forms = array();

        // Fetches each form and inserts them into an array with appropriate labels
        while($statement->fetch()) {
            $form = array();
            $form['dateSubmitted'] = $dateSubmitted;
            $form['name'] = $name;
            $form['idNumber'] = $idNumber;
            $form['cellphoneNumber'] = $cellphoneNumber;
            $form['department'] = $department;

            // Inserts each form into an array of forms
            array_push($forms, $form);
        }

        return $forms;
    }
}
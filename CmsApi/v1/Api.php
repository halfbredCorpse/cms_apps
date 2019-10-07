<?php
    require_once '../includes/DbOperation.php';

    function isParamAvailable($params) {
        $available = true;
        $missingParams = "";

        foreach($params as $param) {
            if (!isset($_POST[$param]) || strlen($_POST[$param]) <= 0) {
                $available = false;
                $missingParams = $missingParams.".".$param;
            }
        }

        if (!$available) {
            $response = array();
            $response['error'] = true;
            $response['message'] = 'Parameters'.substr($missingParams, 1, strlen($missingParams)).' missing';

            echo json_encode($response);

            die();
        }
    }

    $response = array();

    if (isset($_GET['apicall'])) {
        switch($_GET['apicall']) {
            // URL:     .../CmsApi/v1/Api.php?apicall=createannouncement
            // Params:  dateSubmitted, subject, message
            // Output:  null
            case 'createannouncement':
                isParamAvailable(array('dateSubmitted', 'subject', 'message'));

                $database = new DbOperation();

                $result = $database->createAnnouncement(
                    $_POST['dateSubmitted'],
                    $_POST['subject'],
                    $_POST['message']);

                if ($result) {
                    $response['error'] = false;
                    $response['message'] = 'Announcement sent successfully!';
                    $response['announcements'] = $database->getAnnouncements();
                } else {
                    $response['error'] = true;
                    $response['message'] = 'Some error occurred. Try again.';
                }
            break;

            // URL:     .../CmsApi/v1/Api.php?apicall=createform
            // Params:  dateSubmitted, name, idNumber, cellphoneNumber, department
            // Output:  null
            case 'createform':
                isParamAvailable(array('dateSubmitted', 'name', 'idNumber', 'cellphoneNumber', 'department'));

                $database = new DbOperation();

                $result = $database->createForm(
                    $_POST['dateSubmitted'],
                    $_POST['name'],
                    $_POST['idNumber'],
                    $_POST['cellphoneNumber'],
                    $_POST['department']);

                if ($result) {
                    $response['error'] = false;
                    $response['message'] = 'Form sent successfully!';
                    $response['forms'] = $database->getForms();
                } else {
                    $response['error'] = true;
                    $response['message'] = 'Some error occurred. Try again.';
                }
            break;

            // URL:     .../CmsApi/v1/Api.php?apicall=getannouncements
            // Params:  n/a
            // Output:  arrays(dateSubmitted, subject, message)
            case 'getannouncements':
                $database = new DbOperation();
                $response['error'] = false;
                $response['message'] = 'Request completed!';
                $response['announcements'] = $database->getAnnouncements();
            break;

            // URL:     .../CmsApi/v1/Api.php?apicall=getforms
            // Params:  n/a
            // Output:  arrays(dateSubmitted, name, idNumber, cellphoneNumber, department)
            case 'getforms':
                $database = new DbOperation();
                $response['error'] = false;
                $response['message'] = 'Request completed!';
                $response['forms'] = $database->getForms();
            break;
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'Invalid API Call';
    }

    echo json_encode($response);
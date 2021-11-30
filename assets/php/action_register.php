<?php

    // checks if form sent valid data
    function isValidEntry($input) {
        // separated to isolate error
        if (isset($input))
            return (!empty($input));
        else
            return false;
    }

    // moves back to original screen
    function errorReceived() {
        echo "<br> Received error here, going back to registration <br>";
        $_SESSION['fullname'] = "";
        $_SESSION['valid'] = false;
        header("Location: ../../registration.php");
    }

    echo "in php, comparing request <br>";
    echo "Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "method = post<br>inputs:";

        print_r($_POST); echo "<br><br>";

        // get values from form, and check if they are valid
        if (isValidEntry($_POST['input_fname'])) {
            $input_fname = $_POST['input_fname'];
        } else {
            echo "no fname <br>";
            $_SESSION['status_message'] = "Empty fname received";
            errorReceived();
        }

        if (isValidEntry($_POST['input_lname'])) {
            $input_lname = $_POST['input_lname'];
        } else {
            echo "no lname <br>";
            $_SESSION['status_message'] = "Empty lname received";
            errorReceived();
        }

        if (isValidEntry($_POST['input_username'])) {
            $input_username = $_POST['input_username'];
        } else {
            echo "no username <br>";
            $_SESSION['status_message'] = "Empty username received";
            errorReceived();
        }
        
        if (isValidEntry($_POST['input_email'])) {
            $input_email = $_POST['input_email'];
        } else {
            echo "no email <br>";
            $_SESSION['status_message'] = "Empty email received";
            errorReceived();
        }

        if (isValidEntry($_POST['input_password'])) {
            $input_password = $_POST['input_password'];
        } else {
            echo "no pw <br>";
            $_SESSION['status_message'] = "Empty password received";
            errorReceived();
        }

        if (isValidEntry($_POST['input_dob'])) {
            $input_dob = $_POST['input_dob'];
        } else {
            echo "no dob <br>";
            $_SESSION['status_message'] = "Empty DOB received";
            errorReceived();
        }

        echo "input_fname=" . $input_fname . "<br>";
        echo "input_lname=" . $input_lname . "<br>";
        echo "input_username=" . $input_username . "<br>";
        echo "input_email=" . $input_email . "<br>";
        echo "input_password=" . $input_password . "<br>";
        echo "input_dob=" . $input_dob . "<br>";

        // these parts are optional from the form; we check if key exists, then validate that

        $serverName = "18.189.211.159:3306";
        $username = "guest";
        $password = "KCKMakk_4";
        // $serverName = "localhost:3306";
        // $username = "root";
        // $password = "";

        // connection to server
        $conn = new mysqli($serverName, $username, $password); 
        if ($conn->connect_error) {
            $_SESSION['valid'] = false;
            $_SESSION['status_message'] = "Failed to connect to server";
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "made it to server <br>";
        }
        $conn->close();

        $dbName = "rangerswatch";
        // connection to database
        $conn = new mysqli($serverName, $username, $password, $dbName); 
        if ($conn->connect_error) {
            $_SESSION['valid'] = false;
            $_SESSION['status_message'] = "Failed to connect to database";
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "made it to database! <br>";
        }

        $tblName = "accounts";

        // default values...
        $input_experience = 0;
        $input_noti1 = 0;
        $input_noti2 = 0;
        // Appending optional fields into the sql query
        if (array_key_exists('input_experience', $_POST)) {
            if (isValidEntry($_POST['input_experience'])) {
                echo "exp: " . $_POST['input_experience'] . ".<br>";
                $input_experience = $_POST['input_experience'];
            }
        }
        if (array_key_exists('input_noti1', $_POST)) {
            if (isValidEntry($_POST['input_noti1'])) {
                echo "not1: " . $_POST['input_noti1'] . ".<br>";
                $input_noti1 = $_POST['input_noti1'];
            }
        }
        if (array_key_exists('input_noti2', $_POST)) {
            if (isValidEntry($_POST['input_noti2'])) {
                echo "not2: " . $_POST['input_noti2'] . ".<br>";
                $input_noti2 = $_POST['input_noti2'];
            }
        }


        // INSERT INTO table (col1, col2, ..) VALUES (val1, val2)  - note val1 may not be necessary if you have autoincrement
        $hash_pw = hash('sha3-512', $input_password);
        $tblName = "accounts";
        $sql_insert = 
                    "INSERT INTO " . $tblName . " " . 
                        "(username, password, fname, lname, email, dob, exp, n1, n2)  " . " " .
                    "VALUES
                        ('$input_username', '$hash_pw', '$input_fname', '$input_lname', " .
                        "'$input_email', '$input_dob', '$input_experience', '$input_noti1', '$input_noti2');";
        echo "<br>qry:" . $sql_insert . "<br><br>";

        // =========INSERTING INTO ============
        if ($conn->query($sql_insert) === TRUE) {
            // TODO: GIVE TOKEN HERE
            echo "New record created successfully. Going to main... <br>";
            $_SESSION['status_message'] = "";
            // header("Location: ../../main.php");
            return;
        } else {
            // Could not input; either existing email or username
            echo "Error: " . $sql_insert . "<br>" . $conn->error . "<br>";
            $_SESSION['status_message'] = "Already Existing Username or Email";
        }
        $conn->close();
    }

    // ON ERROR...
    errorReceived();
    exit();
?>
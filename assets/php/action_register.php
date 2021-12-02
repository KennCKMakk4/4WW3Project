<?php

    // checks if form sent valid data
    function isValidEntry($input) {
        return (isset($input) && !empty($input));
    }

    // moves back to original screen
    function errorReceived($msg) {
        echo "<br>Received error: " . $msg . ". Returning to registration<br>";
        $conn = null;
        $_SESSION['username'] = "";
        $_SESSION['fullname'] = "";
        $_SESSION['valid'] = false;
        $_SESSION['status_message'] = $msg;
        header("Location: ../../registration.php");
    }

    session_start();
    echo "in php, comparing request <br>";
    echo "Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "method = post<br>inputs:";

        print_r($_POST); echo "<br><br>";

        // get values from form, and check if they are valid
        if (isValidEntry($_POST['input_fname'])) {
            $input_fname = $_POST['input_fname'];
        } else {
            errorReceived("Empty first name received");
        }

        if (isValidEntry($_POST['input_lname'])) {
            $input_lname = $_POST['input_lname'];
        } else {
            errorReceived("Empty last name received");
        }

        if (isValidEntry($_POST['input_username'])) {
            $input_username = $_POST['input_username'];
        } else {
            errorReceived("Empty username received");
        }
        
        if (isValidEntry($_POST['input_email'])) {
            $input_email = $_POST['input_email'];
        } else {
            errorReceived("Empty email received");
        }

        if (isValidEntry($_POST['input_password'])) {
            $input_password = $_POST['input_password'];
        } else {
            errorReceived("Empty password received");
        }

        if (isValidEntry($_POST['input_dob'])) {
            $input_dob = $_POST['input_dob'];
        } else {
            errorReceived("Empty DOB received");
        }

        echo "input_fname=" . $input_fname . "<br>";
        echo "input_lname=" . $input_lname . "<br>";
        echo "input_username=" . $input_username . "<br>";
        echo "input_email=" . $input_email . "<br>";
        echo "input_password=" . $input_password . "<br>";
        echo "input_dob=" . $input_dob . "<br>";

        // these parts are optional from the form; we check if key exists, then validate that


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

        try {
            require "../../dbconn.php";
            echo "made it to database! <br>";
            
            $tblName = "accounts";
            $sql_insert = "INSERT INTO " . $tblName . " " . 
                            "(username, password, fname, lname, email, dob, exp, n1, n2)  " . " " .
                        "VALUES
                            (?, ?, ?, ?, ?, ?, ?, ?, ?);";
            echo "<br>qry:" . $sql_insert . "<br><br>";
            // =========INSERTING INTO ============
            $stmt = $conn->prepare($sql_insert);
            if ($stmt->execute(array($input_username, $hash_pw, $input_fname, $input_lname, $input_email, 
                             $input_dob, $input_experience, $input_noti1, $input_noti2))) {
                echo "Record inserted successfully<br>";

                // now pull from the db the account details with given parameters
                $sql_read = "SELECT * FROM " . $tblName . " " .
                            " WHERE username=? " . 
                            " AND password=?;";
                $result = $conn->prepare($sql_read);
                if ($result->execute(array($input_username, $hash_pw))) {
                    if ($result->rowCount() > 0) {
                        // Successful pull of new account details
                        echo "Found username entry<br>";
                        // get first row
                        $row = $result->fetch();

                        // Giving session tokens here
                        echo $row['fname'] . " " . $row['lname'] . "<br>";
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['fullname'] = $row["fname"] . " " . $row["lname"];
                        $_SESSION['valid'] = true;
                        $_SESSION['status_message'] = "";
                        
                        // 86400seconds = 1 day
                        // cookies for if user set 'RememberMe' at login
                        setcookie('username', $_POST['input_username'], time() + (86400 * 30), "/");

                        // echo "New record created successfully. Going to main... <br>";
                        header("Location: ../../main.php");
                        return;
                    } else {
                        errorReceived("Account created, but failed authentication to login");
                    }
                } else {
                    errorReceived("Account created, but failed authentication query");
                }
            } 
            $conn=null;
        } catch (PDOException $e) {
            $error = $e->errorInfo[2];

            // changing error msg based on type
            if (strpos($error, "accounts.username"))
                $error = "There is already an existing account with the same username";
            else if (strpos($stmt->error, "accounts.email"))
                $error = "There is already an existing account with the same email";

            errorReceived($error);
        }
    }
    exit();
?>
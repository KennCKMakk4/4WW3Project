<?php

    // checks if form sent valid data
    function isValidEntry($input) {
        return (isset($input) && !empty($input));
    }

    // moves back to original screen
    function errorReceived($msg) {
        echo "<br>Received error: " . $msg . ". Returning to signin<br>";
        $conn=null;
        $_SESSION['username'] = "";
        $_SESSION['fullname'] = "";
        $_SESSION['valid'] = false;
        $_SESSION['status_message'] = $msg;
        header("Location: ../../signin.php");
    }

    // start storing values of user
    session_start();
    echo "in php, comparing request <br>";
    echo "Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "method = post<br>";
        // $_POST is an arr holding all elements from from
        $input_username = "";
        $input_password = "";

        // get values from form, and check if they are valid
        if (isValidEntry($_POST['input_username'])) {
            $input_username = $_POST['input_username'];
        } else {
            errorReceived("Empty username received");
        }
        if (isValidEntry($_POST['input_password'])) {
            $input_password = $_POST['input_password'];
        } else {
            errorReceived("Empty password received");
        }

        $hash_pw = hash('sha3-512', $input_password);

        // connection to DB
        try {
            require "../../dbconn.php";
            echo "made it to database! <br>";

            $tblName = "accounts";
            $sql_read = "SELECT * FROM " . $tblName . " " .
                        " WHERE username=:input_username " . 
                        " AND password=:hash_pw;";
            echo "<br>qry:" . $sql_read . "<br><br>";
            $result = $conn->prepare($sql_read);
            $result->bindValue(':input_username', $input_username);
            $result->bindValue(':hash_pw', $hash_pw);
            $result->execute();
            if ($result) {
                if ($result->rowCount() > 0) {
                    // SUCCESFUL LOGIN!!!
                    echo "Found username entry<br>";
                    // get first row
                    $row = $result->fetch();

                    echo $row['fname'] . " " . $row['lname'] . "<br>";
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['fullname'] = $row["fname"] . " " . $row["lname"];
                    $_SESSION['valid'] = true;
                    $_SESSION['status_message'] = "";
                    
                    // 86400seconds = 1 day
                    // cookies for if user set 'RememberMe' at login
                    setcookie('username', $_POST['input_username'], time() + (86400 * 30), "/");
                    // set destination and leave this file
                    header("Location: ../../main.php");
                    return;
                } else {
                    // No such row in table matching parameters; i.e. incorrect login info
                    echo "Could not find matching parameters: " . $sql_read . "<br>";
                    errorReceived("Invalid username or password");
                }
            }
            $conn=null;
        } catch (PDOException $e) {
            $error = $e->errorInfo[2];
            errorReceived($error);
        }

    }
    exit();
?>
<?php

    function isValidEntry($input) {
        return (isset($input) && !empty($input));
    }

    // moves back to original screen
    function errorReceived() {
        echo "<br> Received error here, going back to signin <br>";
        $_SESSION['fullname'] = "";
        $_SESSION['valid'] = false;
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
            echo "no username <br>";
            $_SESSION['status_message'] = "Empty username received";
            errorReceived();
        }
        if (isValidEntry($_POST['input_password'])) {
            $input_password = $_POST['input_password'];
        } else {
            echo "no pw <br>";
            $_SESSION['status_message'] = "Empty password received";
            errorReceived();
        }

        echo "Username=" . $input_username . "<br>";
        echo "password=" . $input_password . "<br>";


        // $serverName = "kennsite.live"
        $serverName = "localhost:3306";
        $username = "root";
        $password = "";

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

        $hash_pw = hash('sha3-512', $input_password);
        // SELECT (col1, col2) FROM table WHERE ...
        $tblName = "accounts";
        $sql_read = "SELECT * FROM " . $tblName . " " .
                    "WHERE 
                        username='$input_username' " . 
                    " AND password='$hash_pw';";

        echo "<br>qry:" . $sql_read . "<br><br>";
        $result = $conn->query($sql_read);
        if ($result) {
            if ($result->num_rows > 0) {
                // SUCCESFUL LOGIN!!!
                echo "Found username entry<br>";
                // get first row
                $row = $result->fetch_assoc();

                // TODO: GIVE TOKEN HERE
                echo $row['fname'] . " " . $row['lname'] . "<br>";
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
                $_SESSION['status_message'] = "Invalid username or password";
                errorReceived();
            }
        } else {
            // Error finding result
            echo "Error: " . $sql_insert . "<br>" . $conn->error . "<br>";
            $_SESSION['status_message'] = "Could not query database";
            errorReceived();
        }
        $conn->close();
    }

    // ON ERROR...
    $_SESSION['status_message'] = "No Post Method";
    errorReceived();
    exit();
?>
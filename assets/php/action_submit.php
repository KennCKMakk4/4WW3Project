<?php

    // checks if form sent valid data
    function isValidEntry($input) {
        return (isset($input) && !empty($input));
    }

    // moves back to original screen
    function errorReceived($msg) {
        echo "<br>Received error: " . $msg . ". Returning to submission<br>";
        $_SESSION['status_message'] = $msg;
        header("Location: ../../submission.php");
    }

    session_start();
    echo "in php, comparing request <br>";
    echo "Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "method = post<br>inputs:";

        print_r($_POST); echo "<br><br>";

        // get values from form, and check if they are valid
        if (isValidEntry($_POST['input_name'])) {
            $input_name = $_POST['input_name'];
        } else {
            errorReceived("Empty name received");
        }

        if (isValidEntry($_POST['input_about'])) {
            $input_about = $_POST['input_about'];
        } else {
            errorReceived("Empty about section received");
        }

        if (isValidEntry($_POST['input_latitude'])) {
            $input_latitude = $_POST['input_latitude'];
        } else {
            errorReceived("Empty latitude received");
        }

        if (isValidEntry($_POST['input_longitude'])) {
            $input_longitude = $_POST['input_longitude'];
        } else {
            errorReceived("Empty longitude received");
        }

        if (isValidEntry($_POST['input_image'])) {
            $input_image = $_POST['input_image'];
        } else {
            errorReceived("Empty image received");
        }


        // Finished reading
        if(!isset($_SESSION['valid']) || !($_SESSION['valid']))
            errorReceived("Trying to submit but not logged in!");
        if(!isset($_SESSION['username']))
            errorReceived("Couldn't get username for submission!");
        else
            $input_username = $_SESSION['username'];

        echo "input_name=" . $input_name . "<br>";
        echo "input_about=" . $input_about . "<br>";
        echo "input_latitude=" . $input_latitude . "<br>";
        echo "input_longitude=" . $input_longitude . "<br>";
        echo "input_username=" . $input_username . "<br>";
        echo "input_image=" . $input_image . "<br>";


        // handling non-required values if there is something present
        $sqlColExtra = "";
        $sqlValExtra = "";

        if (isValidEntry($_POST['input_phone'])) {
            $input_phone = $_POST['input_phone'];
            $sqlColExtra = $sqlColExtra . ", phone";
            $sqlValExtra = $sqlValExtra . ", '" . $input_phone . "'";
        }

        if (isValidEntry($_POST['input_email'])) {
            $input_email = $_POST['input_email'];
            $sqlColExtra = $sqlColExtra . ", email";
            $sqlValExtra = $sqlValExtra . ", '" . $input_email . "'";
        }

        if (isValidEntry($_POST['input_address'])) {
            $input_address = $_POST['input_address'];
            $sqlColExtra = $sqlColExtra . ", address";
            $sqlValExtra = $sqlValExtra . ", '" . $input_address . "'";
        }

        if (isValidEntry($_POST['input_video'])) {
            $input_video = $_POST['input_video'];
            $sqlColExtra = $sqlColExtra . ", video";
            $sqlValExtra = $sqlValExtra . ", '" . $input_video . "'";
        }

        echo "Extra fields: <br>";
        echo $sqlColExtra . "<br>" . $sqlValExtra . "<br>";
        // video
        // if (isValidEntry($_POST['input_video'])) {
        //     $input_video = $_POST['input_video'];
        //     if (!empty($sqlColExtra)) {
        //         $sqlColExtra = $sqlColExtra . ", ";
        //         $sqlValExtra = $sqlValExtra . ", ";
        //     }
        //     $sqlColExtra = $sqlColExtra . "video";
        //     $sqlValExtra = $sqlValExtra . "'" . $input_video . "'"; 
        // }


        // connecting to db
        $serverName = "18.189.211.159:3306";
        $username = "guest";
        $password = "KCKMakk_4";

        // connection to server
        $conn = new mysqli($serverName, $username, $password); 
        if ($conn->connect_error) {
            errorReceived("Failed to connect to server");
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "made it to server <br>";
        }
        $conn->close();

        $dbName = "rangerswatch";
        // connection to database
        $conn = new mysqli($serverName, $username, $password, $dbName); 
        if ($conn->connect_error) {
            errorReceived("Failed to connect to database");
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "made it to database! <br>";
        }

        // INSERT INTO table (col1, col2, ..) VALUES (val1, val2)  - note val1 may not be necessary if you have autoincrement
        $tblName = "locations";
        $sql_insert = 
                    "INSERT INTO " . $tblName . " " . 
                        "(name, about, latitude, longitude, username, image" . $sqlColExtra . ") " .
                    "VALUES
                        ('$input_name', '$input_about', '$input_latitude', '$input_longitude', '$input_username', " .
                        "'$input_image'" . $sqlValExtra . ");";
        echo "<br>qry:" . $sql_insert . "<br><br>";

        // =========INSERTING INTO ============
        if ($conn->query($sql_insert) === TRUE) {
            // Succesful insert
            echo "New record created successfully. Going to the new object!... <br>";

            // TODO: Point user to new object
            header("Location: ../../object.php");
            return;

            // // now pull from the db the account details with given parameters
            // $sql_read = "SELECT * FROM " . $tblName . " " .
            //             "WHERE 
            //                 username='$input_username' " . 
            //             " AND password='$hash_pw';";
            // $result = $conn->query($sql_read);
            // if ($result) {
            //     if ($result->num_rows > 0) {
            //         // Successful pull of new account details
            //         echo "Found username entry<br>";
            //         // get first row
            //         $row = $result->fetch_assoc();

            //         // Giving session tokens here
            //         echo $row['fname'] . " " . $row['lname'] . "<br>";
            //         $_SESSION['username'] = $row['username'];
            //         $_SESSION['fullname'] = $row["fname"] . " " . $row["lname"];
            //         $_SESSION['valid'] = true;
            //         $_SESSION['status_message'] = "";
                    
            //         // 86400seconds = 1 day
            //         // cookies for if user set 'RememberMe' at login
            //         setcookie('username', $_POST['input_username'], time() + (86400 * 30), "/");
            //         // set destination and leave this file

            //         echo "New record created successfully. Going to main... <br>";
            //         header("Location: ../../main.php");
            //         return;
            //     } else {
            //         errorReceived("Account created, but failed authentication to login");
            //     }
            // } else {
            //     errorReceived("Account created, but failed authentication query");
            // }
        } else {
            // Could not input; either existing email or username
            echo "Error: " . $sql_insert . "<br>" . $conn->error . "<br>";
            $duplicateErrorStr = "";
            if (strpos($conn->error, "locations.name")) {
                $duplicateErrorStr = "name";
                errorReceived("There is already an existing place with the same " . $duplicateErrorStr);
            } else {
                errorReceived($conn->error);
            }
        }
        $conn->close();
    }
    exit();
?>
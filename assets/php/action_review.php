<?php

    // checks if form sent valid data
    function isValidEntry($input) {
        return (isset($input) && !empty($input));
    }

    // moves back to original screen
    function errorReceived($msg) {
        echo "<br>Received error: " . $msg . ". Returning to review<br>";
        $_SESSION['status_message'] = $msg;
        // header("Location: ../../review.php");
    }

    session_start();
    echo "in php, comparing request <br>";
    echo "Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "method = post<br>inputs:";

        print_r($_POST); echo "<br><br>";

        // get values from form, and check if they are valid
        if (isValidEntry($_POST['location_id'])) {
            $input_id = $_POST['location_id'];
        } else {
            errorReceived("No ID received, please sign out and sign in again!");
        }

        // get values from form, and check if they are valid
        if (isValidEntry($_POST['username'])) {
            $input_username = $_POST['username'];
        } else {
            errorReceived("No ID received, please sign out and sign in again!");
        }
        
        if (isValidEntry($_POST['currentRating'])) {
            $input_rating = $_POST['currentRating'];
        } else {
            errorReceived("No rating received");
        }

        $input_about = "";
        if (isValidEntry($_POST['input_about'])) {
            $input_about = $_POST['input_about'];
        }

        echo "input_id=" . $input_id . "<br>";
        echo "input_username=" . $input_username . "<br>";
        echo "input_rating=" . $input_rating . "<br>";
        echo "input_about=" . $input_about . "<br>";

        // connecting to db
        $serverName = "18.189.211.159:3306";
        $username = "guest";
        $password = "KCKMakk_4";
        $dbName = "rangerswatch";
        // connection to database
        $conn = new mysqli($serverName, $username, $password, $dbName); 
        if ($conn->connect_error) {
            errorReceived("Failed to connect to database");
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "made it to database! <br>";
        }


        $tblName = "ratings";
        $sql_insert = "INSERT INTO " . $tblName . " " . 
                        "(`location_id`, `username`, `value`, `comment`) " .
                    "VALUES
                        ('$input_id', '$input_username', '$input_rating', '$input_about');";
        echo "<br>qry:" . $sql_insert . "<br><br>";

        // =========INSERTING INTO ============
        if ($conn->query($sql_insert) === TRUE) {
            $conn->close();
            // Succesful insert
            echo "New record created successfully. Going to the reviewed object!... <br>";
            header("Location: ../../object.php?id=" . $input_id);
            return;
        } else {
            // Could not input; error executing query
            echo "Error: " . $sql_insert . "<br>" . $conn->error . "<br>";
            errorReceived($conn->error);
        }
        // Finished uploading files and submitting...
        $conn->close();
    }
    exit();
?>
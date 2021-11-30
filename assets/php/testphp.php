<?php
    echo "in php, comparing request <br>";
    echo "Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "method = post<br>";
        // $_POST is an arr holding all elements from from
        $input_username = "";
        $input_password = "";

        // get values from form, and check if they are valid
        if (isset($_POST['input_username']) && !empty($_POST['input_username'])) {
            $input_username = $_POST['input_username'];
        } else {
            echo "no username <br>";
            header("Location: ../../signin.php");
        }
        if (isset($_POST['input_password']) && !empty($_POST['input_password'])) {
            $input_password = $_POST['input_password'];
        } else {
            echo "no pw <br>";
            header("Location: ../../signin.php");
        }

        echo "Username=" . $input_username . "<br>";
        echo "password=" . $input_password . "<br>";


        // $serverName = "kennsite.live"
        // $serverName = "localhost:3306";
        // $username = "root";
        // $password = "";
        $serverName = "18.189.211.159:3306";
        $username = "guest";
        $password = "KCKMakk_4";

        // connection to server
        $conn = new mysqli($serverName, $username, $password); 
        if ($conn->connect_error) {
            header("Location: ../../signin.php");
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "made it to server <br>";
        }

        $dbName = "rangerswatch";
        // ====Creating a database====
        // $sql = "CREATE DATABASE " . $dbName;
        // if ($conn->query($sql) === TRUE);
        //     echo "Database created <br>";
        // else   
        //     echo "Database failed: " . $conn->connect_error . "<br>";   
        $conn->close();


        // connection to database
        $conn = new mysqli($serverName, $username, $password, $dbName); 
        if ($conn->connect_error) {
            header("Location: ../../signin.php");
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "made it to database! <br>";

            $sql = "CREATE TABLE accounts (
                    username VARCHAR(30) PRIMARY KEY NOT NULL(
                )";
        }

        // here we can do some funky stuff to fiddle with the db


        // INSERT INTO table (col1, col2, ..) VALUES (val1, val2)  - note val1 may not be necessary if you have autoincrement
        $sql_insert = 
                    "INSERT INTO user 
                        (usr_fullname)
                    VALUES 
                        ('$username')";
        // =========INSERTING INTO ============
        // if ($conn->query($sql_insert) === TRUE) {
        //     echo "New record created successfully. <br>";
        // } else {
        //     echo "Error: " . $sql_insert . "<br>" . $conn->error . "<br>";
        // }
        
        // SELECT (col1, col2) FROM table WHERE ...
        $tblName = "accounts";
        $sql_read = "SELECT * FROM " . $tblName . " " .
                    "WHERE 
                        username='" . $input_username . "' " . 
                    "AND password='" . $input_password ."';";

        echo "<br>qry:" . $sql_read . "<br><br>";
        $result = $conn->query($sql_read);
        if ($result) {
            if ($result->num_rows > 0) {
                // SUCCESFUL LOGIN!!!


                echo "Found username entry";
                while ($row = $result->fetch_assoc()) {
                    print_r($row);
                    echo "<br>";
                }
                // TODO: GIVE TOKEN HERE
                

                // set destination and leave this file
                header("Location: ../../main.php");
                return;
            } else {
                // No such row in table matching parameters; i.e. incorrect login info
                echo "Could not find matching parameters: " . $sql_read . "<br>";
            }
        } else {
            // Error finding result
            echo "Error: " . $sql_insert . "<br>" . $conn->error . "<br>";
        }
        $conn->close();
    }
    header("Location: ../../signin.php");
    exit();
?>
<?php
    echo "in php, comparing request <br>";
    echo "Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $serverName = "18.189.211.159:3306";
        $username = "guest";
        $password = "KCKMakk_4";
        echo "Connecting to " . $serverName . "<br>";
        // $serverName = "localhost:3306";
        // $username = "root";
        // $password = "";

        // connection to server
        // $pdo = new PDO('mysql:host='.$serverName.";dbname=".$dbname."', '". $username ."', '" . $password . "'");

        $conn = new mysqli($serverName, $username, $password); 
        if ($conn->connect_error) {
            // header("Location: ../../signin.php");
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "made it to server <br>";
        }

        $dbName = "rangerswatch";
        echo "Creating DB<br>";
        // ====Creating a database====
        $sql = "CREATE DATABASE IF NOT EXISTS " . $dbName;
        // if ($conn->query($sql) === TRUE)
        //     echo "Database created <br>";
        // else   
        //     echo "Database failed: " . $conn->connect_error . "<br>";   
        $conn->close();


        // connection to database
        echo "Connecting to DB<br>";
        $conn = new mysqli($serverName, $username, $password, $dbName); 
        if ($conn->connect_error) {
            // header("Location: ../../signin.php");
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "made it to database! <br>";

            $sql = "CREATE TABLE accounts (
                    username VARCHAR(30) PRIMARY KEY NOT NULL(
                )";
        }

        // here we can do some funky stuff to fiddle with the db
        $conn->close();
    }
    // header("Location: ../../signin.php");
    exit();
?>
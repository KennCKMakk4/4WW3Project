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

        // arraykey = name, type, tmp_name, error, size
        // tmp_name is the file location
        if (isValidEntry($_FILES['input_image']['name'])) {
            $extension = "." . strtolower(pathinfo($_FILES['input_image']['name'], PATHINFO_EXTENSION));
            // generating new name for files
            $input_image = "img_" . str_replace(' ', '', strtolower($input_name)) . $extension;
            $input_image_dir = $_FILES['input_image']['tmp_name'];
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
        echo "input_image_dir=" . $input_image_dir . "<br>";

        // handling non-required values if there is something present
        $input_phone = "";
        if (isValidEntry($_POST['input_phone'])) {
            $input_phone = $_POST['input_phone'];
        }

        $input_email = "";
        if (isValidEntry($_POST['input_email'])) {
            $input_email = $_POST['input_email'];
        }

        $input_address = "";
        if (isValidEntry($_POST['input_address'])) {
            $input_address = $_POST['input_address'];
        }

        $input_video = "";
        if (isValidEntry($_FILES['input_video']['name'])) {
            $extension = "." . strtolower(pathinfo($_FILES['input_video']['name'], PATHINFO_EXTENSION));
            // new name for file
            $input_video = "vid_" . str_replace(' ', '', strtolower($input_name)) . $extension;
            $input_video_dir = $_FILES['input_video']['tmp_name'];
        }

        // UPLOADING FILES
        $target_dir = "../../uploaded/img/";              // name of destination
        $target_file = $target_dir . $input_image;        // name of destination + file
        if (move_uploaded_file($input_image_dir, $target_file)) {
            echo "Successful creation of img @ " . $target_file . "<br>";

            if (isValidEntry($_FILES['input_video']['name'])) {
                $target_dir = "../../uploaded/video/";              // name of destination
                $target_file = $target_dir . $input_video; // name of destination + file
                if (move_uploaded_file($input_video_dir, $target_file)) {
                    echo "Successful creation of video @ " . $target_file . "<br>";
                } else {
                    $_SESSION['status_message'] = "Failed to upload image during submission";
                }
            }
            echo "Files uploaded - inserting into DB<br>";
        // connecting to db to insert record
            try {
                // connecting to db
                $serverName = "18.189.211.159:3306";
                $username = "guest";
                $password = "KCKMakk_4";
                $dbName = "rangerswatch";
                // connection to database
                $conn = new PDO("mysql:host=".$serverName .";dbname=" . $dbName, $username, $password);         
                echo "made it to database! <br>";

                $tblName = "locations";
                $sql_insert = "INSERT INTO " . $tblName . " " . 
                                "(name, about, latitude, longitude, username, image, video, phone, email, address) " .
                            "VALUES
                                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                echo "<br>qry:" . $sql_insert . "<br><br>";
                $vals = array($input_name, $input_about, $input_latitude, $input_longitude, $input_username, $input_image, 
                            $input_video, $input_phone, $input_email, $input_address);
                // =========INSERTING INTO ============
                $stmt = $conn->prepare($sql_insert);
                if ($stmt->execute($vals)) {
                    // Succesful insert
                    echo "New record created successfully. Going to the new object!... <br>";
                    $sql_getnew = "SELECT * FROM " . $tblName . " WHERE (`name` LIKE ?)";
                    $stmt2 = $conn->prepare($sql_getnew);
                    $stmt2->bindValue(1, "%{$input_name}");
                    $id = 0;
                    if ($stmt2->execute()) {
                        if ($stmt2->rowCount() > 0) {
                            $result = $stmt2->fetch();
                            $id = $result['id'];
                        }
                    }
                    header("Location: ../../object.php?id=" . $id);
                    return;
                }

                // Finished uploading files and submitting...
                $conn = null;
            }  catch (PDOException $e) {
                $error = $e->errorInfo[2];
                // changing error msg based on type
                if (strpos($error, "locations.name"))
                    $error = "There is already an existing place with the same name";
    
                errorReceived($error);
            }

        } else {
            // File upload failed
            errorReceived("Failed to upload image during submission");
        }
        
    }
    exit();
?>
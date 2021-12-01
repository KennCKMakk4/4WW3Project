<?php
    // An old version that considered sending and storing image/video files on the database

    // uploading an image; setting parameters
    // img_location used for id
    $modified_imagedir = addslashes(file_get_contents($input_image_dir));
    $sql_insert = 
        "INSERT INTO " . $tblName . " " . 
            "(name, file, filetype) " .
        "VALUES
            ('$input_image', '$modified_imagedir', '0');";
    if ($conn->query($sql_insert) === TRUE) {
        echo "Successful upload of image<br>";
    } else {
        echo "Image failed to upload: " . $conn->error . "<br>";
    }
    
    $image_name = "img_HamiltonArcheryCentre";
    $sql_getimg1 = "SELECT * FROM `files` WHERE `name` LIKE '$image_name' AND `filetype`=0";
    echo "<br>qry:" . $sql_getimg1 . "<br><br>";
    $result = $conn->query($sql_getimg1);
    if ($result) {
        if ($result->num_rows>0) {
            echo "Data received! s=" . $result->num_rows . "<br>";
            $row = $result->fetch_assoc();
            $filedata = base64_encode($row['file']);
            echo "IMAGE: <br><img src='data:image/jpg;charset=utf8;base64,".$filedata."'/><br>";
        } else {
            echo "No data received: " . $result->num_rows . "<br>";
        } 
    } else {
        echo "Failed to connect to db: " . $conn->error . "<br>";
    }
?>
<?php
// quick function to get a location with given name
if ($_SERVER["REQUEST_METHOD"] == "GET") {
				echo "method = get<br>";

				// get values from form, and check if they are valid
				$sqlFilters = "";

				// building query string from search_name and search_loc
				if (isValidEntry($_GET['input_search_name'])) {
					$input_name = $_GET['input_search_name'];
					$sqlFilters = " WHERE (`name`='" . $input_name . "')";
					// $sqlFilters = " WHERE (`name` LIKE '%" . $input_name . "%')";
				}

				// connecting to db
				$serverName = "18.189.211.159:3306";
				$username = "guest";
				$password = "KCKMakk_4";
				$dbName = "rangerswatch";
				$conn = new mysqli($serverName, $username, $password, $dbName); 
				if ($conn->connect_error) {
					errorReceived("Failed to connect to database");
					die("Connection failed: " . $conn->connect_error);
				} else {
					echo "made it to database! <br>";
				}

				// SELECT (col1, col2) FROM table WHERE ...
				$tblName = "locations";
				$sql_read = "SELECT * FROM " . $tblName . $sqlFilters . ";";
				echo "<br>qry:" . $sql_read . "<br><br>";
				$result = $conn->query($sql_read);
				if ($result) {
					if ($result->num_rows > 0) {
						// SUCCESFUL LOGIN!!!
						echo "Found stuff entry<br>";
						print_r($result);
						// get first row
						echo "<br><br>";
						$row = $result->fetch_assoc();
						print_r($row);
					} else {
						echo "No results";
					}
					
				} else {
					echo "Query failed";
				}
			}
?>
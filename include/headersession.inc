    <header>
        <div class="header_title"> 
            <h1 class="header1Session_text">Ranger's Watch</h1>
            <h3 class="header3Session_text"> Logged in as: <?php echo $_SESSION['fullname']; ?> </h3>
        </div>

        <div class="nav_menu">
            <!-- return to home page -->
            <a href="main.php">
                <div class="nav_button">
                    <i class="material-icons">home</i>
                    <p class="nav_button_text">Home</p>
                </div>
            </a>
            <!-- return to search page -->
            <a href="search.php">
                <div class="nav_button">
                    <i class="material-icons">search</i>
                    <p class="nav_button_text">Search</p>
                </div>
            </a>
            <!-- submit new location -->
            <a href="submission.php">
                <div class="nav_button">
                    <i class="material-icons">add</i>
                    <p class="nav_button_text">Submit</p>
                </div>
            </a>
            <!-- account login -->
            <a href="signout.php">
                <div class="nav_button">
                    <i class="material-icons">logout</i>
                    <p class="nav_button_text">Sign Out</p>
                </div>
            </a>
        </div>
    </header>
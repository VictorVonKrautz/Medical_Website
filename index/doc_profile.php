<?php
    session_start();
    if($_SESSION['loggedin'] != true  or $_SESSION['role'] != "Doc") {
        header("Location: login.php");
    }
    $dbhost = getenv("DBHOST");
    $dbuser = getenv("DBUSER");
    $dbpass = getenv("DBPASS"); 
    $dbname = getenv("DBNAME");
    $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
    
    mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");
    $query1 = "SELECT Doc_First, Doc_Last FROM doctor WHERE Doc_ID = '".$_SESSION['id']."' LIMIT 1";
    $result = $link->query($query1);
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="styles/profile_nav.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body onload="load_html('doc_card.php')">
<?php
if (isset($_SESSION['status'])) {
    echo "<script>alert('".$_SESSION['status']."');</script>";
    unset($_SESSION['status']);
}
?>
    <div class="profile-navbar profile-shadow">
        <div class="profile-div-w">
            <a href="home.php">
                <h1 class="profile-logo">Clinico</h1>
            </a>
        </div>
        <div class="profile-div-w2">
            <button onclick="show()" class="profile-nav-logout">Logout</button>
            <a href="../backend/logout.php"><button id="confirm" class="profile-confirm">Are you sure?</button></a>
        </div>
    </div>
    <script>
        function show() {
            document.getElementById("confirm").classList.toggle("profile-show");
        };
    </script>
    <div class="profile-sidenav profile-shadow">

        <div class="profile-welcome">
            <p>Welcome, </p>
            <span><?php foreach($result as $row){ echo $row["Doc_First"]. " " .$row["Doc_Last"]; }?></span>
        </div>

        <a class="profile-menu-item">
            <span>Profile</span>
            <span class="profile-arrow">></span>
        </a>
        <div class="profile-submenu">
            <a href ="#" class="profile-submenu-item" onclick="load_html('doc_card.php')">View Profile</a>
            <a href ="#" class="profile-submenu-item" onclick="load_html('/backend/edit_doctor_profile.php')">Edit Profile</a>
            <a href ="#" class="profile-submenu-item" onclick="load_html('../backend/Change_Password_doctor\.php')">Change Password</a>
        </div>

        <a class="profile-menu-item">
            <span>Patients</span>
            <span class="profile-arrow">></span>
        </a>
        <div class="profile-submenu">
            <a href ="#" class="profile-submenu-item" onclick="load_html('/backend/show_patients_doctor.php')">Show Patients</a>
            <a href ="#" class="profile-submenu-item" onclick="load_html('/backend/show_prescriptions.php')">Show Prescription</a>
        </div>

        <a class="profile-menu-item">
            <span>Appointments</span>
            <span class="profile-arrow">></span>
        </a>
        <div class="profile-submenu">
            <a href ="#" class="profile-submenu-item" onclick="load_html('/backend/show_appointments_doctor.php')">Show Appointments</a>  
            <!-- <a href ="#" class="profile-submenu-item" onclick="load_html()">Lorem Ipsum</a> -->
        </div>

        <!-- <a class="profile-menu-item">
            <span>Lorem Ipsum</span>
            <span class="profile-arrow">></span>
        </a>
        <div class="profile-submenu">
            <a href ="#" class="profile-submenu-item" onclick="load_html()">Lorem Ipsum</a>
            <a href ="#" class="profile-submenu-item" onclick="load_html()">Lorem Ipsum</a>
        </div> -->
    </div>
    <div id="content" class="profile-main">
        
    </div>
    <script>
        var dropdown = document.getElementsByClassName("profile-menu-item");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("profile-active");
                var arrow = this.querySelector(".profile-arrow");
                arrow.classList.toggle("profile-open");
                var dropdownContent = this.nextElementSibling;
                
                if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
                } else {
                dropdownContent.style.display = "block";
                }
            });
        }

        function load_html(file) {
            document.getElementById("content").innerHTML = "";
            $("#content").load(file);
        }
    </script>
</body>
<?php include "templates/header.php"; ?>

<?php

echo "Check out our awesome weekly calendar: ";
echo "<a href=\"weekly.php\"><strong>Weekly calendar</strong></a>";
echo "</br>";
echo "Login for more functions:";
echo "<a href=\"login.php\"><strong>Login</strong></a>";


if ($_SESSION['role'] != 'admin'){
    echo "<h3>Admin only functions:</h3>";
   echo "<div><a href=\"approve.php\"><strong>Approve changes</strong></a></div>";
}

if (!($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moderator')){
    echo "<h3>Moderator functions:</h3>";
    echo "<div><a href=\"update-lectures.php\"><strong>Update lectures</strong></a></div>";
    echo "<div><a href=\"log.php\"><strong>View changes history</strong></a></div>";
}

 ?>

<?php include "templates/footer.php"; ?>
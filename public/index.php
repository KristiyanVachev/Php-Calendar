<?php include "templates/header.php"; ?>

<?php

if ($_SESSION['role'] != 'admin'){
   echo "<div><a href=\"approve.php\"><strong>Approve changes</strong></a></div>";
}

if (!($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moderator')){
    echo "<div><a href=\"update-lectures.php\"><strong>Change lectures</strong></a></div>";
    echo "<div><a href=\"log.php\"><strong>Change log</strong></a></div>";
}

echo "<div><a href=\"weekly.php\"><strong>Weekly calendar</strong></a></div>";


 ?>

<?php include "templates/footer.php"; ?>
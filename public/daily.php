<?php

require "../config.php";
require "../common.php";

if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_GET['id'];

        if ($id < 1 || $id > 5){
            header("Location: notFound.php");
        }

        $sql = "SELECT *
                FROM lectures
                WHERE lectureStatus = 'active' AND dayId = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
else{
    echo 'not found';
    header("Location: notFound.php");
}
?>
<?php require "templates/header.php"; ?>


<?php
echo "<a href=\"weekly.php\">Back to weekly view</a>";

switch ($id){
    case 1:
        echo "<h3>Monday</h3>";
        break;
    case 2:
        echo "<h3>Tuesday</h3>";
        break;
    case 3:
        echo "<h3>Wednesday</h3>";
        break;
    case 4:
        echo "<h3>Thursday</h3>";
        break;
    case 5:
        echo "<h3>Friday</h3>";
        break;
}

    echo "<div class=\"day-container\">";


    echo "<div class=\"day\">";

    for ($hour = 9; $hour <= 19; $hour++) {
        echo "<div class=\"day-hour\">$hour:00</div>";
    }

    echo "</div>";

    echo "<div class=\"day\">";

    $noLectures = true;

    for ($hour = 9; $hour <= 19; $hour++) {
        echo "<div class=\"hour\">";

        foreach ($result as $lecture) :
            if ($lecture["startHour"] == $hour){
                $noLectures = false;

                echo "<div class=\"event event-start event-end\" data-span=",$lecture["duration"], "><b>", $lecture["subjectName"], "</b> - <i>", $lecture["semesterRoom"], "</i> - ", $lecture["lecturerName"], "</div>";
            }
        endforeach;

        if ($noLectures && $hour == 19){
            echo "<div > No lectures today</div>";
        }
        echo "</div>";
    }

    echo "</div>";

    echo "</div>";


<?php

require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
            FROM lectures
            WHERE lectureStatus = 'active'";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<a href="index.php">Back to home</a>

        <?php
        for ($day = 1; $day <= 5; $day++) {

            echo "<div class=\"day-container\">";

                switch ($day){
                    case 1:
                        echo "<h3><a href=\"daily.php?id=1\">Monday</a></h3>";
                    break;
                    case 2:
                        echo "<h3><a href=\"daily.php?id=2\">Tuesday</a></h3>";
                    break;
                    case 3:
                        echo "<h3><a href=\"daily.php?id=3\">Wednesday</a></h3>";
                    break;
                    case 4:
                        echo "<h3><a href=\"daily.php?id=4\">Thursday</a></h3>";
                    break;
                    case 5:
                        echo "<h3><a href=\"daily.php?id=5\">Friday</a></h3>";
                    break;
                }

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
                                    if ($lecture["startHour"] == $hour && $lecture["dayId"] == $day){
                                        $noLectures = false;

                                        echo "<div class=\"event event-start event-end\" data-span=",$lecture["duration"], "><b>", $lecture["subjectName"], "</b> - <i>", $lecture["semesterRoom"], "</i>", "</div>";
                                    }
                            endforeach;

                        if ($noLectures && $hour == 19){
                            echo "<div > No lectures today</div>";
                        }
                        echo "</div>";
                    }

                    echo "</div>";

            echo "</div>";
        }?>


<?php require "templates/footer.php"; ?>
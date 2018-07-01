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
        for ($day = 1; $day <= 7; $day++) {

            echo "Monday";

            echo "<div class=\"day\">";

                for ($hour = 9; $hour <= 19; $hour++) {
                    echo "<div class=\"day-hour\">$hour:00</div>";
                }

            echo "</div>";

            echo "<div class=\"day\">";

                for ($hour = 9; $hour <= 19; $hour++) {
                    echo "<div class=\"hour\">";
                    $noLectures = true;

                    foreach ($result as $lecture) :
                                if ($lecture["startHour"] == $hour && $lecture["dayId"] == $day){
                                    $noLectures = false;
                                    $span = $lecture["endHour"] - $lecture["startHour"];
                                    echo "<div class=\"event\" data-span=",$span ,">",$lecture["subjectName"] , "</div>";
                                }
                            endforeach;
                    if ($noLectures){
                    }
                    echo "</div>";
                }

                echo "</div>";
        }?>


<?php require "templates/footer.php"; ?>

<table border="1px">
    <tr>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>

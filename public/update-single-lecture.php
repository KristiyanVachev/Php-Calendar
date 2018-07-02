<?php

require "../config.php";
require "../common.php";

if (!($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moderator')){
    header("Location: login.php");
}

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $lecture =[
            "subjectName" => $_POST['subjectName'],
            "lecturerName"  => $_POST['lecturerName'],
            "room"     => $_POST['room'],
            "semesterRoom"       => $_POST['semesterRoom'],
            "startHour"  => $_POST['startHour'],
            "duration"  => $_POST['duration'],
            "dayId"  => $_POST['dayId'],
            "lectureStatus"  => 'pending',
            "editedId"  => $_GET["id"],
            "date"      => $_POST['date']
        ];

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "lectures",
            implode(", ", array_keys($lecture)),
            ":" . implode(", :", array_keys($lecture))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($lecture);


    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

}

if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_GET['id'];

        $sql = "SELECT * FROM lectures WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $oldLecture = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['subjectName']); ?> successfully updated. Waiting for administrator approval.</blockquote>
    <?php header("Location: update-lectures.php"); ?>

<?php endif; ?>
<a href="update-lectures.php">Back to lectures</a>

<h2>Edit a lecture</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

    <label>
        Subject name:
        <input type="text" value="<?php echo escape($oldLecture['subjectName']); ?>" maxlength="30" required name="<?php echo subjectName ?>"/>
    </label>

    <label>
        Lecturer name:
        <input type="text" value="<?php echo escape($oldLecture['lecturerName']); ?>" maxlength="30" required name="<?php echo lecturerName ?>"/>
    </label>

    <label>
        Room:
        <input type="text" value="<?php echo escape($oldLecture['room']); ?>" maxlength="30" required name="<?php echo room ?>"/>
    </label>

    <label>
        Semester Room:
        <input type="text" value="<?php echo escape($oldLecture['semesterRoom']); ?>" maxlength="30" required name="<?php echo semesterRoom ?>"/>
    </label>

    <label>
        Start hour:
        <input type="number" min="9" max="18" value="<?php echo escape($oldLecture['startHour']); ?>" required name="<?php echo startHour ?>"/>
    </label>

    <label>
        Duration:
        <input type="number" min="1" max="11" value="<?php echo escape($oldLecture['duration']); ?>" required name="<?php echo duration ?>"/>
    </label>

    <label>
        Day id:
        <input type="number" min="1" max="5" value="<?php echo escape($oldLecture['dayId']); ?>" required name="<?php echo dayId ?>"/>
    </label>

    <input type="submit" name="submit" value="Submit">
</form>

<?php require "templates/footer.php"; ?>

<?php

/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

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

/*        $sql = "UPDATE lectures
            SET id = :id, 
              subjectName = :subjectName
            WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->execute($lecture);*/

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

        $user = $statement->fetch(PDO::FETCH_ASSOC);
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
    <blockquote><?php echo escape($_POST['subjectName']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a lecture</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
        <?php
            //TODO don't show some values
            if ($key === 'LectureStatus'){
            }
        ?>
        <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
        <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

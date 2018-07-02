<?php

require "../config.php";
require "../common.php";

if (!($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moderator')){
    header("Location: login.php");
}

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM lectures";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Lectures log</h2>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Lecturer</th>
        <th>Room</th>
        <th>Semester room</th>
        <th>Start hour</th>
        <th>Duration</th>
        <th>Day id</th>
        <th>Status</th>
        <th>Date added</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["subjectName"]); ?></td>
            <td><?php echo escape($row["lecturerName"]); ?></td>
            <td><?php echo escape($row["room"]); ?></td>
            <td><?php echo escape($row["semesterRoom"]); ?></td>
            <td><?php echo escape($row["startHour"]); ?></td>
            <td><?php echo escape($row["duration"]); ?> </td>
            <td><?php echo escape($row["dayId"]); ?> </td>
            <td><?php echo escape($row["lectureStatus"]); ?> </td>
            <td><?php echo escape($row["date"]); ?> </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
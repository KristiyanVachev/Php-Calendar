<?php

/**
 * Delete a user
 */

require "../config.php";
require "../common.php";

if (isset($_GET["id"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_GET["id"];

        $sql = "UPDATE lectures
            SET lectureStatus = 'active'
            WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        //old lecture
        $sql = "SELECT * FROM lectures WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $lecture = $statement->fetch(PDO::FETCH_ASSOC);
        $editedLectureId = $lecture['editedId'];

        $sql = "UPDATE lectures
            SET lectureStatus = 'edited'
            WHERE id = $editedLectureId";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $success = "Lecture successfully updated";
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
            FROM lectures
            WHERE lectureStatus = 'pending'";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

    <h2>Approve lectures</h2>

<?php if ($success) echo $success; ?>

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
            <th>Approve</th>
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
                <td><a href="approve.php?id=<?php echo escape($row["id"]); ?>">Approve</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
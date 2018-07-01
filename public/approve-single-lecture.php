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

        $user =[
            "id"        => $_POST['id'],
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "age"       => $_POST['age'],
            "location"  => $_POST['location'],
            "date"      => $_POST['date']
        ];

        $sql = "UPDATE lectures
            SET lectureStatus = 'active'
            WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->execute($user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_GET['id'];

        //get pending lecture
        $sql = "SELECT * FROM lectures WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $lecture = $statement->fetch(PDO::FETCH_ASSOC);
        $editedLecture = $lecture['subjectName'];

        //get currently active lecture
        //$sql = "SELECT * FROM lectures WHERE name = $editedLecture AND lectureStatus = 'active'";
        //$statement = $connection->prepare($sql);
        //$statement->bindValue(':id', $id);
        //$statement->execute();


        $sql = "UPDATE lectures
            SET lectureStatus = 'active'
            WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->execute($user);


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
    <blockquote><?php echo escape($_POST['firstname']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
        <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
        <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

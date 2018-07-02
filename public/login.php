<?php

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "username"     => $_POST['username'],
            "pass"  => $_POST['pass']
        );

        $username = $_POST['username'];

        //get user by email
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $statement = $connection->prepare($sql);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        //$hash = password_hash('admin', PASSWORD_DEFAULT);
        //echo $hash;
        //$isValid = password_verify('admin', $user['pass']);

        if ($user["pass"] == $_POST['pass']){
            if ($user["username"] == 'admin'){
                $_SESSION['role'] = 'admin';
            }
            else{
                $_SESSION['role'] = 'moderator';
            }
            $_SESSION['session_start'] = time();

            header("Location: index.php");
        }
        else{
            echo "Wrong password or username";
        }
        //check password

    } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }

}

?>
<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
<?php endif; ?>

<h2>Login</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <label for="pass">Password</label>
    <input type="text" name="pass" id="pass">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

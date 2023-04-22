<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="/dashboard/assets/index.css">
    <link rel="stylesheet" href="/dashboard/assets/login.css">
    <link rel="stylesheet" href="/dashboard/assets/navbar.css">
</head>

<body>
    <?php include (__DIR__) . "/../navbar.php" ?>
    <div id="login">
        <h1>Sign Up</h1>
        <p>
            <?php // Check Credentials
            if (!empty($_POST['username']) || !empty($_POST['password']) || !empty($_POST['repeatpassword'])) {
                if ($_POST['password'] != $_POST['repeatpassword']) echo 'Passwords Do Not Match';
                else {
                    $exists = $db->prepare("SELECT COUNT(*) FROM accounts WHERE userName = :username");
                    $exists->execute(array(':username' => $_POST['username']));
                    if ($exists->fetchColumn() > 0) echo 'Username Already In Use';
                    else {
                        $password = password_hash($password, PASSWORD_BCRYPT);

                        $register = $db->prepare("INSERT INTO accounts (userName, password) VALUES (:username, :password)");
                        $register->execute(array(':username' => $_POST['username'], ':password' => $password));

                        $_SESSION['password'] = $password;
                        header('Location: /dashboard/');
                        exit;
                    }
                }
            }
            ?>
        </p>
        <form method="post">
            <input type="text" placeholder="Username" name="username" required />
            <input type="password" placeholder="Password" name="password" required />
            <input type="password" placeholder="Confirm Password" name="repeatpassword" required />
            <input type="submit" value="Sign Up"/>
        </form>
    </div>
</body>

<script src="/dashboard/assets/navbar.min.js"></script>

</html>
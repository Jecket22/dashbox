<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="/dashboard/assets/index.css">
    <link rel="stylesheet" href="/dashboard/assets/login.css">
    <link rel="stylesheet" href="/dashboard/assets/navbar.css">
</head>

<body>
    <?php include (__DIR__) . "/../navbar.php" ?>
    <div id="login">
        <h1>Log In</h1>
        <p>
            <?php // Check Credentials
            if (!empty($_POST['username']) || !empty($_POST['password'])) {
                $requireVerified = strval((Config::GetVariable("accounts", "verifyLevel") != 0) ? 1 : 0);

                $login = $db->prepare("SELECT password FROM accounts WHERE username = :username AND verified >= :requireVerified");
                $login->execute(array(':username' => $_POST['username'], ':requireVerified' => $requireVerified));
                $password = $login->fetchColumn();

                if (empty($password)) echo 'Username or Password Incorrect';
                else {
                    if (!password_verify($_POST['password'], $password)) echo 'Username or Password Incorrect';
                    else {
                        $_SESSION['password'] = $password;
                        header('Location: http://' . $_SERVER['SERVER_NAME'] . '/dashboard/');
                        exit;
                    }
                }
            }
            ?>
        </p>
        <form method="post">
            <input type="text" placeholder="Username" name="username" required />
            <input type="password" placeholder="Password" name="password" required />
            <input type="submit" value="Log In" />
        </form>
    </div>
</body>

<script src="/dashboard/assets/navbar.min.js"></script>

</html>
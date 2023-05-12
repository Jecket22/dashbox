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
    <?php // Already logged in?
        if ($alreadyLoggedIn) {
            header('Location: /dashboard/');
            exit;
        }
    ?>
    <div id="login">
        <h1>Log In</h1>
        <p>
            <?php // Check Credentials
            if (isset($_POST['username']) || isset($_POST['password'])) {
                $login = $db->prepare("SELECT password, verified FROM accounts WHERE username = :username");
                $login->execute(array(':username' => $_POST['username']));
                $login = $login->fetch();

                if (!password_verify($_POST['password'], $login['password'])) echo 'Username or Password Incorrect';
                else {
                    if ($login['verified'] < Config::GetVariable('accounts', 'verifyLevel')) echo 'Account not Verified';
                    else {
                        $_SESSION['password'] = $login['password'];
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
            <input type="submit" value="Log In" />
        </form>
    </div>
</body>

<script src="/dashboard/assets/navbar.min.js"></script>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/dashboard/assets/index.css">
    <link rel="stylesheet" href="/dashboard/assets/navbar.css">
</head>

<body>
    <?php include (__DIR__) . "/navbar.php" ?>
    <div class="content">
        <?php print_r($_SESSION) ?>
    </div>
</body>

<script src="/dashboard/assets/navbar.min.js"></script>

</html>
<?php
    session_start();

    if(isset($_SESSION["id"]))
    {
        header("Location: ../panel.php"); exit;
    }

    require_once ("../php_scripts/config.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
</head>
    <body>
        <form action="../php_scripts/process_auth.php" method="post">
            <label for="login">Логин</label>
            <input type="text" name="login" value="<?php echo $login; ?>" id="login">

            <label for="password">Пароль</label>
            <input type="password" name="password" value="<?php echo $password; ?>" id="password">

            <button type="submit" name="process_auth">Авторизоаваться</button>
        </form>
    </body>
</html>

<?php
    session_start();
    if(isset($_SESSION['id']))
    {
        header("Location: ../index.php"); exit;
    }

    require_once("../php_scripts/config.php");

    global $login;
    global $password;
    global $error;

    if (isset($_POST["process_auth"])) {
        echo $_POST["process_auth"];
        $login = trim(htmlspecialchars($_POST["login"]));
        $password = trim(htmlspecialchars($_POST["password"]));

        if ($login && $password) {
            $sql = "select * from admin where login = :login;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":login", $login);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_LAZY);

            if ($result["passwd"] == md5($password)) {
                $_SESSION["id"] = $result["id"];
                header("Location: ../panel/panel.php");
            } else {
                $error[] = "Неправильный пароль.";
                header("Location: ../panel/auth.php");
            }
            exit;
        } else {
            $error[] = "Неправильный логин или пароль.";
            header("Location: ../panel/auth.php");
        }
        exit;
    }

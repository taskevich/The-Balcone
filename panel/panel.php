<?php
    session_start();
    $is_auth = isset($_SESSION["id"]) ? 1 : 0;

    if (!$is_auth)
    {
        header("Location: ../index.php"); exit;
    }

    require_once("../php_scripts/config.php");
    require_once("../php_scripts/requests.php");

    $sql = "select * from good_table;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result_good = $stmt->fetchAll();

    $sql = "select * from photo_table;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result_photo = $stmt->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/panel.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Панель управления</title>
</head>
    <body>
        <div class="header">
            <h1 class="logo">THE БАЛКОНЫ - ПАНЕЛЬ</h1>
        </div>

        <div class="posts">
            <a edit=0 id="myBtn">Добавить пост</a>
            <div id="myModal" class="modal">
                <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">&times;</span>
                        </div>
                        <div class="modal-body">
                            <form id="actionForm" method="POST" enctype="multipart/form-data">
                                <label for="title">Заголовок</label>
                                <input type="text" name="title" id="title" value="">

                                <label for="description">Описание</label>
                                <textarea type="text" name="description" id="description"></textarea>

                                <label for="upImage">Изображение</label>
                                <input type="file" id="upImage" name="upImage[]" multiple >

                                <div id="photos">

                                </div>

                                <button id="doneBtn" type="nan" type="submit" name="upload_process"></button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
            <?php foreach ($result_good as $key => $value) { ?>
                <div class="post">
                    <img src="<?php echo $result_photo[$key]["path_to_photo"]; ?>" alt="img">
                    <h1><?php echo $value["title"];?></h1>
                    <p><?php echo $value["description"];?></p>
                    <a id="myBtn" edit=1 goodId="<?php echo $value["id"];?>">Редактировать пост</a>
                </div>
            <?php } ?>
        </div>

        <script src="../scripts/jquery-3.6.3.js"></script>
        <script src="../scripts/scripts.js"></script>
    </body>
</html>

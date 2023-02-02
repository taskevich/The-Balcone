<?php
    session_start();
    $is_auth = isset($_SESSION["id"]) ? 1 : 0;

    if (!$is_auth)
    {
        header("Location: ../index.php"); exit;
    }

    require_once("../php_scripts/config.php");
    require_once("../php_scripts/requests.php");

    $sql_goods = "select * from good_table left join photo_table pt on good_table.id = pt.goodId group by goodId;";
    $stmt = $conn->prepare($sql_goods);
    $stmt->execute();
    $result_good = $stmt->fetchAll();
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
            <a id="myBtn">Добавить пост</a>
            <?php if (isset($_GET["error"])) { ?>
                <div class="error"><?php echo $_GET["error"];?></div>
            <?php } ?>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="actionForm" method="POST" action="./upload.php" enctype="multipart/form-data">
                            <label for="title">Заголовок</label>
                            <input type="text" name="title" id="title" value="">

                            <label for="description">Описание</label>
                            <textarea name="description" id="description"></textarea>

                            <label for="upImage">Изображение</label>
                            <input type="file" id="upImage" name="upImage[]" multiple >

                            <div id="photos"></div>

                            <button id="doneBtn" type="submit" name="upload_process">Добавить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php foreach ($result_good as $k => $v) { ?>
            <div class="post">
                <img
                        src="<?php echo $v["path_to_photo"]; ?>"
                        alt="img">
                <h1><?php echo $v["title"];?></h1>
                <p><?php echo $v["description"];?></p>
                <?php if ($v["is_visible"]) { ?>
                    <button id="hidePost" goodId="<?php echo $v["goodId"];?>">Скрыть пост</button>
                <?php } else { ?>
                    <button id="showPost" goodId="<?php echo $v["goodId"];?>">Показать пост</button>
                <?php } ?>
                <a href="./detail.php?id=<?php echo $v["goodId"];?>">Редактировать пост</a>
                <button id="deletePost" goodId="<?php echo $v["goodId"];?>">&times;</button>
            </div>
        <?php } ?>

        </div>

        <script src="../scripts/jquery-3.6.3.js"></script>
        <script src="../scripts/scripts.js"></script>
    </body>
</html>

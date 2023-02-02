<?php
    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../index.php"); exit;
    }

    require_once("../php_scripts/config.php");

    if (isset($_GET["id"])) {
        $sql = "select * from good_table left join photo_table pt on good_table.id = pt.goodId where goodId = :id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue("id", $_GET["id"]);
        $stmt->execute();
        $good_result = $stmt->fetchAll();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/panel.css">
    <title><?php echo $good_result[0]["title"]; ?></title>
</head>
<body>
<div class="wrapper">
    <a href="./panel.php" style="height: 100%;margin-top: 20px;">Назад</a>
    <div class="container">
        <form method="POST" enctype="multipart/form-data" action="./edit.php?id=<?php echo $_GET["id"]; ?>">

            <div class="title">
                <p>Заголовок</p>
                <input type="text" name="title" id="title" value="<?php echo $good_result[0]["title"]; ?>">
            </div>
            <div class="description">
                <p>Описание</p>
                <textarea name="description" id="description" cols="30" rows="10"><?php echo $good_result[0]["description"]; ?></textarea>
            </div>
            <div class="button">
                <input type="file" id="upImage" name="upImage[]" multiple >
                <button type="submit" id="doneEdit" name="edit_process">Сохранить</button>
            </div>
        </form>
        <div class="image">
            <div class="image_button">
                <p>Загруженные фотографии</p>
                <div class="button_image">
                    <button id="showImage">Показать фото</button>
                    <button id="hideImage">Скрыть фото</button>
                </div>
            </div>
            <div id="image_grid" class="image_grid">
                <?php foreach ($good_result as $key => $value) {?>
                    <img class="<?php echo ($value["status"] == 0) ? "hided_image" : ""; ?>"
                         status="<?php echo $value["status"];?>" imageId="<?php echo $value["id"];?>"
                         src="<?php echo $value["path_to_photo"]; ?>"
                         width="200px" height="200px" alt="">
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="../scripts/jquery-3.6.3.js"></script>
<script src="../scripts/scripts.js"></script>
<script src="../scripts/detail.js"></script>
<script>
    let goodId = <?php echo $_GET["id"]; ?>;
</script>
</body>
</html>

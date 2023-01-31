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

//        $sql = "select * from photo_table where goodId = :id";
//        $stmt = $conn->prepare($sql);
//        $stmt->bindValue("id", $_GET["id"]);
//        $stmt->execute();
//        $photo_result = $stmt->fetchAll();
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styles/panel.css">
    <title><?php echo $good_result[0]["title"]; ?></title>
</head>
    <body>
        <a href="./panel.php">Назад</a>
        <form method="POST" enctype="multipart/form-data" action="./edit.php?id=<?php echo $_GET["id"]; ?>">
            <label for="title">Заголовок</label>
            <input name="title" type="text" id="title" value="<?php echo $good_result[0]["title"]; ?>">

            <label for="description">Описание</label>
            <textarea name="description"
                      id="description" cols="30"
                      rows="10"><?php echo $good_result[0]["description"]; ?></textarea>

            <label for="upImage">Изображение</label>
            <input type="file" id="upImage" name="upImage[]" multiple >

            <div id="photos">
                <?php foreach ($good_result as $key => $value) {?>
                    <img class="<?php echo ($value["status"] == 0) ? "hided_image" : ""; ?>"
                         status="<?php echo $value["status"];?>" imageId="<?php echo $value["id"];?>"
                         src="<?php echo $value["path_to_photo"]; ?>"
                         width="200px" height="200px" alt="">
                <?php } ?>
            </div>

            <button id="hideImage">Скрыть фото</button>
            <button id="showImage">Показать фото</button>
            <button type="submit" id="doneEdit" name="edit_process">Сохранить</button>
        </form>

        <script src="../scripts/jquery-3.6.3.js"></script>
        <script src="../scripts/scripts.js"></script>
        <script src="../scripts/detail.js"></script>
        <script>
            let goodId = <?php echo $_GET["id"]; ?>;
        </script>
    </body>
</html>

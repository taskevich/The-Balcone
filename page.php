<?php
    session_start();
    require_once("./php_scripts/config.php");

    $is_auth = isset($_SESSION["id"]) ? 1 : 0;

    $sql = "select * from good_table left join photo_table pt on good_table.id = pt.goodId where goodId = :goodId and status = 1;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":goodId", $_REQUEST["postId"]);
    $stmt->execute();
    $result_good = $stmt->fetchAll();

    if ($result_good[0]["is_visible"] == 0) {
        header("Location: ./index.php"); exit;
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style_old.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>THE БАЛКОНЫ</title>
</head>
    <body>
        <div class="header_det">
            <div class="ghost"></div>
            <div class="logo">THE БАЛКОНЫ</div>
            <div class="icon"><img src="/call.png" alt="" srcset=""></div>
        </div>

        <div class="main">
            <div class="text_main">
                <h1><?php echo $result_good[0]["title"]; ?></h1>
                <?php
                    $description = explode("-", $result_good[0]["description"]);
                    foreach ($description as $word) {
                ?>
                    <p><?php  echo " - ".$word."\n"; ?></p>
                <?php } ?>
            </div>
            <div class="main_cards">
                <?php foreach ($result_good as $key => $value) { ?>
                    <div class="card Cards">
                        <img src="<?php echo $value["path_to_photo"]; ?>" alt="">
                    </div>
                <?php } ?>
            </div>

        </div>

        <div class="footer">
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                    </div>
                    <div class="modal-body">
                        <a href="#">Телеграм</a>
                        <a href="#">WhatsApp</a>
                        <a href="#">Vk</a>
                    </div>
                </div>
            </div>
            <h1>Хочу так же!</h1>
            <p class="text">Для начала запишитесь на консультацию</p>
            <div class="button_lib">
                <button id="myBtn">Звонок</button>

                <button>Хочу дешевле</button>
            </div>
        </div>
        <script src="./scripts/jquery-3.6.3.js"></script>
        <script src="./scripts/scripts.js"></script>
    </body>
</html>

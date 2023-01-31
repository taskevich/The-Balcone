<?php
    session_start();
    require_once("./php_scripts/config.php");

    $is_auth = isset($_SESSION["id"]) ? 1 : 0;

    $sql = "select * from good_table left join photo_table pt on good_table.id = pt.goodId where goodId = :goodId and status = 1;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":goodId", $_REQUEST["postId"]);
    $stmt->execute();
    $result_good = $stmt->fetchAll();
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
                <p><?php echo $result_good[0]["description"]; ?></p>
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
            <h1>Хочу так же!</h1>
            <p class="text">Для начала запишитесь на консультацию</p>
            <button>Звонок</button>
            <div class="footer_contact">
                <p>THE БАЛКОНЫ</p>
                <div class="icon"><img src="/call.png" alt="" srcset=""></div>
            </div>
        </div>
    </body>
</html>

<?php
    session_start();

    $is_auth = isset($_SESSION["id"]) ? 1 : 0;

    require_once("./php_scripts/config.php");

    if ($conn != null)
    {
        $sql_goods = "select * from good_table left join photo_table pt on good_table.id = pt.goodId where is_visible = 1 group by goodId;";
        $stmt = $conn->prepare($sql_goods);
        $stmt->execute();
        $res_goods = $stmt->fetchAll();
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
        <div class="header">
            <div class="ghost"></div>
            <div class="logo">THE БАЛКОНЫ</div>
            <div class="icon"><img src="/call.png" alt="" srcset=""></div>
        </div>

        <div class="cards">
            <?php foreach($res_goods as $key => $value) { ?>
                <a class="card shadow title-photo" href="./page.php?postId=<?php echo $value["goodId"]; ?>">
                    
                    <img src="<?php echo $value["path_to_photo"]; ?>" alt="">
                    <div class="title_div">
                        <p><?php echo $value["title"]; ?></p>
                    </div>
                    
                </a>
            <?php } ?>
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

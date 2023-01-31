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
                <a class="card shadow" href="./page.php?postId=<?php echo $value["goodId"]; ?>"><img src="<?php echo $value["path_to_photo"]; ?>" alt=""></a>
            <?php } ?>
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

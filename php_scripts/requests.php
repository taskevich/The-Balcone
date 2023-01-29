<?php
    require_once("../php_scripts/config.php");

    if (isset($_GET["goodId"]))
    {
        $sql = "select * from good_table where id = :goodId;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":goodId", $_GET["goodId"]);
        $stmt->execute();
        $good_res = $stmt->fetch();


        $sql = "select * from photo_table where goodId = :goodId;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":goodId", $_GET["goodId"]);
        $stmt->execute();
        $photo_res = $stmt->fetchAll();

        $acc_package = array("good" => $good_res, "photo" => $photo_res);
        $output[] = $acc_package;
        print(json_encode($output));
    }

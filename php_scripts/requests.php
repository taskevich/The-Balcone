<?php
    require_once("../php_scripts/config.php");

    if (isset($_GET["goodId"]))
    {
        $sql = "select * from good_table where id = :goodId;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":goodId", $_GET["goodId"]);
        $stmt->execute();
        $good_res = $stmt->fetch();


        $sql = "select * from photo_table where goodId = :goodId";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":goodId", $_GET["goodId"]);
        $stmt->execute();
        $photo_res = $stmt->fetchAll();

        $acc_package = array("good" => $good_res, "photo" => $photo_res);
        $output[] = $acc_package;
        print(json_encode($output));
    }

    switch ($_POST["type"]) {
        case "showImage":
            for ($i = 0; $i < count($_POST["imageIds"]); ++$i) {
                $sql = "update photo_table set status = 1 where id = :id;";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":id", $_POST["imageIds"][$i]);
                $stmt->execute();
            }
            break;
        case "hideImage":
            for ($i = 0; $i < count($_POST["imageIds"]); ++$i) {
                $sql = "update photo_table set status = 0 where id = :id;";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":id", $_POST["imageIds"][$i]);
                $stmt->execute();
            }
            break;
        case "hidePost":
            $sql = "update good_table set is_visible = 0 where id = :id;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $_POST["goodId"]);
            $stmt->execute();
            break;
        case "showPost":
            $sql = "update good_table set is_visible = 1 where id = :id;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $_POST["goodId"]);
            $stmt->execute();
            break;
        case "deletePost":
            $sql = "delete from photo_table where goodId = :id;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $_POST["goodId"]);
            $stmt->execute();

            $sql = "delete from good_table where id = :id;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $_POST["goodId"]);
            $stmt->execute();
            break;
        default:
            break;
    }
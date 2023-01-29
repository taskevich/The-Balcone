<?php
    require_once("../php_scripts/config.php");

    if(isset($_POST["edit_process"])) {
        $id = $_GET["id"];
        $title = htmlspecialchars($_POST["title"]);
        $description = htmlspecialchars($_POST["description"]);

        if ($title && $description) {
            try {
                $sql = "update good_table set title = :title, description = :description where id = :id;";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":title", $title);
                $stmt->bindValue(":description", $description);
                $stmt->bindValue(":id", $id);
                $stmt->execute();

                if (!empty($_FILES["upImage"]["tmp_name"]) || !file_exists($_FILES['upImage']['tmp_name'])) {
                    foreach ($_FILES["upImage"]["error"] as $key => $error)
                    {
                        $target_dir = "../resources/";
                        $target_file = $target_dir . basename($_FILES["upImage"]["name"][$key]);
                        move_uploaded_file($_FILES["upImage"]["tmp_name"][$key], $target_file);

                        // insert path
                        $sql = "insert into photo_table (goodId, path_to_photo) values (?, ?);";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(":goodId", $id);
                        $stmt->bindValue(":path_to_photo", $target_file);
                        $stmt->execute();
                    }
                }
            } catch (PDOException $e) {
                echo "\nError: " . $e->getMessage() . "\n";
            }
        }
    }
    header("Location: ./panel.php");
    exit;



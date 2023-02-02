<?php
    require_once("../php_scripts/config.php");

    $target_dir = "../resources/";


    if(isset($_POST["edit_process"])) {
        $id = $_GET["id"];
        $title = htmlspecialchars($_POST["title"]);
        $description = htmlspecialchars($_POST["description"]);

        if ($title && $description) {
            try {
                $description = explode("-", $description);

                $sql = "update good_table set title = :title, description = :description where id = :id;";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":title", $title);
                $stmt->bindValue(":description", $description);
                $stmt->bindValue(":id", $id);
                $stmt->execute();

                $countfiles = count($_FILES['upImage']['name']);
                for ($i = 0; $i < $countfiles; $i++) {
                    $filename = $_FILES['upImage']['name'][$i];
                    $dst = $target_dir.$filename;
                    if (move_uploaded_file($_FILES['upImage']['tmp_name'][$i], $dst)) {
                        $sql = "insert into photo_table (goodId, path_to_photo) values (:goodId, :path_to_photo);";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(":goodId", $id);
                        $stmt->bindValue(":path_to_photo", $dst);
                        $stmt->execute();
                    }
                }
            } catch (PDOException $e) {
                echo "\nError: " . $e->getMessage() . "\n";
            }
        }
    }
    header("Location: ./detail.php?id=".$id);
    exit;



<?php
    require_once ("./config.php");

    $target_dir = "../resources/";

    if (isset($_POST["upload_process"]))
    {
        $title = $_POST["title"];
        $description = $_POST["description"];

        try {
            // insert base
            $sql = "insert into good_table (title, description, slug_url) values (:title, :description, :slug_url);";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":title", $_POST["title"]);
            $stmt->bindValue(":description", $_POST["description"]);
            $stmt->bindValue(":slug_url", str_replace(" ", "-", $_POST["title"]));
            $complete = $stmt->execute();

            if ($complete)
            {
                // get added element
                $sql = "select * from good_table where title = :title;";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":title", $title);
                $stmt->execute();
                $complete = $stmt->fetch(PDO::FETCH_LAZY);

                if ($complete)
                {
                    foreach ($_FILES["upImage"]["error"] as $key => $error)
                    {
                        $target_file = $target_dir . basename($_FILES["upImage"]["name"][$key]);
                        move_uploaded_file($_FILES["upImage"]["tmp_name"][$key], $target_file);

                        // insert path
                        $sql = "insert into photo_table (goodId, path_to_photo) values (:goodId, :path_to_photo);";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(":goodId", $complete["id"]);
                        $stmt->bindValue(":path_to_photo", $target_file);

                        $stmt->execute([$complete["id"], $target_file]);
                    }
                }
            }

        } catch (PDOException $e) {
            echo "\nError: ".$e->getMessage()."\n";
        }
        header("Location: ./panel/panel.php");
        exit;
    }

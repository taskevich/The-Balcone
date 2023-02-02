<?php
    require_once ("../php_scripts/config.php");
    require_once ("../php_scripts/features.php");

    $target_dir = "../resources/";
    if (isset($_POST["upload_process"]))
    {
        $title = htmlspecialchars($_POST["title"]);
        $description = htmlspecialchars($_POST["description"]);

        if (!$title || !$description) {
            var_dump($title);
            var_dump($description);
            header("Location: ./panel.php?error=Заполните все поля!"); exit;
        }

        if (!files_uploaded()) {
            var_dump($_FILES);
            header("Location: ./panel.php?error=Вы должны загрузить хотя бы одно фото."); exit;
        }

        try {
            // insert base
            $sql = "insert into good_table (title, description) values (:title, :description);";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":title", $_POST["title"]);
            $stmt->bindValue(":description", $_POST["description"]);
            $complete = $stmt->execute();

            if ($complete)
            {
                $id = $conn->lastInsertId();

                // get added element
                $sql = "select * from good_table where id = :id;";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":id", $id);
                $stmt->execute();
                $complete = $stmt->fetch(PDO::FETCH_LAZY);

                if ($complete)
                {
                    $countfiles = count($_FILES['upImage']['name']);
                    for ($i = 0; $i < $countfiles; $i++) {
                        $filename = $_FILES['upImage']['name'][$i];
                        $dst = $target_dir . $filename;
                        if (move_uploaded_file($_FILES['upImage']['tmp_name'][$i], $dst)) {
                            // insert path
                            $sql = "insert into photo_table (goodId, path_to_photo) values (:goodId, :path_to_photo);";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindValue(":goodId", $complete["id"]);
                            $stmt->bindValue(":path_to_photo", $dst);
                            $stmt->execute();
                        }
                    }
                }
            }

        } catch (PDOException $e) {
            echo "\nError: ".$e->getMessage()."\n";
        }
        header("Location: ./panel.php");
        exit;
    }

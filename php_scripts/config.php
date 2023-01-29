<?php
    try
    {
        $conn = new PDO("mysql:host=localhost;dbname=solarium_site", "root", "root");
    } catch (PDOException $e) {
        echo "Error: ".$e->getMessage();
    }
<?php

$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("DELETE FROM filmy  WHERE id_film = :id");
$stmt->bindParam("id", $_GET["id_film"]);
$stmt->execute();

echo "User was deleted ";


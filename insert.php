<?php

include "config.php";

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connect Successfully. Host info: " . $pdo->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS"));

} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

$sql = "SELECT * FROM tbl_register WHERE email= :email ";
$statement = $pdo->prepare($sql);

$statement ->bindvalue(':email', $_GET['email']);
$statement->execute();

$row = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($row==true) {
    echo "this user already exists";
} else {
    try {
        $sql = "INSERT INTO tbl_register (email, password) VALUES (:email, :password)";
        $statement = $pdo->prepare($sql);
    
        $statement->bindParam(':email', $_REQUEST['email']);
        $statement->bindParam(':password', $_REQUEST['password']);
    
        $statement->execute();
        echo "Records inserted successfully.";
    } catch (PDOException $e) {
        die("ERROR: Could not able to execute $sql. " .$e->getMessage());
    }
}

unset($pdo);
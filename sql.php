<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$sql = "SELECT * FROM myfriends";
$get = "SELECT firstname, lastname FROM myfriends WHERE friend_id = $id";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->setFetchMode((PDO::FETCH_NUM));
    
    while ($row = $stmt->fetch()) {
        echo "<tr><td>$row[0]</td></tr>";
    }
} catch (Exception $ex) {
    echo $sql."<br>".$ex->getMessage();
}
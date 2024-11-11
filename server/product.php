<?php
require_once './database.php';

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $db->readSingle($_GET['id']);
}
else {
    echo json_encode(['message'=> "wrong request method"]);
}
?>
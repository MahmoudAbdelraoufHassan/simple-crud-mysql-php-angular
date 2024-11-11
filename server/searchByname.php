<?php

require_once './database.php';



if($_SERVER['REQUEST_METHOD'] === "GET") {
    $keyword = $_GET['keyword'] ?? '';
    if(!empty($_GET['keyword'])){
        $db->searchByname($keyword);
    }
    else {
    $db->readAll();
    }
}

?>
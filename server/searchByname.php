<?php

require_once './database.php';

$page = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 1;

if($_SERVER['REQUEST_METHOD'] === "GET") {
    $keyword = $_GET['keyword'] ?? '';
    if(!empty($_GET['keyword'])){
        $db->searchByname($keyword);
    }
    else {
    $db->readAll($page);
    }
}

?>
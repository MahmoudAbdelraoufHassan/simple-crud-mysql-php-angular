<?php
require_once './database.php';
// $inputJSON = file_get_contents(filename: "php://input");
// parse_str($inputJSON , $inputs);
// $inputs = json_decode($inputJSON, true);
$page = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 1;
$inputs = $_POST;
$method = $_SERVER['REQUEST_METHOD'];
switch($method) {
    case "GET" :
    $db->readAll($page);
    break;

    case "POST" :
    $db->create($inputs['product_name'] , $inputs['product_desc'] , 
    $inputs['product_price'] , $inputs['discount'] , $inputs['quantity'] , $_FILES['thumbnail']);
    break;

    case 'PUT' :
        $db->updateProduct($inputs['id'],$inputs['product_name'] , $inputs['product_desc'] , 
        $inputs['product_price'] , $inputs['discount'] , $inputs['quantity'] , $_FILES['thumbnail']);
        break;
    
    case "DELETE" :
    $db->Delete(id: $_GET['id']);
    break;
}
?>


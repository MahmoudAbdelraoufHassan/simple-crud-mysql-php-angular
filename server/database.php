<?php 
header( 'Content-type:application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
class Database {
    private $connection;
    private $dbuser = 'root';
    private $dbpass = '12345678';
    private $dbhost = 'localhost';

    private $dbname = 'product_crud';
    private $stmt;
public function __construct() {
    try {
    $this->connection = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname" , $this->dbuser ,$this->dbpass);
    $this->connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e){
        echo json_encode(["Connection error: " => $e->getMessage()]);
    };
}
public function create($pr_name, $pr_desc, $pr_price, $discount, $q, $thumbnail) {
    if (empty($pr_name) || empty($pr_desc) || empty($pr_price) || empty($thumbnail) || empty($q) || empty($discount)) {
        echo json_encode(['error' => 'All input values are required']);
        return;
    }

    if (!is_string($pr_name)) {
        echo json_encode(['error' => 'Product name must be a string']);
        return;
    }
    if (!is_string($pr_desc)) {
        echo json_encode(['error' => 'Product description must be a string']);
        return;
    }

    if (isset($_FILES['thumbnail'])) { 
        $imageName = $_FILES['thumbnail']['name'];
        $imageSize = $_FILES['thumbnail']['size'];
        $extension = $_FILES['thumbnail']['type'];
        $imageTemp = $_FILES['thumbnail']['tmp_name'];
        
        $arr_ext = ['image/png', 'image/jpeg', 'image/jpg'];
        $target = 'uploads/';
        
        if (!in_array($extension, $arr_ext)) {
            echo json_encode(['error' => 'The image must be PNG, JPEG, or JPG']);
            return;
        }
        
        if ($imageSize > 4194304) {
            echo json_encode(['error' => 'The image size must be lower than 4MB']);
            return;
        }
        
        $filePath = $target . uniqid() . basename($imageName);
        if (!move_uploaded_file($imageTemp, $filePath)) {
            echo json_encode(['error' => 'Error uploading image']);
            return;
        }
    } else {
        echo json_encode(['error' => 'Thumbnail is required']);
        return;
    }
    if (!is_numeric($pr_price)) {
        echo json_encode(['error' => 'Price must be a number']);
        return;
    }
    if (!is_numeric($discount)) {
        echo json_encode(['error' => 'Discount must be a number']);
        return;
    }
    if (!is_numeric($q)) {
        echo json_encode(['error' => 'Quantity must be a number']);
        return;
    }

    $query = 'INSERT INTO products (product_name, product_desc, product_price, discount, quantity, thumbnail) 
              VALUES (:pname, :pdesc, :price, :pdisc, :pquantity, :pthumb)';
    
    $this->stmt = $this->connection->prepare($query);
    $this->stmt->bindParam(':pname', $pr_name);
    $this->stmt->bindParam(':pdesc', $pr_desc);
    $this->stmt->bindParam(':price', $pr_price);
    $this->stmt->bindParam(':pdisc', $discount);
    $this->stmt->bindParam(':pquantity', $q);
    $this->stmt->bindParam(':pthumb', $filePath);

    $this->stmt->execute();
    
    echo json_encode(['message' => 'Product created successfully'], JSON_PRETTY_PRINT);
}
public function readAll(){
$query = 'select * from products';
$this->stmt = $this->connection->query($query);
echo json_encode( $this->stmt->fetchAll(PDO::FETCH_ASSOC) , JSON_PRETTY_PRINT);
}

public function readSingle($id) {
if(empty($id)){
    echo json_encode(['error'=> 'id parameter is required']);
}
$productQuery = "select *
from products
where id = :id";
$this->stmt = $this->connection->prepare($productQuery);
$this->stmt->bindParam(":id" , $id);
$this->stmt->execute();
echo json_encode($this->stmt->fetch(PDO::FETCH_ASSOC));
}
public function updateProduct($pr_id,$pr_name, $pr_desc, $pr_price, $discount, $q, $thumbnail) {
    if(empty($pr_id) || empty($pr_name) || empty($pr_desc) || empty($pr_price || empty($thumbnail) || empty($q) || empty($discount))){
        echo json_encode(['error'=>'input values required']);
        return;
    }
    if(!is_string($pr_name)) {
        echo json_encode(['error'=> 'product name is required']);
        return ;
    }
    if(!is_string($pr_desc)){
        echo json_encode(['error'=> 'product description is required']);
        return ;
    }
    if(isset($_FILES[$thumbnail])){
        $imageName = $_FILES[$thumbnail]['name'];
        $imageSize = $_FILES[$thumbnail]['size'];
        $extention = $_FILES[$thumbnail]['type'];
        $imageTemp = $_FILES[$thumbnail]['tmp_name'];
        $arr_ext = ['image/png' , 'image/jpeg' , 'image/jpg'];
        $target = 'uploads/';
        if(!in_array($extention , $arr_ext)) {
            echo json_encode(['error' => 'the image must be png,jpeg,jpg']);
            return;
        }
        else if($imageSize > 4194304){
            echo json_encode(['error' => 'the image size must be lower than 4MB']);
            return;
        }
        else {
            $filePath = $target. uniqid() . basename($imageName);
            move_uploaded_file($imageTemp ,$filePath);
        }
    }
    // if(!is_numeric($pr_price)) {
    //     echo json_encode(['error'=> 'price must be a number']);
    //     return ;
    // }
    if(!is_numeric($discount)){
        echo json_encode(['error'=> 'discount must be a number']);
        return ;
    }
    if(!is_numeric($q)){
        echo json_encode(['error'=> 'quantity must be a number']);
        return ;
    }
    $query = "update products
    set product_name = :pname, 
        product_desc = :pdesc, 
        product_price = :price, 
        discount = :pdisc, 
        quantity = :pquantity, 
        thumbnail = :pthumb 
        WHERE id = :id";
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->bindParam(':id', $pr_id, PDO::PARAM_INT);
        $this->stmt->bindParam(':pname', $pr_name, PDO::PARAM_STR);
        $this->stmt->bindParam(':pdesc', $pr_desc, PDO::PARAM_STR);
        $this->stmt->bindParam(':price', $pr_price, PDO::PARAM_STR);
        $this->stmt->bindParam(':pdisc', $discount, PDO::PARAM_INT);
        $this->stmt->bindParam(':pquantity', $q, PDO::PARAM_INT);
        $this->stmt->bindParam(':pthumb', $thumbnail, PDO::PARAM_STR);
        $this->stmt->execute();
}
public function Delete($id) {
$query = 'Delete from products where id = :id';
$this->stmt = $this->connection->prepare($query);
$this->stmt->bindParam(":id" , $id , PDO::PARAM_INT);
$this->stmt->execute();
echo json_encode("product deleted successfully" , JSON_PRETTY_PRINT);
}
public  function searchByname($keyword){
$query = "select * from products where product_name LIKE :keyword";
$this->stmt = $this->connection->prepare($query);
$this->stmt->bindParam(':keyword' , $keyword);
$keyword .= "%";
$this->stmt->execute();
$count = $this->stmt->rowCount();
if($count > 0) {
    echo json_encode(['result' => $this->stmt->fetchAll(PDO::FETCH_ASSOC)]);
}
else {
    echo json_encode(['result'=> "product not found"]);
}
}
public function __destruct() {
    $this->connection = null;
    $this->stmt = null; 
}
}

$db = new Database();
?>


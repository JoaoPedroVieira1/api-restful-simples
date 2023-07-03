<?php
require 'connection.php'; // arquivo de conexão com o banco de dados
require 'productControllers.php';

$method = $_SERVER['REQUEST_METHOD'];
$controller = new ProductController($conn);

if ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $controller->createProduct($data);
    //createProduct($data);
}elseif ($method == 'GET') {
    if (isset($_GET['ID']) && $_GET['ID'] != "") {
        $id = $_GET['ID'];
        $controller->getProduct($id);
    } else {
        $controller->getAllProducts();
    }
}elseif ($method == 'PUT') {
    if (isset($_GET['ID']) && $_GET['ID'] != "") {
        $id = $_GET['ID'];
        $data = json_decode(file_get_contents("php://input"));
        $controller->updateProduct($id, $data);
    }
}elseif ($method == 'DELETE') {
    if (isset($_GET['ID']) && $_GET['ID'] != "") {
        $id = $_GET['ID'];
        $controller->deleteProduct($id);
    }
}else{
    $output = [
        "status" => 400,
        "data" => "Invalid Request Method",
        "error" => true
    ];
    echo json_encode($output);
}

?>

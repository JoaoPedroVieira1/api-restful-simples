<?php

    class ProductController{
        private $conn;

        public function __construct($conn){ // recebe conexão do banco de dados
            $this->conn=$conn;
        }
        public function createProduct($data){ // insere um novo produto no banco de dados
            global $conn;

            $product_code = mysqli_real_escape_string($conn, $data->ProductCode);
            $product_name = mysqli_real_escape_string($conn, $data->ProductName);
            $price = floatval($data->Price);
            $price_promotion = floatval($data->PricePromotion);
            $tax = floatval($data->Tax);
            $promotion = intval($data->Promotion);
            $is_active = intval($data->IsActive);
            $created = date("Y-m-d");

            $query = "INSERT INTO product(ProductCode, ProductName, Price, PricePromotion, Tax, Promotion, IsActive, CreatedAt) 
                    VALUES ('$product_code', '$product_name', '$price', '$price_promotion', '$tax', '$promotion', '$is_active', '$created')";

            $result = mysqli_query($conn, $query);

            if ($result) {
                $output = [
                    "status" => 200,
                    "data" => "Data insert successfully",
                    "error" => false
                ];
            } else {
                $output = [
                    "status" => 500,
                    "data" => "Failed to insert data",
                    "error" => true
                ];
            }

            echo json_encode($output);
        }
        public function getProduct($id){ // busca um produto no banco de dados de acordo com id fornecido
            global $conn;

            $id = mysqli_real_escape_string($conn, $id);

            $query = "SELECT * FROM product WHERE ID='$id' AND IsActive='Active'";
            $result = mysqli_query($conn, $query);
            $numRows = mysqli_num_rows($result);

            if ($numRows > 0) {
                $output = mysqli_fetch_assoc($result);
                $output = [
                    "status" => 200,
                    "data" => $output,
                    "error" => false
                ];
            } else {
                $output = [
                    "status" => 404,
                    "data" => "No Record Found",
                    "error" => true
                ];
            }

            echo json_encode($output);
        }
        public function getAllProducts(){ // busca todos os produtos no banco de dados
            global $conn;

            $query = "SELECT * FROM product";
            $result = mysqli_query($conn, $query);
            $output = array();

            while ($row = mysqli_fetch_assoc($result)) {
                array_push($output, $row);
            }

            $output = [
                "status" => 200,
                "data" => $output,
                "error" => false
            ];

            echo json_encode($output);
        }
        public function updateProduct($id, $data){ // atualiza um produto existente de acordo com o ID fornecido
            global $conn;

            $id = mysqli_real_escape_string($conn, $id);
            $product_code = mysqli_real_escape_string($conn, $data->ProductCode);
            $product_name = mysqli_real_escape_string($conn, $data->ProductName);
            $price = floatval($data->Price);
            $price_promotion = floatval($data->PricePromotion);
            $tax = floatval($data->Tax);
            $promotion = intval($data->Promotion);
            $is_active = intval($data->IsActive);
            $created = date("Y-m-d");

            $query = "UPDATE product SET ProductCode='$product_code', ProductName='$product_name', Price='$price', 
                    PricePromotion='$price_promotion', Tax='$tax', Promotion='$promotion', IsActive='$is_active', 
                    CreatedAt='$created' WHERE ID='$id'";

            $result = mysqli_query($conn, $query);

            if ($result) {
                $output = [
                    "status" => 200,
                    "data" => "Data Updated Successfully",
                    "error" => false
                ];
            } else {
                $output = [
                    "status" => 500,
                    "data" => "Failed to update data",
                    "error" => true
                ];
            }

            echo json_encode($output);
        }
        public function deleteProduct($id){ // deleta um produto do banco de dados de acordo com o ID fornecido
            global $conn;

            $id = mysqli_real_escape_string($conn, $id);
            echo "ID:" . $id . "\n";

            $query = "SELECT * FROM product WHERE ID='$id' AND IsActive=1";
            $result = mysqli_query($this->conn, $query);
            $numRows = mysqli_num_rows($result);

            echo "Numero de linhas encontradas: " . $numRows . "\n";

            if ($numRows > 0) {
                $query = "DELETE FROM product WHERE ID='$id'";
                $result = mysqli_query($this->conn, $query);

                $output = [
                    "status" => 200,
                    "data" => "Data Deleted Successfully",
                    "error" => false
                ];
            } else {
                $output = [
                    "status" => 404,
                    "data" => "No Record Found",
                    "error" => true
                ];
            }

            echo json_encode($output);
        }
        private function executeQuery($query) {
            $result = mysqli_query($this->conn, $query);
    
            if ($result) {
                return [
                    "status" => 200,
                    "data" => "Operation executed successfully",
                    "error" => false
                ];
            } else {
                return [
                    "status" => 500,
                    "data" => "Failed to execute operation",
                    "error" => true
                ];
            }
        }
    }   

?>

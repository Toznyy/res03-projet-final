<?php  //A ADAPTER

class ProductManager extends AbstractManager {

    public function getAllProducts() : array {
        
        $query = $this->db->prepare("SELECT * FROM products");
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $productsTab=[];
        foreach($products as $product){
            $newProduct=new Product($product['id'], $product['username'],$product['first_name'],$product['last_name'],$product['email']);
            array_push($productsTab, $newProduct);
        }
        return $productsTab;
    }

    public function getProductById(int $id) : Product {
        
        $query = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $newProduct = new Product($product["id"], $product["username"], $product["first_name"], $product["last_name"], $product["email"]);
        return $newProduct;
    }

    public function createProduct(Product $product) : Product {
        
        $query = $this->db->prepare("INSERT INTO products VALUES (null, :username, :first_name, :last_name, :email)");
        $parameters = [
            "username" => $product->getusername(),
            "first_name" => $product->getfirstName(),
            "last_name" => $product->getlastName(),
            "email" => $product->getEmail()
            ];
        $query->execute($parameters);
        
        $query = $this->db->prepare("SELECT * FROM products WHERE username = :username");
        $parameters= [
            "username" => $product->getusername()
            ];
        $query->execute($parameters);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $newProduct = new Product($product["id"],$product["username"],$product["first_name"],$product["last_name"],$product["email"]);
        return $newProduct;
    }

    public function updateProduct(Product $Product) : Product {
        
        $query = $this->db->prepare("UPDATE products SET username = :username, first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id");
        $parameters= [
        "id" => $product->getId(),
        "username"=>$product->getusername(),
        "first_name"=> $product->getFirstName(),
        "last_name" =>$product->getLastName(),
        "email" => $product->getEmail()
        ];
        $query->execute($parameters);
        $query = $this->db->prepare("SELECT * FROM products WHERE username = :username");
        $parameters = ["username" => $product->getusername()];
        $query->execute($parameters);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $newProduct = new Product($product["id"], $product["username"], $product["first_name"], $product["last_name"], $product["email"]);
        return $newProduct;
    }

    public function deleteProduct(Product $Product) : array {
        
        $query = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $parameters = ["id" => $product->getId()];
        $query->execute($parameters);
        return $this->getAllProducts();
    }
}

?>
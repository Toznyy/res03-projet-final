<?php  //A ADAPTER

class ProductManager extends AbstractManager {

    public function getAllProducts() : array {
        
        $query = $this->db->prepare("SELECT * FROM products");
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $productsTab=[];
        foreach($products as $product){
            $newProduct = new Product($product['name'], $product['description'],$product['price']);
            $newProduct->setId($product['id']);
            array_push($productsTab, $newProduct);
        }
        return $productsTab;
    }

    public function ProductsJoinPictures($picture_id, $product_id) {
        
        $query = $this->db->prepare("INSERT INTO products_pictures VALUES (:product_id, :picture_id)");
        $parameters = [
            "product_id" => $product_id,
            "picture_id" => $picture_id
            ];
        $query->execute($parameters);
    }
    
    public function ProductsJoinCategories($product_id, $category_id) {
        
        $query = $this->db->prepare("INSERT INTO products_categories VALUES (:product_id, :category_id)");
        $parameters = [
            "product_id" => $product_id,
            "category_id" => $category_id
            ];
        $query->execute($parameters);
    }
    
    public function getAllProductsWithPictures() : array {
        
        $query = $this->db->prepare("SELECT * FROM products JOIN (products_pictures JOIN pictures ON products_pictures.picture_id = pictures.id) ON products.id = products_pictures.product_id WHERE pictures.role = products");
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
    
    public function getAllProductsWithPicturesAndCategories() : array {
        
        $query = $this->db->prepare("SELECT products.id, products.name, pictures.URL, pictures.caption, products.description, products.price, categories.title FROM products JOIN products_pictures ON products.id = products_pictures.product_id JOIN pictures ON products_pictures.picture_id = pictures.id JOIN products_categories ON products.id = products_categories.product_id JOIN categories ON products_categories.category_id = categories.id");
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
    
    public function getAllProductsWithPicturesByCategory(string $title) : array {
        
        $query = $this->db->prepare("SELECT products.id, categories.title, pictures.URL, products.price, products.name FROM products JOIN products_pictures ON products.id = products_pictures.product_id JOIN pictures ON products_pictures.picture_id = pictures.id JOIN products_categories ON products.id = products_categories.product_id JOIN categories ON products_categories.category_id = categories.id WHERE categories.title = :title");
        $parameters = ["title" => $title];
        $query->execute($parameters);
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
    
    public function getAllProductsWithPicturesById(int $id) : array {
        
        $query = $this->db->prepare("SELECT * FROM products JOIN (products_pictures JOIN pictures ON products_pictures.picture_id = pictures.id) ON products.id = products_pictures.product_id WHERE id = :id");
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
    

    public function getProductById(int $id) : Product {
        
        $query = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $newProduct = new Product($product["name"], $product["description"], $product["price"]);
        $newProduct->setId($product['id']);
        return $newProduct;
    }
    
    public function getProductByName(string $name) : Product {
        
        $query = $this->db->prepare("SELECT * FROM products WHERE name = :name");
        $parameters = [
            "name" => $name
            ];
        $query->execute($parameters);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $newProduct = new Product($product["name"], $product["description"], $product['price']);
        $newProduct->setId($product['id']);
        return $newProduct;
    }

    public function createProduct(Product $product) : Product {
        
        $query = $this->db->prepare("INSERT INTO products VALUES (null, :name, :description, :price)");
        $parameters = [
            "name" => $product->getName(),
            "description" => $product->getDescription(),
            "price" => $product->getPrice(),
            ];
        $query->execute($parameters);
        
        $query = $this->db->prepare("SELECT * FROM products WHERE name = :name");
        $parameters= [
            "name" => $product->getName()
            ];
        $query->execute($parameters);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $newProduct = new Product($product['name'], $product['description'],$product['price']);
        $newProduct->setId($product['id']);
        return $newProduct;
    }

    public function updateProduct(Product $product) : Product {
        
        $query = $this->db->prepare("UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id");
        $parameters= [
        "id" => $product->getId(),
        "name"=>$product->getName(),
        "description"=> $product->getDescription(),
        "price" =>$product->getPrice(),
        ];
        $query->execute($parameters);
        $query = $this->db->prepare("SELECT * FROM products WHERE name = :name");
        $parameters = ["name" => $product->getName()];
        $query->execute($parameters);
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $newProduct = new Product($product['name'], $product['description'],$product['price']);
        return $newProduct;
    }

    public function deleteProduct(Product $product) : void {
        
        $query = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $parameters = ["id" => $product->getId()];
        $query->execute($parameters);
    }
    
    public function deleteProductPicture(int $id) : void {
        $query= $this->db->prepare("DELETE FROM products_pictures WHERE product_id = :product_id");
        $parameters = ["product_id" => $id ];
        $query->execute($parameters);
    }
    
    function createTitle(string $slug): string {
        // Remplacer les tirets par des espaces
        $title = str_replace('-', ' ', $slug);
        // Retirer tous les caractères qui ne sont pas des lettres, des chiffres ou des espaces
        $title = preg_replace('/[^a-z0-9\s]/i', '', $title);
        // Capitaliser la première lettre de chaque mot
        $title = ucwords($title);
        return $title;
    }
}

?>
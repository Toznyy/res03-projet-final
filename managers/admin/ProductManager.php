<?php

// Définition de la classe ProductManager
class ProductManager extends AbstractManager {
    
    // Retourne un tableau de tous les produits
    public function getAllProducts() : array {
        
        // Prépare la requête SQL pour récupérer tous les produits
        $query = $this->db->prepare("SELECT * FROM products");
        // Exécute la requête SQL
        $query->execute();
        // Récupère tous les produits sous forme de tableau associatif
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Initialise un tableau vide pour stocker les objets Product
        $productsTab=[];
        // Pour chaque produit dans le tableau associatif récupéré, créer un nouvel objet Product et l'ajouter au tableau $productsTab
        foreach($products as $product){
            $newProduct = new Product($product['name'], $product['description'],$product['price']);
            $newProduct->setId($product['id']);
            array_push($productsTab, $newProduct);
        }
        // Retourne le tableau des produits
        return $productsTab;
    }
    
    // Associe un produit à une image
    public function ProductsJoinPictures($picture_id, $product_id) {
        
        // Prépare la requête SQL pour ajouter un produit et une image à la table de liaison
        $query = $this->db->prepare("INSERT INTO products_pictures VALUES (:product_id, :picture_id)");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "product_id" => $product_id,
            "picture_id" => $picture_id
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
    }
    
    // Associe un produit à une catégorie
    public function ProductsJoinCategories($product_id, $category_id) {
        
        // Prépare la requête SQL pour ajouter un produit et une catégorie à la table de liaison
        $query = $this->db->prepare("INSERT INTO products_categories VALUES (:product_id, :category_id)");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "product_id" => $product_id,
            "category_id" => $category_id
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
    }
    
    // Retourne un tableau de produits avec leurs images associées
    public function getAllProductsWithPictures() : array {
        
        // Prépare la requête SQL pour récupérer tous les produits avec leurs images associées
        $query = $this->db->prepare("SELECT * FROM products JOIN (products_pictures JOIN pictures ON products_pictures.picture_id = pictures.id) ON products.id = products_pictures.product_id WHERE pictures.role = products");
        // Exécute la requête SQL
        $query->execute();
        // Récupère tous les produits avec leurs images associées sous forme de tableau associatif
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        // Retourne le tableau des produits avec leurs images associées
        return $products;
    }
    
    // Retourne un tableau de produits avec leurs images et leurs catégories associées
    public function getAllProductsWithPicturesAndCategories() : array {
        
        // Prépare la requête SQL pour récupérer tous les produits avec leurs images et leurs catégories associées
        $query = $this->db->prepare("SELECT products.id, products.name, pictures.URL, pictures.caption, products.description, products.price, categories.title FROM products JOIN products_pictures ON products.id = products_pictures.product_id JOIN pictures ON products_pictures.picture_id = pictures.id JOIN products_categories ON products.id = products_categories.product_id JOIN categories ON products_categories.category_id = categories.id");
        // Exécute la requête SQL
        $query->execute();
        // Récupère tous les produits avec leurs images et leurs catégories associées sous forme de tableau associatif
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        // Retourne le tableau des produits avec leurs images et leurs catégories associées
        return $products;
    }
    
    // Retourne un tableau des derniers produits avec leur images et leurs catégories associées
    public function getNouveautes() : array {
        
        // Prépare la requête SQL pour récupérer les 4 derniers produits avec leurs images et leurs catégories associées
        $query = $this->db->prepare("SELECT products.id, products.name, pictures.URL, pictures.caption, products.description, products.price, categories.title FROM products JOIN products_pictures ON products.id = products_pictures.product_id JOIN pictures ON products_pictures.picture_id = pictures.id JOIN products_categories ON products.id = products_categories.product_id JOIN categories ON products_categories.category_id = categories.id ORDER BY products.id DESC LIMIT 4");
        // Exécute la requête SQL
        $query->execute();
        // Récupère les 4 dernieres produits avec leurs images et leurs catégories associées sous forme de tableau associatif
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        // Retourne le tableau des produits avec leurs images et leurs catégories associées
        return $products;
    }
    
    // Récupère la catégorie des produits
    public function getCategoryOfProduct(Product $product) {
        
        // Récupère l'ID du produit
        $product_id = $product->getId();
        // Prépare la requête SQL pour récupérer tous la catégorie associée à ce produit
        $query = $this->db->prepare("SELECT * FROM products JOIN (products_categories JOIN categories ON products_categories.category_id = categories.id) ON products.id = products_categories.product_id WHERE products.id = :product_id");
        // Définit les paramètres de la requête SQL
        $parameters = ["product_id" => $product_id];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupère la catégorie sous forme de tableau associatif
        $category = $query->fetch(PDO::FETCH_ASSOC);
        // Crée un nouvel objet Category
        $newCategory = new Category($category["title"], $category["description"]);
        // Retourne la catégorie créée sous forme d'objet
        return $newCategory;
    }
    
    // Récupère un tableau de produits avec leurs images associées par catégorie
    public function getAllProductsWithPicturesByCategory(string $title) : array {
        
        // Prépare la requête SQL pour récupérer des éléments des produits, des images et des catégories
        $query = $this->db->prepare("SELECT products.id, categories.title, pictures.URL, products.price, products.name FROM products JOIN products_pictures ON products.id = products_pictures.product_id JOIN pictures ON products_pictures.picture_id = pictures.id JOIN products_categories ON products.id = products_categories.product_id JOIN categories ON products_categories.category_id = categories.id WHERE categories.title = :title");
        // Définit les paramètres de la requête SQL
        $parameters = ["title" => $title];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupère tous les éléments sous forme de tableau associatif
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        // Retourne le tableau des éléments 
        return $products;
    }
    // Récupère un tableau de produits avec leurs images associées par id
    public function getAllProductsWithPicturesById(int $id) : array {
        
        // Prépare la requête SQL pour récupérer tous les produits avec leurs images associées par id
        $query = $this->db->prepare("SELECT * FROM products JOIN (products_pictures JOIN pictures ON products_pictures.picture_id = pictures.id) ON products.id = products_pictures.product_id WHERE id = :id");
        // Définit les paramètres de la requête SQL
        $parameters = ["id" => $id];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupère tous les produits avec leurs images associées sous forme de tableau associatif
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        // Retourne le tableau des produits avec leurs images associées
        return $products;
    }
    
    // Retourne un produit par son id
    public function getProductById(int $id) : Product {
        
        // Prépare la requête SQL pour récupérer un produit en fonction de son id
        $query = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "id" => $id
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupére le produit sous forme d'un tableau associatif
        $product = $query->fetch(PDO::FETCH_ASSOC);
        // Créer un nouvel objet Product
        $newProduct = new Product($product["name"], $product["description"], $product["price"]);
        $newProduct->setId($product['id']);
        // Retourne le produit créé sous forme d'objet
        return $newProduct;
    }
    
    // Retourne un produit par son nom
    public function getProductByName(string $name) : Product {
        
        // Prépare la requête SQL pour récupérer un produit en fonction de son nom
        $query = $this->db->prepare("SELECT * FROM products WHERE name = :name");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "name" => $name
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
         // Récupére le produit sous forme d'un tableau associatif
        $product = $query->fetch(PDO::FETCH_ASSOC);
        // Créer un nouvel objet Product
        $newProduct = new Product($product["name"], $product["description"], $product['price']);
        $newProduct->setId($product['id']);
        // Retourne le produit créé sous forme d'objet
        return $newProduct;
    }
    
    // Création d'un produit
    public function createProduct(Product $product) : Product {
        
        // Prépare la requête SQL pour insérer un nouveeau produit dans la base de données
        $query = $this->db->prepare("INSERT INTO products VALUES (null, :name, :description, :price)");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "name" => $product->getName(),
            "description" => $product->getDescription(),
            "price" => $product->getPrice(),
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Prépare une autre requête SQL pour récupérer le produit créé par son nom
        $query = $this->db->prepare("SELECT * FROM products WHERE name = :name");
        // Définit les paramètres de la requête SQL
        $parameters= [
            "name" => $product->getName()
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupére le produit sous forme d'un tableau associatif
        $product = $query->fetch(PDO::FETCH_ASSOC);
        // Créer un nouvel objet Product
        $newProduct = new Product($product['name'], $product['description'],$product['price']);
        $newProduct->setId($product['id']);
        // Retourne le produit créé sous forme d'objet
        return $newProduct;
    }
    
    // Modification d'un utilisateur
    public function updateProduct(Product $product) : Product {
        
        // Prépare la SQL pour récupérer le produit à modifier par son id
        $query = $this->db->prepare("UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id");
        // Définit les paramètres de la requête SQL
        $parameters= [
            "id" => $product->getId(),
            "name"=>$product->getName(),
            "description"=> $product->getDescription(),
            "price" =>$product->getPrice(),
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Prépare une autre requête SQL pour récupérer le produit créé par son nom
        $query = $this->db->prepare("SELECT * FROM products WHERE name = :name");
        // Définit les paramètres de la requête SQL
        $parameters = ["name" => $product->getName()];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupére le produit sous forme d'un tableau associatif
        $product = $query->fetch(PDO::FETCH_ASSOC);
        // Créer un nouvel objet Product
        $newProduct = new Product($product['name'], $product['description'],$product['price']);
        // Retourne le produit créé sous forme d'objet
        return $newProduct;
    }
    
    // Suppression d'un produit
    public function deleteProduct(Product $product) : void {
        
        // Prépare une autre requête SQL pour supprimer l'utilisateur à modifier par son id
        $query = $this->db->prepare("DELETE FROM products WHERE id = :id");
        // Définit les paramètres de la requête SQL
        $parameters = ["id" => $product->getId()];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
    }
    
    // Suppression dans la table products_pictures
    public function deleteProductPicture(int $id) : void {
        
        // Prépare une autre requête SQL pour supprimer l'élément de la table products_pictures
        $query= $this->db->prepare("DELETE FROM products_pictures WHERE product_id = :product_id");
        $parameters = ["product_id" => $id ];
        $query->execute($parameters);
    }
    
    // Suppression dans la table products_categories
    public function deleteProductCategory(int $id) : void {
        
        // Prépare une autre requête SQL pour supprimer l'élément de la table products_categories
        $query= $this->db->prepare("DELETE FROM products_categories WHERE product_id = :product_id");
        $parameters = ["product_id" => $id ];
        $query->execute($parameters);
    }
    
    // Création d'un titre à la place d'un slug
    function createTitle(string $slug): string {
        // Remplace les tirets par des espaces
        $title = str_replace('-', ' ', $slug);
        // Retire tous les caractères qui ne sont pas des lettres, des chiffres ou des espaces
        $title = preg_replace('/[^a-z0-9\s]/i', '', $title);
        // Capitalise la première lettre de chaque mot
        $title = ucwords($title);
        // Retourne le titre crée
        return $title;
    }
}

?>
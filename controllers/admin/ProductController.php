<?php

class ProductController extends AbstractController {
    private ProductManager $pm;

    public function __construct()
    {
        $this->pm = new ProductManager();
    }

    public function getProducts() {
        
        $products = $this -> pm->getAllProducts();
        $productsTab = [];
        foreach($products as $product) {
            
            $productTab = $product->toArray();
            $productsTab[]=$productTab;
        }
        
        $this->render($productsTab);
    }

    public function getProductById(string $get)
    {
        $id = intval($get);
        $product = $this -> pm->getProductById($id);
        $productTab = $product->toArray();
        
        $this->render($ProductTab);
    }

    public function createProduct(array $post)
    {
        $newProduct = new Product(null, $post['Productname'], $post['firstName'], $post['lastName'], $post['email']);
        $product = $this->pm->createProduct($newProduct);
        $createdProduct = $product->toArray();
        $this->render($createdProduct);
    }

    public function updateProduct(array $post)
    {
        $newProduct = new Product(null, $post['Productname'], $post['firstName'], $post['lastName'], $post['email']);
        $product = $this->pm->updateProduct($newProduct);
        $updatedProduct = $product->toArray();
        $this->render($updatedProduct);
    }

    public function deleteProduct(array $post)
    {
        $newProduct = new Product(null, $post['Productname'], $post['firstName'], $post['lastName'], $post['email']);
        $product = $this->pm->deleteProduct($newProduct);
        $deletedProduct = $product->toArray();
        return $this->getProducts;
    }
}

?>
<?php

class ProductController extends AbstractController {
    private ProductManager $prm;
    private PictureManager $pm;
    private CategoryManager $cm;

    public function __construct()
    {
        $this->prm = new ProductManager();
        $this->pm = new PictureManager();
        $this->cm = new CategoryManager();
    }

    public function getProducts() {
        
        $products = $this->prm->getAllProductsWithPicturesAndCategories();
        $this->renderPrivate("admin-products", ["products" => $products]);
    }
    
    public function category(string $slug) {
        $products = $this->prm->getAllProductsWithPicturesByCategory($this->prm->createTitle($slug));
        $this->render("category", $products);
    }
    
    public function getProductsByCategory(string $title) {
        
        $category = $this->cm->getCategoryByTitle($title);
        $products = $this->prm->getAllProductsWithPicturesByCategory($this->prm->createTitle($slug));
        $this->render("One Piece", ["products" => $products]);
    }

    public function getProduct(string $get)
    {
        $id = intval($get);
        $product = $this -> prm->getProductById($id);
        $productTab = $product->toArray();
        
        $this->renderPrivate("admin-product", [$productTab]);
    }

    public function createProduct(array $post)
    {
        $newProduct = new Product($this->clean($post['name']), $this->clean($post['description']), $this->clean($post['price']));
        $newPicture = new Picture($this->clean($post['URL']), $this->clean($post['caption-product']), "products");
        
        $product = $this->prm->createProduct($newProduct);
        $picture = $this->pm->createPicture($newPicture);
        $category = $this->cm->getCategoryByTitle($post['title']);
        $product_picture = $this->prm->ProductsJoinPictures($picture->getId(), $product->getId());
        $product_category = $this->prm->ProductsJoinCategories($product->getId(), $category->getId());
        $createdProduct = $product->toArray();
        $createdPicture = $picture->toArray();
        
        $finishedProduct = $createdProduct + $createdPicture;
        
        header('Location: /res03-projet-final/admin/products');
    }

    public function updateProduct(array $post, string $get)
    {
        $id = intval($get);
        $product = $this->prm->getProductById($id);
        $pictures = $this->pm->getPicturesByProductId($id);
        $tab = [];
        
        $tab["product"] = $product;
        $tab["pictures"] = $pictures;

        if(isset($post["formName"]))
        {
            if(isset($post['name']) && isset($post['description']) && isset($post['price']) && isset($post['URL']) && isset($post['caption']) && !empty($post['name']) && !empty($post['description']) && !empty($post['price']) && !empty($post['URL']) && !empty($post['caption'])) {
                
                $productToUpdate = $this->prm->getProductById($id);
                $pictureToUpdate = $this->pm->getPicturesByProductId($id);
                $productToUpdate->setName($this->clean($post['name']));
                $productToUpdate->setDescription($this->clean($post['description']));
                $productToUpdate->setPrice($this->clean($post['price']));
                $pictureToUpdate->setURL($this->clean($post['URL']));
                $pictureToUpdate->setCaption($this->clean($post['caption']));
                $productUpdated = $this->prm->updateProduct($productToUpdate);
                $pictureUpdated = $this->pm->updatePicture($pictureToUpdate);
                header("Location: /res03-projet-final/admin/products");
            }
            else {
                echo "ca marche paaaaaaas<br>";
            }
        }
        else
        {
            $this->renderPrivate("admin-products-update", $tab);
        }
    }

    public function deleteProduct(string $get) : void
    {
        $id = intval($get);
        $productToDelete = $this->prm->getProductById($id);
        $pictureToDelete = $this->pm->getPicturesByProductId($id);
        
        $product_picture = $this ->prm->deleteProductPicture($id);
        $product_category = $this ->prm->deleteProductCategory($id);
        $picture = $this->pm->deletePicture($pictureToDelete);
        $product = $this->prm->deleteProduct($productToDelete);

        header("Location: /res03-projet-final/admin/products");
    }
}

?>
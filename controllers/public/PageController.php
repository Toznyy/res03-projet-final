<?php

class PageController extends AbstractController {
    private PageManager $pam;
    private CategoryManager $cm;
    private PictureManager $pm;
    private ProductManager $prm;
    private UserManager $um;
    
    public function __construct() {
        
        $this->pam = new PageManager();
        $this->cm = new CategoryManager();
        $this->pm = new PictureManager();
        $this->prm = new ProductManager();
        $this->um = new UserManager();
    }
    
    public function connexion() {
        $this->render("connexion", ["page de connexion"]);
    }
    
    public function creation() {
        $this->render("creation", ["page de la création de compte"]); 
    }
    
    public function contact() {
        $this->render("contact", ["page de contact"]); 
    }
    
    public function aPropos() {
        $this->render("info", ["page d'info"]); 
    }
    
    public function monCompte() {
        $this->render("mon-compte", ["page du compte"]);
    }
    
    public function accueil() {
        $this->render("accueil", ["page d'accueil"]); 
    }
    
    public function panier() {
        $this->render("panier", ["page de panier"]); 
    }
    
    public function nouveautes() {
        $this->render("nouveautes", ["page des nouveautes"]); 
    }
    
    public function listeCategories() {
        $categories = $this->cm->getAllCategoriesWithPictures();
        $this->render("liste-categories", $categories); 
    }
    
    public function displayOneCategory(string $slug) {
        
        $category = $this->cm->getCategoryByTitle($this->prm->createTitle($slug));
        $products = $this->prm->getAllProductsWithPicturesByCategory($this->prm->createTitle($slug));
        $tab = [
            "category" => $category,
            "products" => $products
            ];
        $this->render("category", $tab);
    }
    
    public function displayOneProduct(int $id) {
        
        $product = $this->prm->getProductById($id);
        $pictures = $this->pm->getPicturesByProduct($product);
        $tab = [
            "product" => $product,
            "pictures" => $pictures
            ];
        $this->render("product",$tab);
    }

    public function error404() {
        $this->render("404", ["page du 404"]); 
    }
    
    public function adminAccueil() {
        $this->renderPrivate("admin-accueil" , ["page d'accueil admin"]);
    }
    
    public function createCategories() {
        $this->renderPrivate( "admin-categories-create" , ["page de création de catégorie"]); 
    }
    
    public function updateCategories(string $id) {
        $category = $this->cm->getCategoryById(intval($id));
        $pictures = $this->pm->getPicturesByCategory($category);
        $this->renderPrivate("admin-categories-update", ["id" => $id, "category" => $category, "pictures" => $pictures]);
    }
    
    public function createProducts() {
        
        $categories = $this->cm->getAllCategories();
        $this->renderPrivate("admin-products-create", ["categories" => $categories]); 
    }
    
    public function updateProducts(string $id) {
        $product = $this->prm->getProductById(intval($id));
        $pictures = $this->pm->getPicturesByProduct($product);
        $this->renderPrivate("admin-products-update" , ["id" => $id, "product" => $product, "pictures" => $pictures]);
    }
    
    public function updateUsers(string $id) {

        $user = $this->um->getUserById(intval($id));
        $this->renderPrivate("admin-users-update", ["id" => $id, "user" => $user]);
    }
    
    public function updateUsersAddresses(string $id) {
        
        $user = $this->um->getUserById(intval($id));
        $address = $this->am->getAddressById(intval($id));
        $this->renderPrivate("admin-users-addresses-update", ["id" => $id, "user" => $user, "address" => $address]);
    }
}

?>
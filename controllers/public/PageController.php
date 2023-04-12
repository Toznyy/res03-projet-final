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
        $this->render("connexion" , ["page de connexion"]);
    }
    
    public function creation() {
        $this->render("creation" , ["page de la création de compte"]); 
    }
    
    public function contact() {
        $this->render("contact" , ["page de contact"]); 
    }
    
    public function aPropos() {
        $this->render("info" , ["page d'info"]); 
    }
    
    public function accueil() {
        $this->render("accueil" , ["page d'accueil"]); 
    }
    
    public function nouveautes() {
        $this->render("nouveautes" , ["page des nouveautes"]); 
    }
    
    public function listeCategories() {
        $this->render("liste-categories" , ["page de la liste des catégories"]); 
    }
    
    public function error404() {
        $this->render("404" , ["page du 404"]); 
    }
    
    public function adminAccueil() {
        $this->renderPrivate("admin-accueil" , ["page d'accueil admin"]);
    }
    
    public function createCategories() {
        $this->renderPrivate( "admin-categories-create" , ["page de la création d'une catégorie"]); 
    }
    
    public function updateCategories(string $id) {
        $category = $this->cm->getCategoryById(intval($id));
        $picture = $this->pm->getPictureById(intval($id));
        $this->renderPrivate("admin-categories-update" , ["id" => $id, "category" => $category, "picture" => $picture]);
    }
    
    public function createProducts() {
        $this->renderPrivate("admin-products-create" , ["page de la création d'un produit"]); 
    }
    
    public function updateProducts(string $id) {
        $product = $this->prm->getProductById(intval($id));
        $picture = $this->pm->getPictureById(intval($id));
        $this->renderPrivate("admin-products-update" , ["id" => $id, "product" => $product, "picture" => $picture]);
    }
    
    public function updateUsers(string $id) {

        $user = $this->um->getUserById(intval($id));
        $this->renderPrivate("admin-users-update" , ["id" => $id, "user" => $user]);
    }
    
    public function updateUsersAddresses(string $id) {
        
        $user = $this->um->getUserById(intval($id));
        var_dump($user);
        $address = $this->am->getAddressById(intval($id));
        $this->renderPrivate("admin-users-addresses-update" , ["id" => $id, "user" => $user, "address" => $address]);
    }
}

?>
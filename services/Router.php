<?php

/**
 * @author : Gaellan
 * @author : Toznyy
 */

class Router {

    // private attribute

    private PageController $pageController;
    private UserController $userController;
    private CategoryController $categoryController;
    private OrderController $orderController;
    private ProductController $productController;
    private LoginController $loginController;

    // public constructor
    
    public function __construct() {

        $this->pageController = new PageController();
        $this->userController = new UserController();
        $this->categoryController = new CategoryController();
        $this->orderController = new OrderController();
        $this->productController = new ProductController();
        $this->loginController = new LoginController();

    }

    public function checkRoute(){


        if(isset($_GET["path"])){

            $route = explode("/",$_GET["path"]);

            // Pages publics gerer par -> PageController
            if($route[0] === "connexion") {
                
                if (!empty($_POST) && $_POST["formName"]=== "connexion") {
                    
                    $post = $_POST;
                    $this->loginController->connexion($post);
                }
                else {
                    
                    $this->pageController->connexion();
                }
            }
            
            else if($route[0] === "creation") {
                
                if (!empty($_POST) && $_POST["formName"]=== "creation"){
                    
                    $post = $_POST;
                    $this->userController->createUser($post);
                }
                else {
                    
                    $this->pageController->creation();
                }
            }
            
            else if($route[0] === "contact") {
                $this->pageController->contact();
            }
            
            else if($route[0] === "info") {
                $this->pageController->aPropos();
            }
            
            else if($route[0] === "nouveautes") {
                $this->pageController->nouveautes();
            }
            
            else if($route[0] === "deconnexion") {
                $this->userController->deconnexion();
            }
            
            else if($route[0] === "liste-categories") {
                
                if(!isset($route[1])) {
                    $this->pageController->listeCategories();
                }
                else if($route[1] === "category") {
                    
                    if(!isset($route[2])) {
                        $this->categoryController->getCategory($route[1]);
                    }
                    
                    else if($route[2] === "product") {
                        $this->productController->getProduct($route[2]);
                    }
                }
            }
            
            else if($route[0] === "accueil") {
                $this->pageController->accueil();
            }
        
            else if($route[0] === "mon-compte") {
                
                if(!isset($route[1])) {
                    $this->userController->getUser();
                }
                
                else if($route[1] === "modifier") {
                    $this->userController->updateUser($route[1]);
                }
                    
                else if($route[1] === "supprimer") {
                    $this->userController->deleteUser($route[1]);
                }
                
                else if($route[1] === "favorites") {
                    $this->userController->favorites($route[1]);
                }
                
                else if($route[1] === "deconnexion") {
                    $this->userController->deconnexion($route[1]);
                }
            }
                
            else if($route[0] === "admin" && isset($_SESSION) && isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
                
                if($route[1] === "all-categories") {
                    
                }
                
                else if($route[1] === "all-articles") {
                    
                }
                
                else if($route[1] === "nouveautes") {
                    
                }
                
                else if($route[1] === "medias") {
                    
                }
            }
            
            else {
                header('Location: /res03-projet-final/accueil');
            }
        }
    }
}
            
?>
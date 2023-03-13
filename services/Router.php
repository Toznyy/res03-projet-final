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
    private ProductController $productPublicController;

    // public constructor
    
    public function __construct() {

        $this->pageController = new PageController();
        $this->userController = new UserController();
        $this->categoryController = new CategoryController();
        $this->orderController = new OrderController();
        $this->productController = new ProductController();

    }

    public function checkRoute(){


        if(isset($_GET["path"])){

            $route = explode("/",$_GET["path"]);

            // Pages publics gerer par -> PageController
            if($route[0] === "connexion") {
                $this->pageController->connexion();
            }
            
            else if($route[0] === "creation") {
                $this->pageController->creation();
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
            
            else if($route[0] === "acceuil") {
                $this->pageController->acceuil();
            }
            
            else if($route[0] === "admin") {
                
                if($route[1] === "mon-compte") {
                    
                    if(!isset($route[2])) {
                        $this->userController->getUser($route[1]);
                    }
                    
                    else if($route[2] === "modifier") {
                        $this->userController->updateUser($route[2]);
                    }
                    
                    else if($route[2] === "supprimer") {
                        $this->userController->deleteUser($route[2]);
                    }
                    
                    else if($route[2] === "favorites") {
                        $this->userController->favorites($route[2]);
                    }
                }
                
                else if($route[1] === "all-categories") {
                    
                }
                
                else if($route[1] === "all-articles") {
                    
                }
                
                else if($route[1] === "nouveautes") {
                    
                }
                
                else if($route[1] === "medias") {
                    
                }
            }
            
            else {
                $this->pageController->error404();
            }
        }
    }
}
            
?>
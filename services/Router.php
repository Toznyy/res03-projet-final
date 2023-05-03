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

        $this -> pageController = new PageController();
        $this -> userController = new UserController();
        $this -> categoryController = new CategoryController();
        $this -> orderController = new OrderController();
        $this -> productController = new ProductController();
        $this -> loginController = new LoginController();

    }

    public function checkRoute() {

        if (isset($_GET["path"])) {

            $route = explode("/", $_GET["path"]);

            // Pages publics gerer par -> PageController
            if ($route[0] === "connexion") {

                if (!empty($_POST) && $_POST["formName"] === "connexion") {

                    $post = $_POST;
                    $this -> loginController -> connexion($post);
                }
                else {

                    $this -> pageController -> connexion();
                }
            }

            else if ($route[0] === "creation") {

                if (!empty($_POST) && $_POST["formName"] === "creation") {

                    $post = $_POST;
                    $this -> userController -> createUser($post);
                }
                else {

                    $this -> pageController -> creation();
                }
            }

            else if ($route[0] === "contact") {
                $this -> pageController -> contact();
            }

            else if ($route[0] === "info") {
                $this -> pageController -> aPropos();
            }

            else if ($route[0] === "nouveautes") {
                $this -> pageController -> nouveautes();
            }
            
            else if ($route[0] === "newsletter") {
                $this -> pageController -> newsletter();
            }

            else if ($route[0] === "deconnexion") {
                $this -> userController -> deconnexion();
            }

            else if ($route[0] === "accueil") {
                $this->pageController -> accueil();
            } 
            
            else if ($route[0] === "liste-categories") {
                if (!isset($route[1])) {
                    $this->categoryController -> getPublicCategories();
                }
                else if (isset($route[1])) {
                    if (!isset($route[2])) {
                        $this->pageController -> displayOneCategory($route[1]);
                    }
                    else if (isset($route[2])) {
                        $this->pageController -> displayOneProduct($route[2]);
                    }
                }
            }
            
            else if ($route[0] === "panier") {
                $this->pageController->panier();
            }
            
            else if ($route[0] === "addPanier") {
                $this->pageController->addPanier();
            }

            else if ($route[0] === "mon-compte") {
                
                if (!isset($_SESSION)) {
                    
                    header('Location: /res03-projet-final/connexion');
                }

                if (!isset($route[1])) {
                    $this -> pageController -> monCompte();
                }

                else if ($route[1] === "modifier") {
                    $this -> userController -> updateUser($route[1]);
                }

                else if ($route[1] === "supprimer") {
                    $this -> userController -> deleteUser($route[1]);
                }

                else if ($route[1] === "favorites") {
                    $this -> userController -> favorites($route[1]);
                }
            }

            else if ($route[0] === "admin" && isset($_SESSION) && isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {

                if (!isset($route[1])) {
                    $this -> pageController -> adminAccueil();
                }

                else if ($route[1] === "categories") {

                    if (!isset($route[2])) {
                        $this -> categoryController -> getCategories();
                    }

                    else if ($route[2] === "create") {

                        if (!empty($_POST) && $_POST["formName"] === "create-category") {

                            $post = $_POST;
                            $this -> categoryController -> createCategory($post);
                        }
                        else {

                            $this -> pageController -> createCategories();
                        }

                    }

                    else if ($route[2] === "update") {

                        if (!empty($_POST) && $_POST["formName"] === "update-category") {

                            $post = $_POST;
                            $this -> categoryController -> updateCategory($post, $route[3]);
                        }
                        else {

                            $this -> pageController -> updateCategories($route[3]);
                        }
                    }

                    else if ($route[2] === "delete") {

                        $this -> categoryController -> deleteCategory($route[3]);
                    }

                }

                else if ($route[1] === "products") {

                    if (!isset($route[2])) {
                        $this -> productController -> getProducts();
                    }

                    else if ($route[2] === "create") {

                        if (!empty($_POST) && $_POST["formName"] === "create-product") {

                            $post = $_POST;
                            var_dump($post);
                            $this -> productController -> createProduct($post);
                        }
                        else {

                            $this -> pageController -> createProducts();
                        }

                    }

                    else if ($route[2] === "update") {

                        if (!empty($_POST) && $_POST["formName"] === "update-product") {

                            $post = $_POST;
                            $this -> productController -> updateProduct($post, $route[3]);
                        }
                        else {

                            $this -> pageController -> updateProducts($route[3]);
                        }
                    }

                    else if ($route[2] === "delete") {

                        $this -> productController -> deleteProduct($route[3]);
                    }

                }

                else if ($route[1] === "users") {

                    if (!isset($route[2])) {
                        $this -> userController -> getUsers();
                    }

                    else if ($route[2] === "addresses") {

                        if (!isset($route[3])) {
                            $this -> userController -> getUsersAddresses();
                        }

                        else if ($route[3] === "update") {
                            
                            if (!empty($_POST) && $_POST["formName"] === "update-user-address") {

                                $post = $_POST;
                                $this -> userController -> updateUserAddress($post, $route[4]);
                            }
                            
                            else {
    
                                $this -> pageController -> updateUsersAddresses($route[4]);
                            }
                        }

                        else if ($route[3] === "delete") {

                            $this -> userController -> deleteUserAddress($route[3]);
                        }
                    }

                    else if ($route[2] === "update") {

                        if (!empty($_POST) && $_POST["formName"] === "update-user") {

                            $post = $_POST;
                            $this -> userController -> updateUser($post, $route[3]);
                        }
                        
                        else {

                            $this -> pageController -> updateUsers($route[3]);
                        }
                    }

                    else if ($route[2] === "delete") {

                        $this -> userController -> deleteUser($route[3]);
                    }

                }

                else if ($route[1] === "orders") {

                    if (!isset($route[2])) {
                            $this -> orderController -> getOrders();
                        }

                    else if ($route[2] === "update") {

                        if (!empty($_POST) && $_POST["formName"] === "update-product") {

                            $post = $_POST;
                            $this -> productController -> updateProduct($post, $route[3]);
                        }
                        else {

                            $this -> pageController -> updateProducts($route[3]);
                        }
                    }

                    else if ($route[2] === "delete") {

                        $this -> productController -> deleteProduct($route[3]);
                    }
                }
            }

            else {
                header('Location: /res03-projet-final/accueil');
            }
        }
    }
}
            
?>
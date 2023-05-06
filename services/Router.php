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

        // Initialisation des contrôleurs nécessaires
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
    
            // Pages publiques gérées par -> PageController
            if ($route[0] === "connexion") {
    
                // Si le formulaire de connexion est soumis
                if (!empty($_POST) && $_POST["formName"] === "connexion") {
                    $post = $_POST;
                    $this -> loginController -> connexion($post);
                }
                else {
                    // Afficher la page de connexion
                    $this -> pageController -> connexion();
                }
            }
    
            else if ($route[0] === "creation") {
    
                // Si le formulaire de création d'utilisateur est soumis
                if (!empty($_POST) && $_POST["formName"] === "creation") {
                    $post = $_POST;
                    $this -> userController -> createUser($post);
                }
                else {
                    // Afficher la page de création d'utilisateur
                    $this -> pageController -> creation();
                }
            }
    
            else if ($route[0] === "contact") {
                // Afficher la page de contact
                $this -> pageController -> contact();
            }
    
            else if ($route[0] === "info") {
                // Afficher la page "à propos"
                $this -> pageController -> aPropos();
            }
    
            else if ($route[0] === "nouveautes") {
                // Afficher la page des nouveautés
                $this -> pageController -> nouveautes();
            }
    
            else if ($route[0] === "newsletter") {
                // Afficher la page de newsletter
                $this -> pageController -> newsletter();
            }
    
            else if ($route[0] === "deconnexion") {
                // Déconnecter l'utilisateur
                $this -> userController -> deconnexion();
            }
    
            else if ($route[0] === "accueil") {
                // Afficher la page d'accueil
                $this->pageController -> accueil();
            }
    
            else if ($route[0] === "liste-categories") {
                if (!isset($route[1])) {
                    // Afficher la liste de toutes les catégories publiques
                    $this->categoryController -> getPublicCategories();
                }
                else if (isset($route[1])) {
                    if (!isset($route[2])) {
                        // Afficher les produits d'une catégorie
                        $this->pageController -> displayOneCategory($route[1]);
                    }
                    else if (isset($route[2])) {
                        // Afficher un produit en particulier
                        $this->pageController -> displayOneProduct($route[2]);
                    }
                }
            }
    
            else if ($route[0] === "panier") {
                // Afficher le panier
                $this->pageController->panier();
            }
    
            else if ($route[0] === "addPanier") {
                // Ajouter un produit au panier
                $this->pageController->addPanier();
            }

            else if ($route[0] === "mon-compte") {
    
                // Vérifie si l'utilisateur est connecté
                if (!isset($_SESSION)) {
                    header('Location: /res03-projet-final/connexion');
                }
                
                // Affiche la page de compte si aucune action n'est spécifiée
                if (!isset($route[1])) {
                    $this -> pageController -> monCompte();
                }
                
                // Met à jour les informations de l'utilisateur si l'action spécifiée est "modifier"
                else if ($route[1] === "modifier") {
                    $this -> userController -> updateUser($route[1]);
                }
                
                // Supprime le compte de l'utilisateur si l'action spécifiée est "supprimer"
                else if ($route[1] === "supprimer") {
                    $this -> userController -> deleteUser($route[1]);
                }
                
                // Affiche les favoris de l'utilisateur si l'action spécifiée est "favorites"
                else if ($route[1] === "favorites") {
                    $this -> userController -> favorites($route[1]);
                }
            }
            
            else if ($route[0] === "admin" && isset($_SESSION) && isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
                
                // Affiche la page d'accueil de l'administrateur si aucune action n'est spécifiée
                if (!isset($route[1])) {
                    $this -> pageController -> adminAccueil();
                }
                
                // Gère les actions liées aux catégories
                else if ($route[1] === "categories") {
                    
                    // Affiche toutes les catégories si aucune action n'est spécifiée
                    if (!isset($route[2])) {
                        $this -> categoryController -> getCategories();
                    }
                    
                    // Crée une nouvelle catégorie si l'action spécifiée est "create"
                    else if ($route[2] === "create") {
                        
                        // Si des données ont été soumises via le formulaire de création, crée la catégorie
                        if (!empty($_POST) && $_POST["formName"] === "create-category") {
                            $post = $_POST;
                            $this -> categoryController -> createCategory($post);
                        }
                        // Sinon, affiche le formulaire de création
                        else {
                            $this -> pageController -> createCategories();
                        }
                    }
                    
                    // Met à jour une catégorie si l'action spécifiée est "update"
                    else if ($route[2] === "update") {
                        
                        // Si des données ont été soumises via le formulaire de mise à jour, met à jour la catégorie
                        if (!empty($_POST) && $_POST["formName"] === "update-category") {
                            $post = $_POST;
                            $this -> categoryController -> updateCategory($post, $route[3]);
                        }
                        // Sinon, affiche le formulaire de mise à jour
                        else {
                            $this -> pageController -> updateCategories($route[3]);
                        }
                    }
                    
                    // Supprime une catégorie si l'action spécifiée est "delete"
                    else if ($route[2] === "delete") {
                        $this -> categoryController -> deleteCategory($route[3]);
                    }
                }

                // Vérifier si le premier segment de l'URL est "products"
                else if ($route[1] === "products") {
                
                    // Si aucun segment supplémentaire n'est spécifié, appeler la méthode getProducts() du contrôleur des produits
                    if (!isset($route[2])) {
                        $this->productController->getProducts();
                    }
                
                    // Si le deuxième segment est "create"
                    else if ($route[2] === "create") {
                
                        // Si des données POST sont envoyées et que le nom du formulaire est "create-product", appeler la méthode createProduct() du contrôleur des produits
                        if (!empty($_POST) && $_POST["formName"] === "create-product") {
                            $post = $_POST;
                            $this->productController->createProduct($post);
                        }
                
                        // Sinon, afficher le formulaire de création de produits en appelant la méthode createProducts() du contrôleur des pages
                        else {
                            $this->pageController->createProducts();
                        }
                
                    }
                
                    // Si le deuxième segment est "update"
                    else if ($route[2] === "update") {
                
                        // Si des données POST sont envoyées et que le nom du formulaire est "update-product", appeler la méthode updateProduct() du contrôleur des produits en passant les données POST et l'ID du produit en paramètres
                        if (!empty($_POST) && $_POST["formName"] === "update-product") {
                            $post = $_POST;
                            $this->productController->updateProduct($post, $route[3]);
                        }
                
                        // Sinon, afficher le formulaire de mise à jour du produit en appelant la méthode updateProducts() du contrôleur des pages en passant l'ID du produit en paramètre
                        else {
                            $this->pageController->updateProducts($route[3]);
                        }
                    }
                
                    // Si le deuxième segment est "delete", appeler la méthode deleteProduct() du contrôleur des produits en passant l'ID du produit en paramètre
                    else if ($route[2] === "delete") {
                        $this->productController->deleteProduct($route[3]);
                    }
                
                }

                // Gestion des routes concernant les utilisateurs
                else if ($route[1] === "users") {
                
                    // Si aucun identifiant n'est spécifié en 2ème position dans l'URL
                    if (!isset($route[2])) {
                        // Afficher la liste de tous les utilisateurs
                        $this -> userController -> getUsers();
                    }
                
                    // Si l'identifiant "addresses" est spécifié en 2ème position dans l'URL
                    else if ($route[2] === "addresses") {
                
                        // Si aucun identifiant d'adresse n'est spécifié en 3ème position dans l'URL
                        if (!isset($route[3])) {
                            // Afficher la liste de toutes les adresses des utilisateurs
                            $this -> userController -> getUsersAddresses();
                        }
                
                        // Si l'identifiant "update" est spécifié en 3ème position dans l'URL
                        else if ($route[3] === "update") {
                            
                            // Si des données ont été envoyées en POST et que le nom du formulaire est "update-user-address"
                            if (!empty($_POST) && $_POST["formName"] === "update-user-address") {
                                // Mettre à jour l'adresse de l'utilisateur
                                $post = $_POST;
                                $this -> userController -> updateUserAddress($post, $route[4]);
                            }
                            
                            // Sinon, afficher la page de mise à jour d'adresse de l'utilisateur
                            else {
                                $this -> pageController -> updateUsersAddresses($route[4]);
                            }
                        }
                
                        // Si l'identifiant "delete" est spécifié en 3ème position dans l'URL
                        else if ($route[3] === "delete") {
                            // Supprimer l'adresse de l'utilisateur
                            $this -> userController -> deleteUserAddress($route[3]);
                        }
                    }
                
                    // Si l'identifiant "update" est spécifié en 2ème position dans l'URL
                    else if ($route[2] === "update") {
                
                        // Si des données ont été envoyées en POST et que le nom du formulaire est "update-user"
                        if (!empty($_POST) && $_POST["formName"] === "update-user") {
                            // Mettre à jour les informations de l'utilisateur
                            $post = $_POST;
                            $this -> userController -> updateUser($post, $route[3]);
                        }
                        
                        // Sinon, afficher la page de mise à jour des informations de l'utilisateur
                        else {
                            $this -> pageController -> updateUsers($route[3]);
                        }
                    }
                
                    // Si l'identifiant "delete" est spécifié en 2ème position dans l'URL
                    else if ($route[2] === "delete") {
                        // Supprimer l'utilisateur
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
                $this->pageController->error404();
            }
        }
    }
}
            
?>
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
        $userId = $_SESSION["id"];
        $userConnected = $this->um->getUserById($userId);
        $tab = [
            "username" => $userConnected->getUsername(),
            "prenom" => $userConnected->getFirstName(),
            "nom" => $userConnected->getLastName(),
            "email" => $userConnected->getEmail(),
            "date_de_naissance" => $userConnected->getBirthday(),
            "role" => $userConnected->getRole()
            ];
        $this->render("mon-compte", $tab);
    }
    
    public function accueil() {
        $products = $this->prm->getNouveautes();
        $this->render("accueil", $products); 
    }
    
    public function panier() {
        
        // Récupération du panier
        $cart = [];
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $product = $this->prm->getProductById($product_id);
                $cart[] = $quantity;
            }
        }
    
        // Affichage de la page
        $data = [
            'cart' => $cart,
        ];
        $this->render('panier', $data);
    }

    public function addPanier() {
        
        // Vérifiez si les données de la requête POST ont été envoyées
        if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    
            // Récupérez les valeurs du formulaire
            $productId = $_POST['product_id'];
            $quantity = intval($_POST['quantity']); // normalement ça ça devrait le transformer en int
    
            // Vérifiez si le panier existe en session
            if (!isset($_SESSION['cart'])) {
                // Si le panier n'existe pas, créez-le sous forme de tableau vide
                $_SESSION['cart'] = [];
            }
    
            // Vérifiez si le produit est déjà dans le panier
            if (isset($_SESSION['cart'][$productId])) {
                // Si le produit est déjà dans le panier, ajoutez la quantité
                $_SESSION['cart'][$productId] += $quantity;
            } else {
                // Sinon, ajoutez le produit et la quantité au panier
                $_SESSION['cart'][$productId] = $quantity;
            }
            
            echo json_encode("OK");
    
            //Redirigez l'utilisateur vers la page du panier
            //header('Location: /res03-projet-final/panier');
            //exit();
        }
        else{
            echo json_encode("NOK");
        }
    }
    
    public function deleteFromCart($id) {
        
        foreach ($_SESSION["cart"] as $index => $produit) {
            if ($produit === $id) {
                $_SESSION["cart"][$index] = "";

                header("Location: /res03-projet-final/monPanier");
                die();
            }
        }
    }
    
    public function nouveautes() {
        
        $products = $this->prm->getNouveautes();
        $this->render("nouveautes", $products); 
    }
    
    public function newsletter() {
        $this->render("newsletter", ["page de la newsletter"]);
    }
    
    public function listeCategories() {
        $categories = $this->cm->getAllCategoriesWithPictures();
        $this->render("liste-categories", $categories); 
    }
    
    public function displayOneCategory(string $slug) {
        
        $category = $this->cm->getCategoryByTitle($this->prm->createTitle($slug));
        $products = $this->prm->getAllProductsWithPicturesByCategory($this->prm->createTitle($slug));
        $pictures = $this->pm->getPicturesByCategory($category);
        $tab = [
            "category" => $category,
            "products" => $products,
            "pictures" => $pictures
            ];
        $this->render("category", $tab);
    }
    
    public function displayOneProduct(int $id) {
        
        $product = $this->prm->getProductById($id);
        $category = $this->prm->getCategoryOfProduct($product);
        $pictures = $this->pm->getPicturesByProduct($product);
        $tab = [
            "product" => $product,
            "category" => $category,
            "pictures" => $pictures
            ];
        $this->render("product",$tab);
    }

    public function error404() {
        $this->render("error404", ["page de l'error 404"]); 
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
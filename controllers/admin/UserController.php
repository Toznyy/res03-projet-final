<?php

class UserController extends AbstractController {
    private UserManager $um;
    private AddressManager $am;

    public function __construct() {
        $this->um = new UserManager();
        $this->am = new AddressManager();
    }

    public function getUsersAddresses() {

        $users = $this->um->getAllUsersWithAddresses();
        $this->renderPrivate("admin-users-addresses", ["users" => $users]);
    }
    
    public function getUsers() {

        $users = $this->um->getAllUsers();
        $this->renderPrivate("admin-users", ["users" => $users]);
    }

    public function getUser(string $get) {
        
        $id = intval($get);
        $user = $this -> prm->getUserById($id);
        $userTab = $user->toArray();
        
        $this->renderPrivate("admin-user", [$userTab]);
    }

    public function createUser(array $post) {

        if (empty($post)) {
            $this -> render("creation", []);
        }

        else {
            
            if ((isset($post["username"]) && empty($post["username"])) || (isset($post["first_name"]) && empty($post["first_name"])) || (isset($post["last_name"]) && empty($post["last_name"])) || (isset($post["email"]) && empty($post["email"])) || (isset($post["password"]) && empty($post["password"])) || (isset($post["confirmPassword"]) && empty($post["confirmPassword"])) || (isset($post["birthday"]) && empty($post["birthday"]))) {

                $this -> render("creation", []);
                echo "L'un des champs n'est pas rempli.";
            }
            
            else {
                
                $date = date("Y-m-d");
                $newUser = new User($post['username'], $post['first_name'], $post['last_name'], $post['email'], $post['password'], $date, $post['birthday'], "customer");
                $user = $this->um->getUsernameAndEmail($newUser);

                if ($user !== null) {
                    
                    if ($user->getUsername() === $post['username']) {
                        
                        $this->render("creation", []);
                        echo "Le nom d'utilisateur existe déjà.";
                    }
                    
                    else {
                        
                        $this->render("creation", []);
                        echo "L'adresse e-mail existe déjà.";
                    }
                    
                } 
                
                else {
                    
                    if ($post["password"] !== $post["confirmpassword"]) {
                        
                        $this->render("creation", []);
                        echo "Les deux mots de passe ne sont pas identiques.";
                    }
                    else {
                        
                        $hash = password_hash($post["password"], PASSWORD_DEFAULT);
                        $date = date("Y-m-d");
                        $newUser = new User($post['username'], $post['first_name'], $post['last_name'], $post['email'], $hash, $date, $post['birthday'], "customer");
                        $user = $this->um->createUser($newUser);
                        $createdUser = $user->toArray();
                        $_SESSION["role"] = $recup->getRole();
                        $_SESSION["username"] = $recup->getUsername();
                        $_SESSION["email"] = $recup->getEmail();
                        header('Location: accueil');
                    }
                }
            }
        }
    }

    public function updateUser(array $post, string $get) {

        $id = intval($get);
        $user = $this->um->getUserById($id);
        
        $tab = [];
        
        $tab["user"] = $user;

        
        if(isset($post["formName"]))
        {
            var_dump($post);
            if(isset($post['username']) && isset($post['last_name']) && isset($post['first_name']) && isset($post['email']) && isset($post['password']) && isset($post['birthday']) && !empty($post['username']) && !empty($post['last_name']) && !empty($post['first_name']) && !empty($post['email']) && !empty($post['password']) && !empty($post['birthday'])) {
                
                $userToUpdate = $this->um->getUserById($id);
                var_dump($userToUpdate);
                $userToUpdate->setUsername($post['username']);
                $userToUpdate->setlast_name($post['last_name']);
                $userToUpdate->setfirst_name($post['first_name']);
                $userToUpdate->setEmail($post['email']);
                $userToUpdate->setBirthday($post['birthday']);
                
                $this->um->updateUser($userToUpdate);
                header("Location: /res03-projet-final/admin/users");
            }
            else {
                echo "ca marche paaaaaaas<br>";
            }
        }
        else
        {
            $this->renderPrivate("admin-users-update", $tab);
        }
    }
    
    public function updateUserAddress(array $post, string $get) {

        $id = intval($get);
        $user = $this->cm->getUserById($id);
        $address = $this->pm->getAdressById($id);
        
        $tab = [];
        
        $tab["user"] = $user;
        $tab["address"] = $address;
        
        
        if(isset($post["formName"]))
        {
            if(isset($post['username']) && isset($post['last_name']) && isset($post['first_name']) && isset($post['email']) && isset($post['number']) && isset($post['street']) && isset($post['postal_code']) && isset($post['city']) && isset($post['password']) && isset($post['registration_date']) && isset($post['birthday']) && !empty($post['username']) && !empty($post['last_name']) && !empty($post['first_name']) && !empty($post['email']) && !empty($post['number']) && !empty($post['street']) && !empty($post['postal_code']) && !empty($post['city']) && !empty($post['password']) && !empty($post['registration_date']) && !empty($post['birthday'])) {
                
                $userToUpdate = $this->um->getUserById($id);
                $addressToUpdate = $this->am->getAdressById($id);
                
                $userToUpdate->setUsername($post['username']);
                $userToUpdate->setlast_name($post['last_name']);
                $userToUpdate->setfirst_name($post['first_name']);
                $userToUpdate->setEmail($post['email']);
                $userToUpdate->setURL($post['registration_date']);
                $userToUpdate->setCaption($post['birthday']);
                
                $addressToUpdate->setNumber($post['number']);
                $addressToUpdate->setStreet($post['street']);
                $addressToUpdate->setPostalCode($post['postal_code']);
                $addressToUpdate->setCity($post['city']);
                
                $this->cm->updateCategory($userToUpdate);
                $this->am->updateAddress($addressToUpdate);
                header("Location: /res03-projet-final/admin/users/addresses");
            }
            else {
                echo "ca marche paaaaaaas<br>";
            }
        }
        else
        {
            $this->renderPrivate("admin-users-update", $tab);
        }
    }

    public function deleteUser(string $get) : void {

        $id = intval($get);
        $userToDelete = $this->um->getUserById($id);
        $user = $this->um->deleteUser($userToDelete);

        header("Location: /res03-projet-final/admin/users");
    }

    public function favorites() {
        $p = 1;
    }
    
    public function deconnexion(){
        
        session_destroy();
        
        var_dump($_SESSION);
        header('Location: accueil');
    }
}

?>
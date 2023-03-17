<?php

class UserController extends AbstractController {
    private UserManager $um;

    public function __construct() {
        $this -> um = new UserManager();
    }

    public function getUsers() {

        $users = $this -> um -> getAllUsers();
        $usersTab = [];
        foreach($users as $user) {

            $userTab = $user -> toArray();
            $usersTab[] = $userTab;
        }

        $this -> render("users", [$usersTab]);
    }

    public function getUser() {
        $user = $this -> um -> getUserById($_SESSION['id']);
        $userTab = $user -> toArray();

        $this -> render("mon-compte", [$userTab]);
    }

    public function createUser(array $post) {

        if (empty($post)) {
            $this -> render("creation", []);
        }

        else {
            
            if ((isset($post["username"]) && empty($post["username"])) || (isset($post["firstname"]) && empty($post["firstname"])) || (isset($post["lastname"]) && empty($post["lastname"])) || (isset($post["email"]) && empty($post["email"])) || (isset($post["password"]) && empty($post["password"])) || (isset($post["confirmPassword"]) && empty($post["confirmPassword"])) || (isset($post["birthday"]) && empty($post["birthday"]))) {

                $this -> render("creation", []);
                echo "L'un des champs n'est pas rempli.";
            }
            
            else {
                
                $date = date("Y-m-d");
                $newUser = new User($post['username'], $post['firstname'], $post['lastname'], $post['email'], $post['password'], $date, $post['birthday'], "customer");
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
                        $newUser = new User($post['username'], $post['firstname'], $post['lastname'], $post['email'], $hash, $date, $post['birthday'], "customer");
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

    public function updateUser(array $post) {

        $newUser = new User($user['username'], $user['firstname'], $user['lastname'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], "customer");
        $user = $this -> um -> updateUser($newUser);
        $updatedUser = $user -> toArray();
        $this -> render($updatedUser);
    }

    public function deleteUser(array $post) {

        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], "customer");
        $user = $this -> um -> deleteUser($newUser);
        $deletedUser = $user -> toArray();
        return $this -> getUsers;
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
<?php

class LoginController extends AbstractController {
    private UserManager $um;

    public function __construct() {
        $this -> um = new UserManager();
    }
    
    public function connexion(array $post) {
    
        if (empty($post)) {
            $this -> render("connexion", []);
        }
    
        else {
    
            if ((isset($post["username"]) && !empty($post["username"])) && (isset($post["password"]) && !empty($post["password"]))) {
    
                $recup = $this -> um -> loadUser($post["username"]);
                $mdp = $recup -> getPassword();
    
                if (password_verify($post["password"], $mdp)) {
                        
                    $_SESSION["role"] = $recup->getRole();
                    $_SESSION["id"] = $recup->getId();
                    $_SESSION["username"] = $recup->getUsername();
                    $_SESSION["email"] = $recup->getEmail();
                    header('Location: /res03-projet-final/accueil');
                }
    
                else {
                    $this -> render("connexion", []);
                    echo "Le mot de passe est incorrect";
                }
            }
    
            else if ((isset($post["username"]) && empty($post["username"])) || (isset($post["password"]) && empty($post["password"]))) {
    
                $this -> render("connexion", []);
                echo "L'un des champs n'est pas rempli.";
            }
        }
    }
}
    
?>
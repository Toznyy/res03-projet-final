<?php

class LoginController extends AbstractController {
    private UserManager $um;

    public function __construct() {
        $this -> um = new UserManager();
    }
    
    public function connexion(array $post) {
        
        $errorMessage = '';
        
        if (empty($post)) {
            
            $this->render("connexion", []);
        } 
        else {
            
            if ((isset($post["username"]) && !empty($post["username"])) && (isset($post["password"]) && !empty($post["password"]))) {
                $recup = $this->um->loadUser($this->clean($post["username"]));
                if($recup !== null)
                {
                    $usernameCheck = $this->clean($post["username"]);
                    $mdp = $recup->getPassword();
                
                    $userCheck = $this->um->getUserByUsername($usernameCheck);
                
                    if ($userCheck !== null) {
                        
                        if (password_verify($this->clean($post["password"]), $mdp)) {
                            
                            $_SESSION["role"] = $recup->getRole();
                            $_SESSION["id"] = $recup->getId();
                            $_SESSION["username"] = $recup->getUsername();
                            $_SESSION["email"] = $recup->getEmail();
                            header('Location: /res03-projet-final/accueil');
                        }
                        
                        else {
                            $errorMessage = "Le mot de passe est incorrect";
                            $this->render("connexion", ['errorMessage' => $errorMessage]);
                        }
                    }
                    
                    else {
                        $errorMessage = "L'identifiant n'existe pas";
                        $this->render("connexion", ['errorMessage' => $errorMessage]);
                    }
                }
                else
                {
                    $errorMessage = "Identifiants incorrects";
                    $this->render("connexion", ['errorMessage' => $errorMessage]);
                }
                
            } 
            else if ((isset($post["username"]) && empty($post["username"])) || (isset($post["password"]) && empty($post["password"]))) {
                $errorMessage = "L'un des champs n'est pas rempli.";
                $this->render("connexion", ['errorMessage' => $errorMessage]);
            }
        }
    }
}
    
?>
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

    public function createUser($post) {
        
        if (!empty($post)) {
            $errorMessage = '';
    
            // Vérification des champs obligatoires
            if (empty($post['username']) || empty($post['email']) || empty($post['password']) || empty($post['confirmpassword'])) {
                $errorMessage = "L'un des champs n'est pas rempli.";
            } else {
                // Vérification de la validité de l'adresse email
                if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                    $errorMessage = "L'adresse email n'est pas valide.";
                } else {
                    // Vérification que les mots de passe sont identiques
                    if ($post['password'] !== $post['confirmpassword']) {
                        $errorMessage = "Les mots de passe ne sont pas identiques.";
                    } else {
                        // Création d'un nouvel utilisateur
                        $date = date("Y-m-d");
                        $user = new User($this->clean($post['username']), $this->clean($post['first_name']), $this->clean($post['last_name']), $this->clean($post['email']), $this->clean($post['password']), $date , $this->clean($post['birthday']), "customer");
                        $user->setUsername($this->clean($post['username']));
                        $user->setEmail($this->clean($post['email']));
                        $user->setPassword(password_hash($this->clean($post['password']), PASSWORD_DEFAULT));
                        $user->setFirstName($this->clean($post['first_name']));
                        $user->setLastName($this->clean($post['last_name']));
                        $user->setBirthday($this->clean($post['birthday']));
    
                        try {
                            $this->um->createUser($user);
                            $this->render('accueil', ['message' => 'Votre compte a bien été créé.']);
                            return;
                        } catch (\Exception $e) {
                            $errorMessage = 'Une erreur s\'est produite lors de la création de votre compte.';
                        }
                    }
                }
            }
    
            // Si une erreur s'est produite, on affiche le formulaire avec le message d'erreur correspondant
            $this->render('creation', ['errorMessage' => $errorMessage]);
        } else {
            $this->render('creation');
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
                $userToUpdate->setUsername($this->clean($post['username']));
                $userToUpdate->setlast_name($this->clean($post['last_name']));
                $userToUpdate->setfirst_name($this->clean($post['first_name']));
                $userToUpdate->setEmail($this->clean($post['email']));
                $userToUpdate->setBirthday($this->clean($post['birthday']));
                
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
                
                $userToUpdate->setUsername($this->clean($post['username']));
                $userToUpdate->setlast_name($this->clean($post['last_name']));
                $userToUpdate->setfirst_name($this->clean($post['first_name']));
                $userToUpdate->setEmail($this->clean($post['email']));
                $userToUpdate->setURL($this->clean($post['registration_date']));
                $userToUpdate->setCaption($this->clean($post['birthday']));
                
                $addressToUpdate->setNumber($this->clean($post['number']));
                $addressToUpdate->setStreet($this->clean($post['street']));
                $addressToUpdate->setPostalCode($this->clean($post['postal_code']));
                $addressToUpdate->setCity($this->clean($post['city']));
                
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
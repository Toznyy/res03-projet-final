<?php

// Définition de la classe UserManager
class UserManager extends AbstractManager {

    // Retourne un tableau de tous les utilisateurs
    public function getAllUsers() : array {
        
        // Prépare la requête SQL pour récupérer tous les utilisateurs
        $query = $this->db->prepare("SELECT * FROM users");
        // Exécute la requête SQL
        $query->execute();
        // Récupère tous les utilisateurs sous forme de tableau associatif
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Initialise un tableau vide pour stocker les objets User
        $usersTab=[];
        // Pour chaque utilisateur dans le tableau associatif récupéré, créer un nouvel objet User et l'ajouter au tableau $usersTab
        foreach($users as $user){
            $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], "customer");
            $newUser->setId($user['id']);
            array_push($usersTab, $newUser);
        }
        // Retourne le tableau d'utilisateurs
        return $usersTab;
    }
    
    // Associe un utilisateur à une adresse
    public function UsersJoinAddresses($user_id, $address_id) {
        
        // Prépare la requête SQL pour ajouter un utilisateur et une adresse à la table de liaison
        $query = $this->db->prepare("INSERT INTO users_addresses VALUES (:user_id, :address_id)");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "user_id" => $user_id,
            "address_id" => $address_id
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
    }
    
    // Retourne un tableau d'utilisateurs avec leurs adresses associées
    public function getAllUsersWithAddresses() : array {
        
        // Prépare la requête SQL pour récupérer tous les utilisateurs avec leurs adresses associées
        $query = $this->db->prepare("SELECT * FROM users JOIN (users_addresses JOIN addresses ON users_addresses.address_id = addresses.id) ON users.id = users_addresses.user_id");
        // Exécute la requête SQL
        $query->execute();
        // Récupère tous les utilisateurs avec leurs adresses associées sous forme de tableau associatif
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        // Retourne le tableau d'utilisateurs avec leurs adresses associées
        return $users;
    }
    
    // Retourne un tableau d'un utilisateur avec ses adresses associées en fonction de son id
    public function getAllUsersWithAddressesById(int $id) : array {
        
        // Prépare la requête SQL pour récupérer un utilisateur et ses adresses associées en fonction de son id
        $query = $this->db->prepare("SELECT * FROM users JOIN (users_addresses JOIN addresses ON users_addresses.address_id = addresses.id) ON users.id = users_addresses.user_id WHERE id = :id");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "id" => $id
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupère l'utilisateur et ses adresses associées sous forme de tableau associatif
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        // Retourne le tableau d'utilisateurs avec leurs adresses associées
        return $users;
    }
    
    // Retourne un utilisateur par son id
    public function getUserById(int $id) : User {
            
        // Prépare la requête SQL pour récupérer un utilsateur en fonction de son id
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "id" => $id
            ];
        // Exécute la requête SQL avec les paramètres définis
        $exe = $query->execute($parameters);
        // Récupére l'utilsateur sous forme d'un tableau associatif
        $user = $query->fetch(PDO::FETCH_ASSOC);
        // Créer un nouvel objet User
        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], $user['role']);
        $newUser->setId($user['id']);
        // Retourne l'utilisateur créé sous forme d'objet
        return $newUser;
    }
    
    // Création d'un utilisateur
    public function createUser(User $user) : User {
        
        // Prépare la requête SQL pour insérer un nouvel utilisateur dans la base de données
        $query = $this->db->prepare("INSERT INTO users VALUES (null, :username, :first_name, :last_name, :email, :password, :registration_date, :birthday, :role)");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "username" => $user->getUsername(),
            "first_name" => $user->getfirstName(),
            "last_name" => $user->getlastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "registration_date" => $user->getRegistrationDate(),
            "birthday" => $user->getBirthday(),
            "role" => $user->getRole(),
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Prépare une autre requête SQL pour récupérer l'utilisateur créé par son pseudo
        $query = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        // Définit les paramètres de la requête SQL
        $parameters= [
            "username" => $user->getUsername()
            ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupére l'utilsateur sous forme d'un tableau associatif
        $user = $query->fetch(PDO::FETCH_ASSOC);
        // Créer un nouvel objet User
        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], "customer");
        $newUser->setId($user['id']);
        // Retourne l'utilisateur créé sous forme d'objet
        return $newUser;
    }
    
    // Modification d'un utilisateur
    public function updateUser(User $user) : void {
        
        // Prépare la requête SQL pour récupérer l'utilisateur à modifier par son id
        $query = $this->db->prepare("UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, email = :email, password = :password, registration_date = :registration_date, birthday = :birthday WHERE id = :id");
        // Définit les paramètres de la requête SQL
        $parameters= [
        "id" => $user->getId(),
        "username"=>$user->getUsername(),
        "first_name"=> $user->getFirstName(),
        "last_name" =>$user->getLastName(),
        "email" => $user->getEmail(),
        "password" => $user->getPassword(),
        "registration_date" => $user->getRegistrationDate(),
        "birthday" => $user->getBirthday()
        ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
    }
    
    // Suppression d'un utilisateur
    public function deleteUser(User $user) : array {
        
        // Prépare une autre requête SQL pour supprimer l'utilisateur à modifier par son email
        $query = $this->db->prepare("DELETE FROM users WHERE email = :email");
        // Définit les paramètres de la requête SQL
        $parameters = ["email" => $user->getEmail()];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Retourne tous les utilisateurs sauf celui qui vient d'être supprimé
        return $this->getAllUsers();
        
    }
    
    // Vérifier l'existence d'un utiisateur
    public function getUsernameAndEmail(User $user) : ?User {
        
        // Prépare une autre requête SQL pour vérifier l'existence d'un utilisateur par son pseudo ou son email
        $query = $this->db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        // Définit les paramètres de la requête SQL
        $parameters = [
            "username" => $user->getUsername(),
            "email" => $user->getEmail()
        ];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupére l'utilsateur sous forme d'un tableau associatif
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        // Condition d'existence de l'utilsateur
        if($user) {
            // Crée un nouvel objet User
            $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], "customer");
            $newUser->setId($user["id"]);
            // Retourne l'utilisateur créé sous forme d'objet
            return $newUser;
        }
        else {
            // Retourne null
            return null;
        }
    }
    
    // Récupérer un utilisateur pour le connecter
    function loadUser(string $username) : User {
        
        // Prépare une autre requête SQL pour récupérer l'utilisateur par son pseudo
        $query = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        // Définit les paramètres de la requête SQL
        $parameters = ["username" => $username];
        // Exécute la requête SQL avec les paramètres définis
        $query->execute($parameters);
        // Récupére l'utilsateur sous forme d'un tableau associatif
        $user = $query->fetch(PDO::FETCH_ASSOC);
        // Crée un nouvel objet User
        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], $user['role']);
        $newUser->setId($user["id"]);
        // Retourne l'utilisateur créé sous forme d'objet
        return $newUser;
    }
    
    // Récupérer les produits favoris de l'utilisateur
    public function favorites(User $user) : array {
        
        // Prépare une autre requête SQL pour récupérer l'utilisateur par son pseudo
        $query = $this->db->prepare("SELECT * FROM users JOIN (favorites JOIN products ON favorites.product_id = products.id) ON users.id = favorites.user_id WHERE ");
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
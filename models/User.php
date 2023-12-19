<?php

// Définition de la classe User
class User {
    
    // Attributs de la classe
    private ?int $id; 
    private string $username;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password; 
    private string $registration_date;
    private string $birthday; 
    private string $role;
    
    // Constructeur de la classe
    public function __construct(string $username, string $first_name, string $last_name, string $email, string $password, string $registration_date, string $birthday, string $role) {
        
        // Initialisation des attributs
        $this->id = null;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->registration_date = $registration_date;
        $this->birthday = $birthday;
        $this->role = $role;
        
    }
    
    // Accesseur pour l'ID de l'utilisateur
    public function getId() : ?int {
        return $this->id;
    }

    // Mutateur pour l'ID de l'utilisateur
    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    // Accesseur pour le nom d'utilisateur
    public function getUsername() : string {
        return $this->username;
    }
    
    // Mutateur pour le nom d'utilisateur
    public function setUsername(string $username) : void {
        $this->username = $username;
    }
    
    // Accesseur pour le prénom de l'utilisateur
    public function getFirstName() : string {
        return $this->first_name;
    }
    
    // Mutateur pour le prénom de l'utilisateur
    public function setFirstName(string $first_name) : void {
        $this->first_name = $first_name;
    }
    
    // Accesseur pour le nom de famille de l'utilisateur
    public function getLastName() : string {
        return $this->last_name;
    }
    
    // Mutateur pour le nom de famille de l'utilisateur
    public function setLastName(string $last_name) : void {
        $this->last_name = $last_name;
    }
    
    // Accesseur pour l'adresse email de l'utilisateur
    public function getEmail() : string {
        return $this->email;
    }
    
    // Mutateur pour l'adresse email de l'utilisateur
    public function setEmail(string $email) : void {
        $this->email = $email;
    }
    
    // Accesseur pour le mot de passe de l'utilisateur
    public function getPassword() : string {
        return $this->password;
    }
    
    // Mutateur pour le mot de passe de l'utilisateur
    public function setPassword(string $password) : void {
        $this->password = $password;
    }
    
    // Méthode qui renvoie la date d'inscription de l'utilisateur
    public function getRegistrationDate() : string {
        return $this->registration_date;
    }
    
    // Méthode qui définit la date d'inscription de l'utilisateur
    public function setRegistrationDate(string $registration_date) : void {
        $this->registration_date = $registration_date;
    }
    
    // Méthode qui renvoie la date de naissance de l'utilisateur
    public function getBirthday() : string {
        return $this->birthday;
    }
    
    // Méthode qui définit la date de naissance de l'utilisateur
    public function setBirthday(string $birthday) : void {
        $this->birthday = $birthday;
    }
    
    // Méthode qui renvoie le rôle de l'utilisateur
    public function getRole() : string {
        return $this->role;
    }
    
    // Méthode qui définit le rôle de l'utilisateur
    public function setRole(string $role) : void {
        $this->role = $role;
    }
    
    // Méthode qui transforme les attributs de l'objet en un tableau associatif
    public function toArray() : array
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "password" => $this->password,
            "registration_date" => $this->registration_date,
            "birthday" => $this->birthday
        ];
    }
}

?>
<?php

// Définition de la classe Picture
class Picture {
    
    // Attributs de la classe
    private ?int $id;
    private string $URL;
    private string $caption;
    private string $role;
    
    // Constructeur de la classe
    public function __construct(string $URL, string $caption, string $role) {
        
        // Initialisation des attributs
        $this->id = null;
        $this->URL = $URL;
        $this->caption = $caption;
        $this->role = $role;
    }
    
    // Accesseur pour l'ID de l'image
    public function getId() : ?int {
        return $this->id;
    }
    
    // Mutateur pour l'ID de l'image
    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    // Accesseur pour l'URL de l'image
    public function getURL() : string {
        return $this->URL;
    }
    
    // Mutateur pour l'URL de l'image
    public function setURL(string $URL) : void {
        $this->URL = $URL;
    }
    
    // Accesseur pour la caption de l'image
    public function getCaption() : string {
        return $this->caption;
    }
    
    // Mutateur pour la caption de l'image
    public function setCaption(string $caption) : void {
        $this->caption = $caption;
    }
    
    // Accesseur pour le role de l'image
    public function getRole() : string {
        return $this->role;
    }
    
    // Mutateur pour le role de l'image
    public function setRole(string $role) : void {
        $this->role = $role;
    }
    
    // Méthode qui transforme les attributs de l'objet en un tableau associatif
    public function toArray() : array
    {
        return [
            "id" => $this->id,
            "URL" => $this->URL,
            "caption" => $this->caption,
            "role" => $this->role
        ];
    }
}

?>
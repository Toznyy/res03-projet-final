<?php

// Définition de la classe Category
class Category {
    
    // Attributs de la classe
    private ?int $id;
    private string $title;
    private string $description;
    
    // Constructeur de la classe
    public function __construct(string $title, string $description) {
        
        // Initialisation des attributs
        $this->id = null;
        $this->title = $title;
        $this->description = $description;
    }
    
    // Accesseur pour l'ID de la catégorie
    public function getId() : ?int {
        return $this->id;
    }
    
    // Mutateur pour l'ID de la catégorie
    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    // Accesseur pour le titre de la catégorie
    public function getTitle() : string {
        return $this->title;
    }
    
    // Mutateur pour le titre de la catégorie
    public function setTitle(string $title) : void {
        $this->title = $title;
    }
    
    // Accesseur pour la description de la catégorie
    public function getDescription() : string {
        return $this->description;
    }
    
    // Mutateur pour la description de la catégorie
    public function setDescription(string $description) : void {
        $this->description = $description;
    }
    
    // Méthode qui transforme les attributs de l'objet en un tableau associatif
    public function toArray() : array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description
        ];
    }
}

?>
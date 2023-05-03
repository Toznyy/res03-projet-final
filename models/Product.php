<?php

// Définition de la classe Product
class Product {
    
    // Attributs de la classe
    private ?int $id;
    private string $name;
    private string $description;
    private string $price;
    
    // Constructeur de la classe
    public function __construct(string $name, string $description, string $price) {
        
        // Initialisation des attributs
        $this->id = null;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        
    }
    
    // Accesseur pour l'ID du produit
    public function getId() : int {
        return $this->id;
    }
    
    // Mutateur pour l'ID du produit
    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    // Accesseur pour le nom du produit
    public function getName() : string {
        return $this->name;
    }
    
    // Mutateur pour le nom du produit
    public function setName(string $name) : void {
        $this->name = $name;
    }
    
    // Accesseur pour la description du produit
    public function getDescription() : string {
        return $this->description;
    }
    
    // Mutateur pour la description du produit
    public function setDescription(string $description) : void {
        $this->description = $description;
    }
    
    // Accesseur pour le prix du produit
    public function getPrice() : string {
        return $this->price;
    }
    
    // Mutateur pour le prix du produit
    public function setPrice(string $price) : void {
        $this->price = $price;
    }
    
    // Méthode qui transforme les attributs de l'objet en un tableau associatif
    public function toArray() : array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price
        ];
    }
}

?>
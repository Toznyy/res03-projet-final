<?php

// Définition de la classe Order
class Order {
    
    // Attributs de la classe
    private ?int $id;
    private string $reference;
    private string $date;
    private string $price;
    private ?int $user_id;
    
    // Constructeur de la classe
    public function __construct(string $reference, string $date, float $price) {
        
        // Initialisation des attributs
        $this->id = null;
        $this->reference = $reference;
        $this->date = $date;
        $this->price = $price;
        $this->user_id = null;
        
    }
    
    // Accesseur pour l'ID de la commande
    public function getId() : ?int {
        return $this->id;
    }
    
    // Mutateur pour l'ID de la commande
    public function setId(?int $id) : void {
        $this->id = $id;
    }
    
     // Accesseur pour la référence de la commande
    public function getReference() : string {
        return $this->reference;
    }
    
    // Mutateur pour la référence de la commande
    public function setReference(string $reference) : void {
        $this->reference = $reference;
    }
    
     // Accesseur pour la date de la commande
    public function getDate() : string {
        return $this->date;
    }
    
    // Mutateur pour la date de la commande
    public function setDate(string $date) : void {
        $this->date = $date;
    }
    
     // Accesseur pour le prix de la commande
    public function getPrice() : float {
        return $this->price;
    }
    
    // Mutateur pour le prix de la commande
    public function setprice(float $price) : void {
        $this->price = $price;
    }
    
     // Accesseur pour l'ID de l'utilisateur à l'origine de la commande
    public function getUserId() : int {
        return $this->user_id;
    }
    
    // Mutateur pour l'ID de l'utilisateur à l'origine de la commande
    public function setUserId(int $id) : void {
        $this->user_id = $user_id;
    }
    
    // Méthode qui transforme les attributs de l'objet en un tableau associatif
    public function toArray() : array
    {
        return [
            "id" => $this->id,
            "reference" => $this->reference,
            "date" => $this->date,
            "price" => $this->price
        ];
    }
}

?>
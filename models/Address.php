<?php

// Définition de la classe Address
class Address {
    
    // Attributs de la classe
    private ?int $id;
    private string $number;
    private string $street;
    private string $postal_code;
    private string $city;
    
    // Constructeur de la classe
    public function __construct(string $number, string $street, string $postal_code, string $city) {
            
        // Initialisation des attributs
        $this->id = null;
        $this->number = $number;
        $this->street = $street;
        $this->postal_code = $postal_code;
        $this->city = $city;
    }
    
    // Accesseur pour l'ID de l'adresse
    public function getId() : ?int {
        return $this->id;
    }
    
    // Mutateur pour l'ID de l'adresse
    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    // Accesseur pour le numéro de l'adresse
    public function getNumber() : string {
        return $this->number;
    }
    
    // Mutateur pour le numéro de l'adresse
    public function setNumber(string $number) : void {
        $this->number = $number;
    }
    
    // Accesseur pour la rue de l'adresse
    public function getStreet() : string {
        return $this->street;
    }
    
    // Mutateur pour la rue de l'adresse
    public function setStreet(string $street) : void {
        $this->street = $street;
    }
    
    // Accesseur pour le code postal de l'adresse
    public function getPostalCode() : string {
        return $this->postal_code;
    }
    
    // Mutateur pour le code postal de l'adresse
    public function setTitle(string $postal_code) : void {
        $this->postal_code = $postal_code;
    }
    
    // Accesseur pour la ville de l'adresse
    public function getCity() : string {
        return $this->city;
    }
    
    // Mutateur pour la ville de l'adresse
    public function setCity(string $city) : void {
        $this->city = $city;
    
    }
    
    // Méthode qui transforme les attributs de l'objet en un tableau associatif
    public function toArray() : array
    {
        return [
            "id" => $this->id,
            "number" => $this->number,
            "street" => $this->street,
            "postal_code" => $this->postal_code,
            "city" => $this->city
        ];
    }
}

?>
<?php

class Address {
    
    private ?int $id;
    private string $number;
    private string $street;
    private string $postal_code;
    private string $city;

    public function __construct(string $number, string $street, string $postal_code, string $city) {
        
        $this->id = null;
        $this->number = $number;
        $this->street = $street;
        $this->postal_code = $postal_code;
        $this->city = $city;
    }
    
    public function getId() : ?int {
        return $this->id;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    public function getNumber() : string {
        return $this->number;
    }
    
    public function setNumber(string $number) : void {
        $this->number = $number;
    }
    
    public function getStreet() : string {
        return $this->street;
    }
    
    public function setStreet(string $street) : void {
        $this->street = $street;
    }
    
    public function getPostalCode() : string {
        return $this->postal_code;
    }
    
    public function setTitle(string $postal_code) : void {
        $this->postal_code = $postal_code;
    }
    
    public function getCity() : string {
        return $this->city;
    }
    
    public function setCity(string $city) : void {
        $this->city = $city;
    
    }
    
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
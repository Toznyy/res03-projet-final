<?php

class Order {
    
    private ?int $id;
    private string $reference;
    private string $date;
    private ?int $user_id;

    public function __construct(string $reference, string $date) {
        
        $this->id = null;
        $this->reference = $reference;
        $this->date = $date;
        $this->user_id = null;
        
    }
    
    public function getId() : ?int {
        return $this->id;
    }

    public function setId(?int $id) : void {
        $this->id = $id;
    }
    
    public function getReference() : string {
        return $this->reference;
    }
    
    public function setReference(string $reference) : void {
        $this->reference = $reference;
    }
    
    public function getDate() : string {
        return $this->date;
    }
    
    public function setDate(string $date) : void {
        $this->date = $date;
    }
    
    public function getUserId() : int {
        return $this->user_id;
    }

    public function setUserId(int $id) : void {
        $this->user_id = $user_id;
    }
    
    public function toArray() : array
    {
        return [
            "id" => $this->id,
            "reference" => $this->reference,
            "date" => $this->date
        ];
    }
}

?>
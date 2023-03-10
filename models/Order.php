<?php

class Order {
    
    private ?int $id;
    private string $reference;
    private date $date;
    private ?int $user_id;

    public function __construct(string $reference, date $date) {
        
        $this->id = null;
        $this->title = $reference;
        $this->date = $date;
        $this->user_id = null;
        
    }
    
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    public function getTitle() : string {
        return $this->title;
    }
    
    public function setTitle(string $title) : void {
        $this->title = $title;
    }
    
    public function getDescription() : string {
        return $this->description;
    }
    
    public function setDescription(string $description) : void {
        $this->description = $description;
    }
}

?>
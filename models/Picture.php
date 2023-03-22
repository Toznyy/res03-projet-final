<?php

class Picture {
    
    private ?int $id;
    private string $URL;
    private string $caption;
    private string $role;

    public function __construct(string $URL, string $caption, string $role) {
        
        $this->id = null;
        $this->URL = $URL;
        $this->caption = $caption;
        $this->role = $role;
    }
    
    public function getId() : ?int {
        return $this->id;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    public function getURL() : string {
        return $this->URL;
    }
    
    public function setURL(string $URL) : void {
        $this->URL = $URL;
    }
    
    public function getCaption() : string {
        return $this->caption;
    }
    
    public function setDescription(string $caption) : void {
        $this->caption = $caption;
    }
    
    public function getRole() : string {
        return $this->role;
    }
    
    public function setRole(string $role) : void {
        $this->role = $role;
    }
    
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
<?php

class User {
    
    private ?int $id;
    private string $username;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;
    private string $registration_date;
    private string $birthday;
    private string $role;
    
    public function __construct(string $username, string $first_name, string $last_name, string $email, string $password, string $registration_date, string $birthday, string $role) {
        
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
    
    public function getId() : ?int {
        return $this->id;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    public function getUsername() : string {
        return $this->username;
    }
    
    public function setUsername(string $username) : void {
        $this->username = $username;
    }
    
    public function getFirstName() : string {
        return $this->first_name;
    }
    
    public function setFirstName(string $first_name) : void {
        $this->first_name = $first_name;
    }
    
    public function getLastName() : string {
        return $this->last_name;
    }
    
    public function setLastName(string $last_name) : void {
        $this->last_name = $last_name;
    }
    
    public function getEmail() : string {
        return $this->email;
    }
    
    public function setEmail(string $email) : void {
        $this->email = $email;
    }
    
    public function getPassword() : string {
        return $this->password;
    }
    
    public function setPassword(string $password) : void {
        $this->password = $password;
    }
    
    public function getRegistrationDate() : string {
        return $this->registration_date;
    }
    
    public function setRegistrationDate(string $registration_date) : void {
        $this->registration_date = $registration_date;
    }
    
    public function getBirthday() : string {
        return $this->birthday;
    }
    
    public function setBirthday(string $birthday) : void {
        $this->birthday = $birthday;
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
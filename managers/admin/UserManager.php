<?php

class UserManager extends AbstractManager {

    public function getAllUsers() : array {
        
        $query = $this->db->prepare("SELECT * FROM users");
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $usersTab=[];
        foreach($users as $user){
            $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], "customer");
            $newUser->setId($user['id']);
            array_push($usersTab, $newUser);
        }
        return $usersTab;
    }
    
    public function UsersJoinAddresses($user_id, $address_id) {
        
        $query = $this->db->prepare("INSERT INTO users_addresses VALUES (:user_id, :address_id)");
        $parameters = [
            "user_id" => $user_id,
            "address_id" => $address_id
            ];
        $query->execute($parameters);
    }
    
    public function getAllUsersWithAddresses() : array {
        
        $query = $this->db->prepare("SELECT * FROM users JOIN (users_addresses JOIN addresses ON users_addresses.address_id = addresses.id) ON users.id = users_addresses.user_id");
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    
    public function getAllUsersWithAddressesById(int $id) : array {
        
        $query = $this->db->prepare("SELECT * FROM users JOIN (users_addresses JOIN addresses ON users_addresses.address_id = addresses.id) ON users.id = users_addresses.user_id WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function getUserById(int $id) : User {
        
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $exe = $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], $user['role']);
        $newUser->setId($user['id']);
        return $newUser;
    }

    public function createUser(User $user) : User {
        
        $query = $this->db->prepare("INSERT INTO users VALUES (null, :username, :first_name, :last_name, :email, :password, :registration_date, :birthday, :role)");
        $parameters = [
            "username" => $user->getUsername(),
            "first_name" => $user->getfirstName(),
            "last_name" => $user->getlastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "registration_date" => $user->getRegistrationDate(),
            "birthday" => $user->getBirthday(),
            "role" => $user->getRole(),
            ];
        $query->execute($parameters);
        
        $query = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $parameters= [
            "username" => $user->getUsername()
            ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], "customer");
        $newUser->setId($user['id']);
        return $newUser;
    }

    public function updateUser(User $user) : void {
        
        $query = $this->db->prepare("UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, email = :email, password = :password, registration_date = :registration_date, birthday = :birthday WHERE id = :id");
        $parameters= [
        "id" => $user->getId(),
        "username"=>$user->getUsername(),
        "first_name"=> $user->getFirstName(),
        "last_name" =>$user->getLastName(),
        "email" => $user->getEmail(),
        "password" => $user->getPassword(),
        "registration_date" => $user->getRegistrationDate(),
        "birthday" => $user->getBirthday()
        ];
        $query->execute($parameters);
    }

    public function deleteUser(User $user) : array {
        
        $query = $this->db->prepare("DELETE FROM users WHERE email = :email");
        $parameters = ["email" => $user->getEmail()];
        $query->execute($parameters);
        return $this->getAllUsers();
        
    }
    
    public function getUsernameAndEmail(User $user) : ?User {
        
        $query = $this->db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $parameters = [
            "username" => $user->getUsername(),
            "email" => $user->getEmail()
        ];
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        if($user) {
            $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], "customer");
            $newUser->setId($user["id"]);
            return $newUser;
        }
        
        else {
            return null;
        }
    }
    
    function loadUser(string $username) : User {
        
        $query = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $parameters = ["username" => $username];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday'], $user['role']);
        $newUser->setId($user["id"]);
        return $newUser;
    }
    
    public function favorites(User $user) : array {
        
        $query = $this->db->prepare("SELECT * FROM users JOIN (favorites JOIN products ON favorites.product_id = products.id) ON users.id = favorites.user_id WHERE ");
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
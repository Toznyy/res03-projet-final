<?php

class UserController extends AbstractController {
    private UserManager $um;

    public function __construct()
    {
        $this->um = new UserManager();
    }

    public function getUsers() {
        
        $users = $this -> um->getAllUsers();
        $usersTab = [];
        foreach($users as $user) {
            
            $userTab = $user->toArray();
            $usersTab[]=$userTab;
        }
        
        $this->render($usersTab);
    }

    public function getUser(string $get)
    {
        $id = intval($get);
        $user = $this -> um->getUserById($id);
        $userTab = $user->toArray();
        
        $this->render($userTab);
    }

    public function createUser(array $post)
    {
        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday']);
        $user = $this->um->createUser($newUser);
        $createdUser = $user->toArray();
        $this->render($createdUser);
    }

    public function updateUser(array $post)
    {
        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday']);
        $user = $this->um->updateUser($newUser);
        $updatedUser = $user->toArray();
        $this->render($updatedUser);
    }

    public function deleteUser(array $post)
    {
        $newUser = new User($user['username'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['registration_date'], $user['birthday']);
        $user = $this->um->deleteUser($newUser);
        $deletedUser = $user->toArray();
        return $this->getUsers;
    }
    
    public function favorites()
}

?>
<?php

class CategoryManager extends AbstractManager {

    public function getAllCategories() : array {
        
        $query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $categoriesTab=[];
        foreach($categories as $category){
            $newCategory = new Category($category['id'], $category['title'], $category['description']);
            array_push($categoriesTab, $newCategory);
        }
        return $categoriesTab;
    }

    public function getCategoryById(int $id) : Category {
        
        $query = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $category = $query->fetch(PDO::FETCH_ASSOC);
        $newCategory = new Category($category["id"], $category["title"], $category["description"]);
        return $newCategory;
    }

    public function createCategory(Category $category) : Category {
        
        $query = $this->db->prepare("INSERT INTO categories VALUES (null, :title, :description)");
        $parameters = [
            "title" => $user->getTitle(),
            "description" => $user->getDescription(),
            ];
        $query->execute($parameters);
        
        $query = $this->db->prepare("SELECT * FROM categories WHERE title = :title");
        $parameters= [
            "title" => $user->getTitle()
            ];
        $query->execute($parameters);
        $category = $query->fetch(PDO::FETCH_ASSOC);
        $newCategory = new Category($category["id"],$category["title"],$category["description"]);
        return $newCategory;
    }

    public function updateCategory(Category $category) : Category {
        
        $query = $this->db->prepare("UPDATE categories SET title = :title, description = :description");
        $parameters= [
        "id" => $user->getId(),
        "title"=>$user->getTitle(),
        "description"=> $user->getDescription(),
        ];
        $query->execute($parameters);
        $query = $this->db->prepare("SELECT * FROM categories WHERE title = :title");
        $parameters = ["title" => $user->getTitle()];
        $query->execute($parameters);
        $category = $query->fetch(PDO::FETCH_ASSOC);
        $newCategory = new Category($category["id"], $category["title"], $category["description"]);
        return $newCategory;
    }

    public function deleteCategory(Category $category) : array {
        
        $query = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        $parameters = ["id" => $user->getId()];
        $query->execute($parameters);
        return $this->getAllCategories();
    }
}

?>
<?php

class CategoryManager extends AbstractManager {

    public function getAllCategories() : array {
        
        $query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $categoriesTab=[];
        foreach($categories as $category){
            $newCategory = new Category($category['title'], $category['description']);
            $newCategory->setId($category['id']);
            array_push($categoriesTab, $newCategory);
        }
        return $categoriesTab;
    }
    
    public function CategoriesJoinPictures($picture_id, $category_id) {
        
        $query = $this->db->prepare("INSERT INTO categories_pictures VALUES (:picture_id, :category_id)");
        $parameters = [
            "picture_id" => $picture_id, 
            "category_id" => $category_id
            ];
        $query->execute($parameters);
    }
    
    public function getAllCategoriesWithPictures() : array {
        
        $query = $this->db->prepare("SELECT * FROM categories JOIN (categories_pictures JOIN pictures ON categories_pictures.picture_id = pictures.id) ON categories.id = categories_pictures.category_id");
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
    
    public function getAllCategoriesWithPicturesById(int $id) : array {
        
        $query = $this->db->prepare("SELECT * FROM categories JOIN (categories_pictures JOIN pictures ON categories_pictures.picture_id = pictures.id) ON categories.id = categories_pictures.category_id WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
    

    public function getCategoryById(int $id) : Category {
        
        $query = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $category = $query->fetch(PDO::FETCH_ASSOC);
        $newCategory = new Category($category["title"], $category["description"]);
        $newCategory->setId($category['id']);
        return $newCategory;
    }
    
    public function getCategoryByTitle(string $title) : Category {
        
        $query = $this->db->prepare("SELECT * FROM categories WHERE title = :title");
        $parameters = [
            "title" => $title
            ];
        $query->execute($parameters);
        $category = $query->fetch(PDO::FETCH_ASSOC);
        $newCategory = new Category($category["title"], $category["description"]);
        $newCategory->setId($category['id']);
        return $newCategory;
    }

    public function createCategory(Category $category) : Category {
        
        $query = $this->db->prepare("INSERT INTO categories VALUES (null, :title, :description)");
        $parameters = [
            "title" => $category->getTitle(),
            "description" => $category->getDescription(),
            ];
        $query->execute($parameters);

        $query = $this->db->prepare("SELECT * FROM categories WHERE title = :title");
        $parameters= [
            "title" => $category->getTitle(),
            ];
        $query->execute($parameters);
        $category = $query->fetch(PDO::FETCH_ASSOC);
        $newCategory = new Category($category["title"],$category["description"]);
        $newCategory->setId($category['id']);
        return $newCategory;
    }

    public function updateCategory(Category $category) : void {
        
        $query = $this->db->prepare("UPDATE categories SET title = :title, description = :description WHERE id = :id");
        $parameters= [
        "id" => $category->getId(),
        "title" => $category->getTitle(),
        "description" => $category->getDescription(),
        ];
        $query->execute($parameters);
    }

    public function deleteCategory(Category $category) : void {
        $query = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        $parameters = ["id" => $category->getId()];
        $query->execute($parameters);
        
    }
    
    public function deleteCategoryPicture(int $id) : void {
        $query= $this->db->prepare("DELETE FROM categories_pictures WHERE category_id = :category_id");
        $parameters = ["category_id" => $id ];
        $query->execute($parameters);
    }
}

?>
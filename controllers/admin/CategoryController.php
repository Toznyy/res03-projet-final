<?php

class CategoryController extends AbstractController {
    private CategoryManager $cm;

    public function __construct()
    {
        $this->cm = new CategoryManager();
    }

    public function getCategories() {
        
        $categories = $this -> cm->getAllCategories();
        $categoriesTab = [];
        foreach($categories as $category) {
            
            $categoryTab = $category->toArray();
            $categoriesTab[]=$categoryTab;
        }
        
        $this->render($categorysTab);
    }

    public function getCategory(string $get)
    {
        $id = intval($get);
        $category = $this -> cm->getCategoryById($id);
        $categoryTab = $category->toArray();
        
        $this->render($categoryTab);
    }

    public function createCategory(array $post)
    {
        $newCategory = new Category(null, $post['Categoryname'], $post['firstName'], $post['lastName'], $post['email']);
        $category = $this->cm->createCategory($newCategory);
        $createdCategory = $category->toArray();
        $this->render($createdCategory);
    }

    public function updateCategory(array $post)
    {
        $newCategory = new Category(null, $post['Categoryname'], $post['firstName'], $post['lastName'], $post['email']);
        $category = $this->cm->updateCategory($newCategory);
        $updatedCategory = $category->toArray();
        $this->render($updatedCategory);
    }

    public function deleteCategory(array $post)
    {
        $newCategory = new Category(null, $post['Categoryname'], $post['firstName'], $post['lastName'], $post['email']);
        $category = $this->cm->deleteCategory($newCategory);
        $deletedCategory = $category->toArray();
        return $this->getCategories;
    }
}

?>
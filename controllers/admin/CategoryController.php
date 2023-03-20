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
            $categoriesTab[] = $categoryTab;
        }
        
        $this->renderPrivate("admin-categories", ["categories" => $categoriesTab]);
    }

    public function getCategory(string $get)
    {
        $id = intval($get);
        $category = $this -> cm->getCategoryById($id);
        $categoryTab = $category->toArray();
        
        $this->renderPrivate("admin-category", [$categoryTab]);
    }

    public function createCategory(array $post)
    {
        $newCategory = new Category($post['title'], $post['description']);
        $category = $this->cm->createCategory($newCategory);
        $createdCategory = $category->toArray();
        
        $this->renderPrivate("admin-create-category", $createdCategory);
    }

    public function updateCategory(array $post)
    {
        $newCategory = new Category($category['title'], $category['description']);
        $category = $this->cm->updateCategory($newCategory);
        $updatedCategory = $category->toArray();
        $this->renderPrivate("admin-update-category", $updatedCategory);
    }

    public function deleteCategory(array $post)
    {
        $newCategory = new Category($category['title'], $category['description']);
        $category = $this->cm->deleteCategory($newCategory);
        $deletedCategory = $category->toArray();
        return $this->getCategories;
    }
}

?>
<?php

class CategoryController extends AbstractController {
    private CategoryManager $cm;
    private PictureManager $pm;

    public function __construct()
    {
        $this->cm = new CategoryManager();
        $this->pm = new PictureManager();
    }

    public function getCategories() {
        
        $categories = $this->cm->getAllCategoriesWithPictures();
        $this->renderPrivate("admin-categories", ["categories" => $categories]);
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
        $newPicture = new Picture($post['URL'], $post['caption'], "categories");
        
        $category = $this->cm->createCategory($newCategory);
        $picture = $this->pm->createPicture($newPicture);
        $category_picture = $this->cm->CategoriesJoinPictures($picture->getId(), $category->getId());
        $createdCategory = $category->toArray();
        $createdPicture = $picture->toArray();
        
        $finishedCategory = $createdCategory + $createdPicture;
        
        header('Location: /res03-projet-final/admin/categories');
    }

    public function updateCategory(array $post)
    {
        $id = $this->cm->getAllCategoriesWithPicturesById($post["id"]);
        $title = $this->cm->getCategoryByTitle($post["title"]);
        var_dump($id);
        die;
        $category = $this->cm->updateCategory($newCategory);
        $picture = $this->pm->updatePicture($newPicture);
        $category_picture = $this->cm->CategoriesJoinPictures($picture->getId(), $category->getId());
        $createdCategory = $category->toArray();
        $createdPicture = $picture->toArray();
        
        $finishedCategory = $createdCategory + $createdPicture;
        
        header('Location: /res03-projet-final/admin/categories');
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
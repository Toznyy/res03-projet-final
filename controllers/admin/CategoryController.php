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

    public function updateCategory(array $post, string $get)
    {
        $id = intval($get);
        $category = $this->cm->getCategoryById($id);
        $picture = $this->pm->getPictureById($id);
        
        $tab = [];
        
        $tab["category"] = $category;
        $tab["picture"] = $picture;
        
        
        if(isset($post["formName"]))
        {
            if(isset($post['title']) && isset($post['description']) && isset($post['URL']) && isset($post['caption']) && !empty($post['title']) && !empty($post['description']) && !empty($post['URL']) && !empty($post['caption'])) {
                
                $categoryToUpdate = $this->cm->getCategoryById($id);
                $pictureToUpdate = $this->pm->getPictureById($id);
                $categoryToUpdate->setTitle($post['title']);
                $categoryToUpdate->setDescription($post['description']);
                $pictureToUpdate->setURL($post['URL']);
                $pictureToUpdate->setCaption($post['caption']);
                $this->cm->updateCategory($categoryToUpdate);
                $this->pm->updatePicture($pictureToUpdate);
                header("Location: /res03-projet-final/admin/categories");
            }
            else {
                echo "ca marche paaaaaaas<br>";
            }
        }
        else
        {
            $this->renderPrivate("admin-categories-update", $tab);
        }
        
    }

    public function deleteCategory(string $get) : void
    {
        $id = intval($get);
        $categoryToDelete = $this->cm->getCategoryById($id);
        $pictureToDelete = $this->pm->getPictureById($id);
        
        $category_picture = $this ->cm->deleteCategoryPicture($id);
        $picture = $this->pm->deletePicture($pictureToDelete);
        $category = $this->cm->deleteCategory($categoryToDelete);

        header("Location: /res03-projet-final/admin/categories");
    }
}

?>
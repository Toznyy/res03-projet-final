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
    
    public function getPublicCategories() {
        
        $categories = $this->cm->getAllCategoriesWithPictures();
        $categories = array_values($categories);
        $this->render("liste-categories", ["categories" => $categories]);
    }

    public function getCategory(string $get)
    {
        $id = intval($get);
        $category = $this -> cm->getCategoryById($id);
        $categoryTab = $category->toArray();
        
        $this->renderPrivate("admin-category", [$categoryTab]);
    }
    
    public function displayProductsByCategory(string $title) {
        
        $products = $this->category($title);
    }
    
    public function createCategory(array $post)
    {
        $newCategory = new Category($post['title'], $post['description']);
        $newIcone = new Picture($post['URL-icone'], $post['caption-icone'], "icone");
        $newLogo = new Picture($post['URL-logo'], $post['caption-logo'], "logo");

        $category = $this->cm->createCategory($newCategory);
        $icone = $this->pm->createPicture($newIcone);
        $logo = $this->pm->createPicture($newLogo);
        $category_pictureIcone = $this->cm->CategoriesJoinPictures($icone->getId(), $category->getId());
        $category_pictureLogo = $this->cm->CategoriesJoinPictures($logo->getId(), $category->getId());
        $createdCategory = $category->toArray();
        $createdIcone = $icone->toArray();
        $createdLogo = $logo->toArray();
        
        $finishedCategory = $createdCategory + $createdIcone + $createdLogo;
        
        header('Location: /res03-projet-final/admin/categories');
    }

    public function updateCategory(array $post, string $get) {
    
    $id = intval($get);
    $category = $this->cm->getCategoryById($id);
    $pictures = $this->pm->getPicturesByCategoryId($id);

    $tab = [];
    
    $tab["category"] = $category;
    $tab["pictures"] = $pictures;
    
    if(isset($post["formName"]))
        {
            if(isset($post['title']) && isset($post['description']) && !empty($post['title']) && !empty($post['description'])) {
                
                $categoryToUpdate = $this->cm->getCategoryById($id);
                $categoryToUpdate->setTitle($post['title']);
                $categoryToUpdate->setDescription($post['description']);
                $this->cm->updateCategory($categoryToUpdate);
                
                foreach($pictures as $picture) { 
                    
                    if(isset($post['URL-'.$picture->getRole()]) && isset($post['caption-'.$picture->getRole()]) && !empty($post['URL-'.$picture->getRole()]) && !empty($post['caption-'.$picture->getRole()])) {
                        
                        $pictureToUpdate = $this->pm->getPictureById($picture->getId());
                        $pictureToUpdate->setURL($post['URL-'.$picture->getRole()]);
                        $pictureToUpdate->setCaption($post['caption-'.$picture->getRole()]);
                        $this->pm->updatePicture($pictureToUpdate);
                        header("Location: /res03-projet-final/admin/categories");
                    }
                    else {
                        echo "ca marche paaaaaaas<br>";
                    }
                }
            }
        }
    else {
        $this->renderPrivate("admin-categories-update", $tab);
    }
    }

    public function deleteCategory(string $get): void {
        
        $id = intval($get);
        $categoryToDelete = $this->cm->getCategoryById($id);
        $picturesToDelete = $this->pm->getPicturesByCategoryId($id);
        $category_picture = $this->cm->deleteCategoryPicture($id);
        $this->pm->deletePictures($picturesToDelete);
        $category = $this->cm->deleteCategory($categoryToDelete);
    
        header("Location: /res03-projet-final/admin/categories");
    }
}

?>
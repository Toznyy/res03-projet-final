<?php

class PictureManager extends AbstractManager {

    public function getAllPictures() : array {
        
        $query = $this->db->prepare("SELECT * FROM pictures");
        $query->execute();
        $pictures = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $picturesTab=[];
        foreach($pictures as $picture){
            $newPicture = new Picture($picture['URL'], $picture['caption'], $picture["role"]);
            $newPicture->setId($picture['id']);
            array_push($picturesTab, $newPicture);
        }
        return $picturesTab;
    }

    public function getPictureById(?int $id) : ?Picture {
        
        $query = $this->db->prepare("SELECT * FROM pictures WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $picture = $query->fetch(PDO::FETCH_ASSOC);
        if($picture) {
            $newPicture = new Picture($picture["URL"], $picture["caption"], $picture["role"]);
            $newPicture->setId($picture['id']);
            return $newPicture;
        }
        else {
            return null;
        }
    }
    
    public function getPicturesByCategory(Category $category) : array {
        
        $query = $this->db->prepare("SELECT pictures.id, pictures.URL, pictures.caption, pictures.role FROM pictures JOIN categories_pictures ON categories_pictures.picture_id = pictures.id WHERE categories_pictures.category_id = :id");
        $query->execute(["id" => $category->getId()]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
        $pictures = [];
        foreach ($result as $pictureData) {
            $picture = new Picture($pictureData['URL'], $pictureData['caption'], $pictureData['role']);
            $picture->setId($pictureData['id']);
            $pictures[] = $picture;
        }
    
        return $pictures;
    }
    
    public function getPicturesByProduct(Product $product) : array {
        
        $query = $this->db->prepare("SELECT pictures.id, pictures.URL, pictures.caption, pictures.role FROM pictures JOIN products_pictures ON products_pictures.picture_id = pictures.id WHERE products_pictures.product_id = :id");
        $query->execute(["id" => $product->getId()]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
        $pictures = [];
        foreach ($result as $pictureData) {
            $picture = new Picture($pictureData['URL'], $pictureData['caption'], $pictureData['role']);
            $picture->setId($pictureData['id']);
            $pictures[] = $picture;
        }
    
        return $pictures;
    }
    
    public function getPictureByURL(string $URL) : Picture {
        
        $query = $this->db->prepare("SELECT * FROM pictures WHERE URL = :URL");
        $parameters = [
            "URL" => $URL
            ];
        $query->execute($parameters);
        $picture = $query->fetch(PDO::FETCH_ASSOC);
        var_dump($picture);
        $newPicture = new Picture($picture["URL"], $picture["caption"]);
        $newPicture->setId($picture['id']);
        return $newPicture;
    }
    
    public function getPicturesByCategoryId(int $id) : ?array {
        
        $query = $this->db->prepare("SELECT pictures.id, pictures.URL, pictures.caption, pictures.role FROM pictures JOIN (categories_pictures JOIN categories ON categories_pictures.category_id = categories.id) ON pictures.id = categories_pictures.picture_id WHERE category_id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $pictureData = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $pictures = [];
        foreach ($pictureData as $data) {
            $picture = new Picture($data["URL"], $data["caption"], $data["role"]);
            $picture->setId($data["id"]);
            $pictures[] = $picture;
        }
        return $pictures;
    }
    
    public function getPicturesByProductId(int $id) : ?Picture {
            
        $query = $this->db->prepare("SELECT pictures.id, pictures.URL, pictures.caption, pictures.role FROM pictures JOIN (products_pictures JOIN products ON products_pictures.product_id = products.id) ON pictures.id = products_pictures.picture_id WHERE product_id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $pictureData = $query->fetch(PDO::FETCH_ASSOC);
    
        $picture = new Picture($pictureData["URL"], $pictureData["caption"], $pictureData["role"]);
        $picture->setId($pictureData["id"]);
        
        return $picture;
    }

    public function createPicture(Picture $picture) : Picture {
        
        $query = $this->db->prepare("INSERT INTO pictures VALUES (null, :URL, :caption, :role)");
        $parameters = [
            "URL" => $picture->getURL(),
            "caption" => $picture->getCaption(),
            "role" => $picture->getRole(),
            ];
        $query->execute($parameters);

        $query = $this->db->prepare("SELECT * FROM pictures WHERE URL = :URL");
        $parameters= [
            "URL" => $picture->getURL(),
            ];
        $query->execute($parameters);
        $picture = $query->fetch(PDO::FETCH_ASSOC);
        $newPicture = new Picture($picture["URL"], $picture["caption"], $picture["role"]);
        $newPicture->setId($picture['id']);
        return $newPicture;
    }

    public function updatePicture(Picture $picture) : void {
        
        $query = $this->db->prepare("UPDATE pictures SET URL = :URL, caption = :caption WHERE id = :id");
        $parameters= [
        "id" => $picture->getId(),
        "URL"=>$picture->getURL(),
        "caption"=> $picture->getCaption(),
        ];
        $query->execute($parameters);
    }

    public function deletePictures(array $pictures): void {
        
        foreach ($pictures as $picture) {
            $query = $this->db->prepare("DELETE FROM pictures WHERE id = :id");
            $parameters = ["id" => $picture->getId()];
            $query->execute($parameters);
        }
    }
}

?>
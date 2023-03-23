<?php

class PictureManager extends AbstractManager {

    public function getAllPictures() : array {
        
        $query = $this->db->prepare("SELECT * FROM pictures");
        $query->execute();
        $pictures = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $picturesTab=[];
        foreach($pictures as $picture){
            $newPicture = new Picture($picture['URL'], $picture['caption']);
            $newPicture->setId($picture['id']);
            array_push($picturesTab, $newPicture);
        }
        return $picturesTab;
    }

    public function getPictureById(?int $id) : Picture {
        
        $query = $this->db->prepare("SELECT * FROM pictures WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $picture = $query->fetch(PDO::FETCH_ASSOC);
        $newPicture = new Picture($picture["URL"], $picture["caption"]);
        $newPicture->setId($picture['id']);
        return $newPicture;
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

    public function deletePicture(Picture $picture) : array {
        
        $query = $this->db->prepare("DELETE FROM pictures WHERE URL = :URL");
        $parameters = ["URL" => $picture->getURL()];
        $query->execute($parameters);
        return $this->getAllPictures();
    }
}

?>
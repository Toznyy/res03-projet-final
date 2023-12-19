<?php

class OrderController extends AbstractController {
    private OrderManager $om;
    private ProductManager $prm;

    public function __construct()
    {
        $this->om = new OrderManager();
        $this->prm = new ProductManager();
    }

    public function getOrders() {
        
        $orders = $this->om->getAllOrdersWithProducts();
        $this->renderPrivate("admin-orders", ["orders" => $orders]);
    }

    public function getOrder(string $get)
    {
        $id = intval($get);
        $order = $this -> om->getOrderById($id);
        $orderTab = $order->toArray();
        
        $this->renderPrivate("admin-order", [$orderTab]);
    }

    public function updateOrder(array $post)
    {
        $id = intval($get);
        $order = $this->om->getOrderById($id);
        $product = $this->prm->getProductById($id);
        
        $tab = [];
        
        $tab["category"] = $category;
        $tab["picture"] = $picture;
        
        
        if(isset($post["formName"]))
        {
            if(isset($post['title']) && isset($post['description']) && isset($post['URL']) && isset($post['caption']) && !empty($post['title']) && !empty($post['description']) && !empty($post['URL']) && !empty($post['caption'])) {
                
                $categoryToUpdate = $this->om->getCategoryById($id);
                $pictureToUpdate = $this->pm->getPictureById($id);
                $categoryToUpdate->setTitle($post['title']);
                $categoryToUpdate->setDescription($post['description']);
                $pictureToUpdate->setURL($post['URL']);
                $pictureToUpdate->setCaption($post['caption']);
                $this->om->updateCategory($categoryToUpdate);
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

    public function deleteOrder(array $post)
    {
        $newOrder = new Order($post['reference'], $post['date']);
        $order = $this->om->deleteOrder($newOrder);
        $deletedOrder = $order->toArray();
        return $this->getOrders;
    }
}

?>
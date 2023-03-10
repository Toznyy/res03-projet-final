<?php

class OrderManager extends AbstractManager {

    public function getAllOrders() : array {
        
        $query = $this->db->prepare("SELECT * FROM orders");
        $query->execute();
        $orders = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $ordersTab=[];
        foreach($orders as $order){
            $newOrder = new User($order['id'], $order['user_id'], $order['reference'], $order['date']);
            array_push($ordersTab, $newOrder);
        }
        return $ordersTab;
    }

    public function getOrderById(int $id) : Order {
        
        $query = $this->db->prepare("SELECT * FROM orders WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $order = $query->fetch(PDO::FETCH_ASSOC);
        $newOrder = new User($order["id"], $order["user_id"], $order["reference"], $order["date"]);
        return $newOrder;
    }

    public function createOrder(Order $order) : Order {
        
        $query = $this->db->prepare("INSERT INTO orders VALUES (null, null, :reference, :date)");
        $parameters = [
            "reference" => $user->getReference(),
            "date" => $user->getDate(),
            ];
        $query->execute($parameters);
        
        $query = $this->db->prepare("SELECT * FROM orders WHERE reference = :reference");
        $parameters= [
            "reference" => $user->getReference()
            ];
        $query->execute($parameters);
        $order = $query->fetch(PDO::FETCH_ASSOC);
        $newOrder = new Order($order["id"], $order["user_id"], $order["reference"], $order["date"]);
        return $newOrder;
    }

    public function updateOrder(Order $order) : Order {
        
        $query = $this->db->prepare("UPDATE orders SET reference = :reference, date = :date WHERE id = :id");
        $parameters= [
        "id" => $user->getId(),
        "reference"=>$user->getReference(),
        "date"=> $user->getDate(),
        ];
        $query->execute($parameters);
        $query = $this->db->prepare("SELECT * FROM orders WHERE reference = :reference");
        $parameters = ["reference" => $user->getReference()];
        $query->execute($parameters);
        $order = $query->fetch(PDO::FETCH_ASSOC);
        $newOrder = new Order($order["id"], $order["user_id"], $order["reference"], $order["date"]);
        return $newOrder;
    }

    public function deleteOrder(Order $order) : array {
        
        $query = $this->db->prepare("DELETE FROM orders WHERE id = :id");
        $parameters = ["id" => $user->getId()];
        $query->execute($parameters);
        return $this->getAllOrders();
    }
}

?>
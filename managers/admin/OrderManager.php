<?php

class OrderManager extends AbstractManager {

    public function getAllOrders() : array {
        
        $query = $this->db->prepare("SELECT * FROM orders");
        $query->execute();
        $orders = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $ordersTab=[];
        foreach($orders as $order){
            $newOrder = new Order($order['reference'], $order['date']);
            $newOrder->setId($order['id']);
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
        $newOrder = new Order($order["reference"], $order["date"]);
        $newOrder->setId($order['id']);
        return $newOrder;
    }

    public function createOrder(Order $order) : Order {
        
        $query = $this->db->prepare("INSERT INTO orders VALUES (null, :reference, :date, null)");
        $parameters = [
            "reference" => $order->getReference(),
            "date" => $order->getDate(),
            ];
        $query->execute($parameters);
        
        $query = $this->db->prepare("SELECT * FROM orders WHERE reference = :reference");
        $parameters= [
            "reference" => $order->getReference()
            ];
        $query->execute($parameters);
        $order = $query->fetch(PDO::FETCH_ASSOC);
        $newOrder = new Order($order["reference"], $order["date"]);
        $newOrder->setId($order['id']);
        return $newOrder;
    }

    public function updateOrder(Order $order) : Order {
        
        $query = $this->db->prepare("UPDATE orders SET reference = :reference, date = :date WHERE id = :id");
        $parameters= [
        "id" => $order->getId(),
        "reference"=>$order->getReference(),
        "date"=> $order->getDate(),
        ];
        $query->execute($parameters);
        $newOrder = $this->getOrderById($order->getId());
        return $newOrder;
    }

    public function deleteOrder(Order $order) : array {
        
        $query = $this->db->prepare("DELETE FROM orders WHERE id = :id");
        $parameters = ["id" => $order->getId()];
        $query->execute($parameters);
        return $this->getAllOrders();
    }
}

?>
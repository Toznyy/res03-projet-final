<?php

class OrderManager extends AbstractManager {

    public function getAllOrders() : array {
        
        $query = $this->db->prepare("SELECT * FROM orders");
        $query->execute();
        $orders = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $ordersTab=[];
        foreach($orders as $order){
            $newOrder = new Order($order['reference'], $order['date'], $order['price']);
            $newOrder->setId($order['id']);
            array_push($ordersTab, $newOrder);
        }
        return $ordersTab;
    }
    
    public function OrdersJoinProducts($product_id, $order_id) {
        
        $query = $this->db->prepare("INSERT INTO products_orders VALUES (:product_id, :order_id)");
        $parameters = [
            "product_id" => $product_id, 
            "order_id" => $order_id
            ];
        $query->execute($parameters);
    }
    
    public function getAllOrdersWithProducts() : array {
        
        $query = $this->db->prepare("SELECT * FROM orders JOIN (products_orders JOIN products ON products_orders.product_id = products.id) ON orders.id = products_orders.order_id");
        $query->execute();
        $orders = $query->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }
    
    public function getAllOrdersWithProductsById(int $id) : array {
        
        $query = $this->db->prepare("SELECT * FROM orders JOIN (products_orders JOIN products ON products_orders.picture_id = products.id) ON orders.id = products_orders.order_id WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $orders = $query->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }

    public function getOrderById(int $id) : Order {
        
        $query = $this->db->prepare("SELECT * FROM orders WHERE id = :id");
        $parameters = [
            "id" => $id
            ];
        $query->execute($parameters);
        $order = $query->fetch(PDO::FETCH_ASSOC);
        $newOrder = new Order($order["reference"], $order["date"], $order['price']);
        $newOrder->setId($order['id']);
        return $newOrder;
    }
    
    public function getOrderByReference(string $reference) : Order {
        
        $query = $this->db->prepare("SELECT * FROM orders WHERE reference = :reference");
        $parameters = [
            "reference" => $reference
            ];
        $query->execute($parameters);
        $order = $query->fetch(PDO::FETCH_ASSOC);
        $newOrder = new Order($order["reference"], $order["date"], $order["price"]);
        $newOrder->setId($order['id']);
        return $newOrder;
    }

    public function createOrder(Order $order) : Order {
        
        $query = $this->db->prepare("INSERT INTO orders VALUES (null, :reference, :date, :price, null)");
        $parameters = [
            "reference" => $order->getReference(),
            "date" => $order->getDate(),
            "price" => $order->getPrice(),
            ];
        $query->execute($parameters);
        
        $query = $this->db->prepare("SELECT * FROM orders WHERE reference = :reference");
        $parameters= [
            "reference" => $order->getReference()
            ];
        $query->execute($parameters);
        $order = $query->fetch(PDO::FETCH_ASSOC);
        $newOrder = new Order($order["reference"], $order["date"], $order["price"]);
        $newOrder->setId($order['id']);
        return $newOrder;
    }

    public function updateOrder(Order $order) : void {
        
        $query = $this->db->prepare("UPDATE orders SET reference = :reference, date = :date, price = :price WHERE id = :id");
        $parameters= [
        "id" => $order->getId(),
        "reference"=>$order->getReference(),
        "date"=> $order->getDate(),
        "price" => $price->getPrice()
        ];
        $query->execute($parameters);
    }

    public function deleteOrder(Order $order) : void {
        
        $query = $this->db->prepare("DELETE FROM orders WHERE id = :id");
        $parameters = ["id" => $order->getId()];
        $query->execute($parameters);
    }
    
    public function deleteOrderProduct(int $id) : void {
        $query= $this->db->prepare("DELETE FROM products_orders WHERE order_id = :order_id");
        $parameters = ["order_id" => $id ];
        $query->execute($parameters);
    }
}

?>
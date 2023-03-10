<?php

class OrderController extends AbstractController {
    private OrderManager $om;

    public function __construct()
    {
        $this->om = new OrderManager();
    }

    public function getOrders() {
        
        $orders = $this -> om->getAllOrders();
        $ordersTab = [];
        foreach($orders as $order) {
            
            $orderTab = $order->toArray();
            $ordersTab[]=$orderTab;
        }
        
        $this->render($ordersTab);
    }

    public function getOrder(string $get)
    {
        $id = intval($get);
        $order = $this -> om->getOrderById($id);
        $orderTab = $order->toArray();
        
        $this->render($orderTab);
    }

    public function createOrder(array $post)
    {
        $newOrder = new Order(null, $post['Ordername'], $post['firstName'], $post['lastName'], $post['email']);
        $order = $this->om->createOrder($newOrder);
        $createdOrder = $order->toArray();
        $this->render($createdOrder);
    }

    public function updateOrder(array $post)
    {
        $newOrder = new Order(null, $post['Ordername'], $post['firstName'], $post['lastName'], $post['email']);
        $order = $this->om->updateOrder($newOrder);
        $updatedOrder = $order->toArray();
        $this->render($updatedOrder);
    }

    public function deleteOrder(array $post)
    {
        $newOrder = new Order(null, $post['Ordername'], $post['firstName'], $post['lastName'], $post['email']);
        $order = $this->om->deleteOrder($newOrder);
        $deletedOrder = $order->toArray();
        return $this->getOrders;
    }
}

?>
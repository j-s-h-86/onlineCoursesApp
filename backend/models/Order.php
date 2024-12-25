<?php

class Order
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllOrders()
    {
        $stmt = $this->pdo->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createOrder($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO orders (fullName, email, courseId) VALUES (:fullName, :email, :courseId)');
        return $stmt->execute([
            'fullName' => $data['fullName'],
            'email' => $data['email'],
            'courseId' => $data['courseId']
        ]);
    }
}

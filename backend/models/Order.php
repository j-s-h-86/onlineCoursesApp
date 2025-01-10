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
        $stmt = $this->pdo->prepare('SELECT price FROM courses WHERE id = :courseId');
        $stmt->execute(['courseId' => $data['courseId']]);
        $course = $stmt->fetch();

        if ($course) {
            $price = $course['price'];

            $stmt = $this->pdo->prepare('INSERT INTO orders (fullName, email, courseId, price) VALUES (:fullName, :email, :courseId, :price)');
            return $stmt->execute([
                'fullName' => $data['fullName'],
                'email' => $data['email'],
                'courseId' => $data['courseId'],
                'price' => $price
            ]);
        }

        return false;
    }

    public function updateOrder($id, $data)
    {
        $query = "UPDATE orders SET fullName = :fullName, email = :email, courseId = :courseId, price = :price WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            'fullName' => $data['fullName'],
            'email' => $data['email'],
            'courseId' => $data['courseId'],
            'price' => $data['price']
        ]);
    }

    public function deleteOrder($id)
    {
        $query = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

}

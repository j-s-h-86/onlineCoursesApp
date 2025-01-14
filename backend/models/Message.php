<?php

class Message
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllMessages()
    {
        $stmt = $this->pdo->query("SELECT * FROM messages");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessageById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM messages WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createMessage($data)
    {
        $query = "INSERT INTO messages (fullName, email, recipient, subject, message) VALUES (:fullName, :email, :recipient, :subject, :message)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':fullName' => $data['fullName'],
            ':email' => $data['email'],
            ':recipient' => $data['recipient'],
            ':subject' => $data['subject'],
            ':message' => $data['message']
        ]);
    }

    public function deleteMessage($id)
    {
        $query = "DELETE FROM messages WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

}
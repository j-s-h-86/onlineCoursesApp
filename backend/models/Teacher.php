<?php

class Teacher
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllTeachers()
    {
        $stmt = $this->pdo->query("SELECT * FROM teachers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTeacherById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM teachers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTeacher($data)
    {
        $query = "INSERT INTO teachers (teacherName, teacherDescription, teacherEmail) VALUES (:teacherName, :teacherDescription, :teacherEmail)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':teacherName' => $data['teacherName'],
            ':teacherDescription' => $data['teacherDescription'],
            'teacherEmail' => $data['teacherEmail']
        ]);
    }

}


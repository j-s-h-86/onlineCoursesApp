<?php

class Course
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllCourses()
    {
        $stmt = $this->pdo->query("SELECT * FROM courses");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCourse($data)
    {
        $query = "INSERT INTO courses (courseName, courseDescription, teacherId, occasions, price) VALUES (:courseName, :courseDescription, :teacherId, :occasions, :price)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':courseName' => $data['courseName'],
            ':courseDescription' => $data['courseDescription'],
            'teacherId' => $data['teacherId'],
            'occasions' => $data['occasions'],
            'price' => $data['price']
        ]);
    }

    public function updateCourse($id, $data)
    {
        $query = "UPDATE courses SET courseName = :courseName, courseDescription = :courseDescription, teacherId = :teacherId, occasions = :occasions, price = :price WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':courseName' => $data['courseName'],
            ':courseDescription' => $data['courseDescription'],
            'teacherId' => $data['teacherId'],
            'occasions' => $data['occasions'],
            'price' => $data['price']
        ]);
    }

    public function deleteCourse($id)
    {
        $query = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

}


<?php
class Course
{
    private $conn;
    private $table_name = "courses";

    public $id;
    public $courseName;
    public $courseDescription;
    public $teacherId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readAll()
    {
        $sql = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
}

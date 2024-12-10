<?php

require 'vendor/autoload.php';

class DBContext
{
    private $pdo;

    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $dsn = "mysql:host=$host;dbname=$db";

        try {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("set names utf8mb4");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
            die();
        }

        $this->initIfNotInitialized();
        $this->seedIfNotSeeded();
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    private function initIfNotInitialized()
    {
        static $initialized = false;
        if ($initialized)
            return;

        // Create teachers table first
        $sql = "CREATE TABLE IF NOT EXISTS `teachers` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `teacherName` VARCHAR(200) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->pdo->exec($sql);

        // Create courses table
        $sql = "CREATE TABLE IF NOT EXISTS `courses` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `courseName` VARCHAR(255) NOT NULL,
            `courseDescription` VARCHAR(255) NOT NULL,
            `teacherId` INT NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`teacherId`) REFERENCES `teachers`(`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->pdo->exec($sql);

        $initialized = true;
    }

    private function seedIfNotSeeded()
    {
        $sql = "SELECT COUNT(*) FROM teachers";
        $stmt = $this->pdo->query($sql);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $sql = "INSERT INTO teachers (teacherName) VALUES
                    ('Johan Hammarstedt'),
                    ('Drottning Isabitch')";
            $this->pdo->exec($sql);
        }

        $sql = "SELECT COUNT(*) FROM courses";
        $stmt = $this->pdo->query($sql);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $sql = "INSERT INTO courses (courseName, courseDescription, teacherId) VALUES
                      ('Dålig stämning', 'Grundkurs i att skapa dålig stämning var du än befinner dig.', 1),
                      ('Mer dålig stämning', 'Påbyggnadskurs.', 1),
                      ('Att vara en översittare', 'Tips och trix för att verka bättre än andra.', 2)";
            $this->pdo->exec($sql);
        }
    }
}
?>
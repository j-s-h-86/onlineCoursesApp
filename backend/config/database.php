<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/userDatabase.php';


class DBContext
{
    private $pdo;
    private $userDatabase;

    function getUserDatabase()
    {
        return $this->userDatabase;
    }

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
            $this->userDatabase = new UserDatabase($this->pdo);
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

        $sql = "CREATE TABLE IF NOT EXISTS `teachers` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `teacherName` VARCHAR(200) NOT NULL,
            `teacherDescription` VARCHAR(1000) NOT NULL,
            `teacherEmail` VARCHAR(200) NOT NULL,
            `teacherImg` VARCHAR(200) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `courses` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `courseName` VARCHAR(255) NOT NULL,
            `courseDescription` VARCHAR(255) NOT NULL,
            `teacherId` INT NOT NULL,
            `occasions` INT NOT NULL,
            `price` DECIMAL (10, 2) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`teacherId`) REFERENCES `teachers`(`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `orders` (
        `id` INT AUTO_INCREMENT NOT NULL,
        `fullName` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `courseId` INT NOT NULL,
        `price` DECIMAL(10, 2) NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`courseId`) REFERENCES `courses`(`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->pdo->exec($sql);

        $this->userDatabase->setupUsers();
        $this->userDatabase->seedUsers();


        $initialized = true;
    }

    private function seedIfNotSeeded()
    {
        $sql = "SELECT COUNT(*) FROM teachers";
        $stmt = $this->pdo->query($sql);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $sql = "INSERT INTO teachers (teacherName, teacherDescription, teacherEmail, teacherImg) VALUES
                    ('Johan Hammarstedt', 'Jag är ingen alfahanne, Honey. Så du kan sitta längst fram i taxin.', 'johan@onlinecourses.com', 'http://localhost:8000/backend/assets/johan.jpg'),
                    ('Anders Glenmark', 'Var oslagbar och hade svaren på allt.', 'glennis@onlinecourses.com', 'http://localhost:8000/backend/assets/glennis.jpg'),
                    ('Orup', 'Blir hellre jagad av vargar.', 'orup@onlinecourses.com', 'http://localhost:8000/backend/assets/orup.jpg')";
            $this->pdo->exec($sql);
        }

        $sql = "SELECT COUNT(*) FROM courses";
        $stmt = $this->pdo->query($sql);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $sql = "INSERT INTO courses (courseName, courseDescription, teacherId, occasions, price) VALUES
                      ('Dålig stämning', 'Skapa dålig stämning, var du än befinner dig.', 1, 9, 2100.00),
                      ('Gräv guld i USA', 'Många försökte och försvann. Bevisa att du kan.', 2, 6, 1800.00),
                      ('Rör inte min Mercedes', 'Bilvård.', 3, 8, 1999.00)";
            $this->pdo->exec($sql);
        }

        $sql = "SELECT COUNT(*) FROM orders";
        $stmt = $this->pdo->query($sql);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $sql = "INSERT INTO orders (fullName, email, courseId, price) VALUES
                    ('Jovan Rajs', 'jovan.rajs@rattsmedicin.se', 1, 2100.00),
                    ('Göran Greider', 'goran@skvallerpress.se', 3, 1500.00)";
            $this->pdo->exec($sql);
        }
    }
}
?>
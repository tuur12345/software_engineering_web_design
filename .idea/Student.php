<?php
require_once "Db.php";

class Student
{
    private ?int $id = null;
    private string $email;

    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function getEmail() {
        return $this->email;
    }
    public function __construct($email) {
        $this->email = $email;
    }
    public static function getIdFromEmail($email): ?int {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id FROM student WHERE email = :email');
        $stm->execute([
            ':email' => $email
        ]);
        $student = new Student($email);
        if ($item = $stm->fetch()) {
            $student->setId($item['id']);
        } else {
            $student->setId($student->createStudent());
        }
        return $student->getId();
    }
    public function createStudent(): ?int {
        $db = Db::getConnection();
        $stm = $db->prepare('INSERT INTO student (email) VALUES (:email);');
        $stm->execute([
            ':email' => $this->email
        ]);
        return $db->lastInsertId();
    }
    public static function getStudentFromEmail($email): ?Student {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT id FROM student WHERE email = :email');
        $stm->execute([
            ':email' => $email
        ]);
        $student = new Student($email);
        if ($item = $stm->fetch()) {
            $student->setId($item['id']);
        } else {
            return null;
        }
        return $student;
    }
}
<?php
session_start();
require_once "Db.php";
require_once "Student.php";
require_once "Book.php";
class Shop {
    public function __construct() {
        if (!isset($_SESSION['step']) || $_SESSION['step'] > 3) {
            $_SESSION['step'] = 1;
        }
        if (!isset($_SESSION['reservation_data'])) {
            $_SESSION['reservation_data'] = [];
        }
    }
    public function getStep() {
        return $_SESSION['step'];
    }
    public function processStep($data) {
        $_SESSION['reservation_data'] = array_merge($_SESSION['reservation_data'], $data);
        $_SESSION['step']++;
        if ($_SESSION['step'] > 3) {
            $this->storeOrder($_SESSION['reservation_data']);
        }
    }
    private function storeOrder($data): Shop {
        $db = Db::getConnection();
        $stm = $db->prepare('INSERT INTO reservation (student, created) VALUES (:student, :created);');
        $stm->execute([
            ':student' => Student::getIdFromEmail($data['email']),
            ':created' => date("Y-m-d H:i:s")
        ]);
        $id = $db->lastInsertId();
        echo $id;
        foreach ($data['book_ids'] as $book_id) {
            $stm = $db->prepare('INSERT INTO reservation_book (reservation, book) VALUES (:reservation, :book);');
            $stm->execute([
                ':reservation' => $id,
                ':book' => $book_id
            ]);
        }
        session_unset();
        session_destroy();
        header("Location: confirmation.php");
        exit;
        return $this;
    }

}
?>

<?php
require_once "Db.php";

class Book {
    private ?int $id = null;
    private string $title;
    private int $isbn;
    private int $obliged;
    private string $course;

    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getIsbn() {
        return $this->isbn;
    }
    public function isObliged() {
        return $this->obliged;
    }
    public function __construct($title, $isbn, $obliged, $course) {
        $this->title = $title;
        $this->isbn = $isbn;
        $this->obliged = $obliged;
        $this->course = $course;
    }
    public static function getBookIdsFromCourseId($course_id): array {
        $db = Db::getConnection();
        $stmt =  $db->prepare('SELECT * FROM book WHERE course = :course_id');
        $stmt->execute([':course_id' => $course_id]);
        $result = array();
        while  ($item = $stmt->fetch()) {
            $book = new Book($item['title'], $item['isbn'], $item['obliged'], $item['course']);
            $book->setId($item['id']);
            $result[] = $book->getId();
        }
        return  $result;
    }
    public static function getBooksFromCourseId($course_id): array {
        $db = Db::getConnection();
        $stmt =  $db->prepare('SELECT * FROM book WHERE course = :course_id');
        $stmt->execute([':course_id' => $course_id]);
        $result = array();
        while  ($item = $stmt->fetch()) {
            $book = new Book($item['title'], $item['isbn'], $item['obliged'], $item['course']);
            $book->setId($item['id']);
            $result[] = $book;
        }
        return  $result;
    }
    public static function getBookIdsFromFase($fase): array {
        $courses = Courses_db::getCoursesFromFase($fase);
        $book_ids = [];
        foreach ($courses as $course) {
            $book_ids = array_merge($book_ids, Book::getBookIdsFromCourseId($course->getCourseId()));
        }
        return $book_ids;
    }
    public static function getTitleFromId($id): String {
        $db = Db::getConnection();
        $stmt =  $db->prepare('SELECT title FROM book WHERE id = :id');
        $stmt->execute([':id' => $id]);
        if ($item = $stmt->fetch()) {
            $result = $item['title'];
        } else {
            $result = null;
        }
        return  $result;
    }
}
?>
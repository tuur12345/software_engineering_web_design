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
    public static function getBooksFromFase($fase): array {
        $courses = Courses_db::getCoursesFromFase($fase);
        $booklist = [];
        foreach ($courses as $course) {
            $booklist = array_merge($booklist, Book::getBooksFromCourseId($course->getCourseId()));
        }
        return $booklist;
    }
    public static function getIdFromTitle($title): ?int {
        $db = Db::getConnection();
        $stmt =  $db->prepare('SELECT id FROM book WHERE title = :title');
        $stmt->execute([':title' => $title]);
        if ($item = $stmt->fetch()) {
            $result = $item['id'];
        } else {
            $result = null;
        }
        return  $result;
    }
}
?>
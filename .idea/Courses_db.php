<?php
require_once "Db.php";

class Courses_db {
    private string $course_id = "";
    private int $fase;
    private string $name;
    private int $staff;

    public function getCourseId() {
        return $this->course_id;
    }
    public function getFase() {
        return $this->fase;
    }
    public function getName() {
        return $this->name;
    }
    public function getStaff() {
        return $this->staff;
    }
    public function __construct($course_id, $fase, $name, $staff) {
        $this->course_id = $course_id;
        $this->fase = $fase;
        $this->name = $name;
        $this->staff = $staff;
    }
    public static function getCourses(): array {
        $db = Db::getConnection();
        $stmt =  $db->prepare("SELECT * FROM course ORDER BY fase, name");
        $stmt->execute();
        $result = array();
        while  ($item = $stmt->fetch()) {
            $course = new Courses_db($item['id'], $item['fase'], $item['name'], $item['staff']);
            $result[] = $course;
        }
        return  $result;
    }
    public static function getCoursesFromFase($fase): array {
        $db = Db::getConnection();
        $stmt =  $db->prepare("SELECT * FROM course WHERE fase = :fase ORDER BY name");
        $stmt->execute([':fase' => $fase]);
        $result = array();
        while  ($item = $stmt->fetch()) {
            $course = new Courses_db($item['id'], $item['fase'], $item['name'], $item['staff']);
            $result[] = $course;
        }
        return  $result;
    }
}
?>
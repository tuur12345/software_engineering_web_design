<?php
require_once "Db.php";
class Staff
{
    private ?int $id =  null;
    private string $name;
    private string $email;

    public function setId($id) {
        $this->id = $id;
    }
    public function getName() {
        return $this->name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }
    public static function getStaffFromCourse($staff): object {
        $db = Db::getConnection();
        $stmt =  $db->prepare('SELECT * FROM staff WHERE id = :staff');
        $stmt->execute([':staff' => $staff]);
        $result = null;
        $item = $stmt->fetch();
        $staff = new Staff($item['name'], $item['email']);
        $staff->setId($item['id']);
        return $staff;
    }
}
?>
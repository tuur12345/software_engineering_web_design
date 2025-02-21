<?php
require_once 'Db.php';

class Feedback_db
{
    private ?int $id = null;
    private string $text;
    private string $author;
    private string $created;

    public function getId(): ?int {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getText(): String {
        return $this->text;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getAuthor(): String {
        return $this->author;
    }
    public function setAuthor($author)
    {
        $this->author = $author;
    }
    public function getCreated(): String {
        return $this->created;
    }
    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function __construct($text, $author, $created)
    {
        $this->text = $text;
        $this->author = $author;
        $this->created = $created;
    }

    public static function getAllFeedback() : array {
        $db = Db::getConnection();
        $stm = $db->prepare('SELECT * FROM feedback');
        $stm->execute();
        $result = array();
        while ($item = $stm->fetch()) {
            $feedback = new Feedback_db($item['text'],  $item['author'], $item['created']);
            $feedback->setId($item['id']);
            $result[] = $feedback;
        };
    return $result;
    }

    public function save() : Feedback_db {
        $db = Db::getConnection();
        $stm = $db->prepare('INSERT INTO feedback (text, author, created) VALUES (:text, :author, :created);');
        $stm->execute([
            ':text' => $this->text,
            ':author' => $this->author,
            ':created' => $this->created
        ]);
        $this->id = $db->lastInsertId();
    return $this;
    }
}
?>
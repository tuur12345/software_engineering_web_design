<?php
require_once "Feedback_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author = htmlspecialchars($_POST['author']);
    $text = htmlspecialchars($_POST['feedback']);
    $feedback = new Feedback_db($text, $author, date("Y-m-d  H:i:s"));
    if (!empty($author) && !empty($text)) {
        $feedback->save();
        header("Location: feedback.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>
    <header>
    <div class="head-block-container">
        <h1>CouBooks</h1>
        <h2 class="second-title">A Webtech demo site</h2>
    </div>
        <a class="url" href="coubook.php">Home</a>
        <a class="url" href="courses.php">Courses</a>
        <a class="url" href="reservation.php">Reservation</a>
        <a class="url" href="about.php">About</a>
    </header>
    <main>
        <h3>Add Feedback...</h3>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>
            <p>Feedback:</p>
            <textarea name="feedback" rows="5" style="width: 100%;" required></textarea>
            <input type="submit" value="Submit">
        </form>
    </main>
    <footer>
    <p>Copyright &copy; 2022 WebTech. KUL All Rights Reserved.
        <span>
                <a href="privacy.php">Privacy Policy</a>
                |
                <a href="terms.php">Terms of Use</a>
            </span>
    </p>
</footer>
</body>
</html>
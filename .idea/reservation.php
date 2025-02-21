<?php
require_once "Shop.php";
require_once "Book.php";
require_once "Courses_db.php";
$shop = new Shop();

$booklist = [];
$selected_books = $_SESSION['selected_books'] ?? [];
$email = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $step = $shop->getStep();

    $data = [];

    if ($step == 1) {
        $data = ['fase' => htmlspecialchars($_POST['fase']), 'email' => htmlspecialchars($_POST['email'])];
        $fase = htmlspecialchars($_POST['fase']);
        $email = htmlspecialchars($_POST['email']);
        if ($fase == "First Bachelor") {
            $booklist = Book::getBooksFromFase(1);
        } else if ($fase == "Second Bachelor") {
            $booklist = Book::getBooksFromFase(2);
        } else if ($fase == "Third Bachelor") {
            $booklist = Book::getBooksFromFase(3);
        } else if ($fase == "Master") {
            $booklist = Book::getBooksFromFase(4);
        }
    } elseif ($step == 2) {
        $data = ['books' => $_POST['books']];
        $selected_books = $_POST["books"];
        $_SESSION['selected_books'] = $selected_books;
    }
    $shop->processStep($data);
}
$step = $shop->getStep();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation</title>
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
    <?php if ($step == 1): ?>
        <section>
            <h3>STEP 1: WHO ARE YOU</h3>
            <p>Please provide some info about you, so we can search for the books you need...</p>
            <form method="post">
                <label for="phase">Phase:</label>
                <select id="phase" name="fase">
                    <option>First Bachelor</option>
                    <option>Second Bachelor</option>
                    <option>Third Bachelor</option>
                    <option>Master</option>
                </select><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?php echo $email; ?>"><br><br>
                <input type="submit" value="Next...">
            </form>
        </section>
    <?php elseif ($step == 2): ?>
        <section>
            <h3>STEP 2: WHAT BOOKS DO YOU NEED?</h3>
            <p>Select the books you wish to order ...</p>
            <form method="post">
                <ul>
                    <?php foreach ($booklist as $book): ?>
                        <li>
                            <input type="checkbox" name="books[]" value="<?php echo $book->getTitle(); ?>">
                            <label><?php echo $book->getTitle(); ?></label><br><br>
                        </li>
                    <?php  endforeach; ?>
                </ul>
                <input type="submit" value="Next...">
            </form>
        </section>
    <?php elseif ($step == 3): ?>
        <section>
            <h3>YOU HAVE ORDERED...</h3>
            <p>Below you find an overview of the books you have reserved. Once you confirm your reservation you can
                pick them up at our KD and pay at the desk</p>
            <form method="post">
                <ul>
                    <?php if (!empty($selected_books)): ?>
                        <?php foreach ($selected_books as $book): ?>
                            <li>
                                <label><?php echo htmlspecialchars($book); ?></label><br><br>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No books selected yet.</p>
                    <?php endif; ?>
                </ul>
                <input type="submit" name="confirm" value="Confirm Reservation">
            </form>
        </section>
    <?php endif; ?>
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
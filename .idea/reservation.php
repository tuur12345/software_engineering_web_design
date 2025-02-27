<?php
require_once "Shop.php";
require_once "Book.php";
require_once "Courses_db.php";
$shop = new Shop();

$book_ids = $_SESSION['book_ids'] ?? [];
$selected_book_ids = $_SESSION['selected_book_ids'] ?? [];
$email = "";
$step = $shop->getStep();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($step == 1 && isset($_POST['email'], $_POST['fase'])) {
        $fase = htmlspecialchars($_POST['fase']);
        $email = htmlspecialchars($_POST['email']);
        $data = ['fase' => $fase, 'email' => $email];

        $faseMap = [
            "First Bachelor" => 1,
            "Second Bachelor" => 2,
            "Third Bachelor" => 3,
            "Master" => 4
        ];
        $book_ids = Book::getBookIdsFromFase($faseMap[$fase]);
        $_SESSION['book_ids'] = $book_ids;

        $shop->processStep($data);
    }

    if ($step == 2 && !empty($_POST['selected_book_ids'])) {
        $selected_book_ids =  $_POST['selected_book_ids'];
        $_SESSION['selected_book_ids'] = $_POST["selected_book_ids"];
        $_SESSION['step'] = $step = 3;
    }

    if ($step == 3 && isset($_POST['confirm'])) {
        $shop->processStep(['book_ids' => $_SESSION['selected_book_ids']]);
    }
}
$step = $shop->getStep();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="stylesheet" href="reservation.css">
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
                    <?php foreach ($book_ids as $book_id): ?>
                        <li>
                            <input type="checkbox" name="selected_book_ids[]" value="<?php echo $book_id; ?>" id="<?php echo $book_id; ?>">
                            <label for="<?php echo $book_id; ?>"><?php echo Book::getTitleFromId($book_id); ?></label><br><br>
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
                    <?php if (!empty($selected_book_ids)): ?>
                        <?php foreach ($selected_book_ids as $selected_book_id): ?>
                            <li>
                                <label><?php echo Book::getTitleFromId($selected_book_id); ?></label><br><br>
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
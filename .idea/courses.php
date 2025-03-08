<?php
require_once "Courses_db.php";
require_once "Book.php";
require_once "Staff.php";

$fase = $_POST["fase"] ?? "0";
$courses_list = ($fase === "0") ? Courses_db::getCourses() : Courses_db::getCoursesFromFase($fase);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courses</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="stylesheet" href="courses.css">
    <script src="BookDetailsListener.js"></script>
    <script src="CourseDetailsListener.js"></script>
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
    <div>
        <p>Below you can find an overview of all available courses.</p>
        <form method="post" id="faseForm">
            <select name="fase" onchange="document.getElementById('faseForm').submit()">
                <option value="0" <?php echo $fase == "0" ? "selected" : ""; ?>>All</option>
                <option value="1" <?php echo $fase == "1" ? "selected" : ""; ?>>First bachelor</option>
                <option value="2" <?php echo $fase == "2" ? "selected" : ""; ?>>Second bachelor</option>
                <option value="3" <?php echo $fase == "3" ? "selected" : ""; ?>>Third bachelor</option>
                <option value="4" <?php echo $fase == "4" ? "selected" : ""; ?>>Master</option>
            </select>
        </form>

        <ul>
            <?php if (empty($courses_list)): ?>
                <li class="no-course"><i>No courses available</i></li>
            <?php else: ?>
                <?php foreach ($courses_list as $course): ?>
                    <li class="course">
                        <div class="course-header">
                            <h3><?php echo $course->getCourseId(); ?>: <?php echo $course->getName(); ?></h3>
                        </div>
                        <div class="course-details">
                            <p><strong>Fase:</strong> <?php echo $course->getFase(); ?></p>
                            <p><strong>Instructor:</strong>
                                <?php $staff = Staff::getStaffFromCourse($course->getStaff()); ?>
                                <span class="staff-name"><?php echo $staff->getName(); ?></span>
                                <a href="mailto: <?php echo $staff->getEmail(); ?>" class="staff-email">
                                    (<?php echo $staff->getEmail(); ?>)
                                </a>
                            </p>
                            <h4>Books:</h4>
                            <ul class="books-list">
                                <?php $book_list = Book::getBooksFromCourseId($course->getCourseId());
                                if (empty($book_list)): ?>
                                    <li><i>No books available</i></li>
                                <?php else:
                                    foreach ($book_list as $book): ?>
                                        <li class="book" data-isbn="<?php echo $book->getIsbn(); ?>">
                                            <b><?php echo $book->getTitle(); ?></b>
                                            (ISBN: <?php echo $book->getIsbn(); ?>) -
                                            <i><?php echo $book->isObliged() ? "Obliged" : "Not Obliged"; ?></i>
                                            <div class="book-details"></div>
                                        </li>
                                    <?php endforeach;
                                endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
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

<?php
require_once "Courses_db.php";
require_once "Book.php";
require_once "Staff.php";
$courses_list = Courses_db::getCourses();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courses</title>
    <link rel="stylesheet" href="mystyle.css">
    <link rel="stylesheet" href="courses.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".book").forEach(book => {
                book.addEventListener("click", function (event) {
                    const isbn = event.currentTarget.dataset.isbn;
                    const detailsContainer = event.currentTarget.querySelector(".book-details");
                    fetch(`https://openlibrary.org/isbn/${isbn}.json`)
                        .then((response) => {if (response.ok) return response.json()})
                        .then((json) => {
                            if (json && json.title) {
                                detailsContainer.innerHTML =
                                    `<p><strong>Title:</strong> ${json.title}</p>
                                    <p><strong>Published:</strong> ${json.publish_date}</p>
                                    <p><strong>Pages:</strong> ${json.number_of_pages ? json.number_of_pages : "Not available"}</p>`
                                detailsContainer.classList.toggle('open');
                            } else {
                                detailsContainer.innerHTML = "<p>No additional information available.</p>";
                                detailsContainer.classList.toggle('error');
                            }
                        });
                });
            });
        });
    </script>
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
<main> <!-- layout mostly by chatgpt -->
    <div>
        <p>Below you can find an overview of all available courses.</p>
        <ul style="padding: 0;">
            <?php foreach ($courses_list as $course): ?>
                <li style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
                    <h3 style="margin: 0;"><?php echo $course->getCourseId(); ?>: <?php echo $course->getName(); ?></h3>
                    <p style="margin: 5px 0;">
                        <strong>Fase:</strong> <?php echo $course->getFase(); ?> |
                        <strong>Instructor:</strong>
                        <?php
                        $staff = Staff::getStaffFromCourse($course->getStaff()); ?>
                        <span style='font-weight: bold;'><?php echo $staff->getName(); ?></span>
                        <a href="mailto: <?php echo $staff->getEmail(); ?>" style='color: #0073e6; text-decoration: none;'>
                            (<?php echo $staff->getEmail(); ?>)
                        </a>
                    </p>

                    <h4 style="margin: 10px 0 5px;">Books:</h4>
                    <ul style="margin: 0; padding-left: 20px;">
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
                </li>
            <?php endforeach; ?>
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
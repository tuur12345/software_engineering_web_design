<?php
require_once 'Greeter.php';
require_once "Feedback_db.php";

$feedback_list = Feedback_db::getAllFeedback();
$greeter = new Greeter();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CouBooks</title>
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
        <div class="flex-container">
            <div class="main-block-container">
                <h2><?php echo $greeter->getGreeting(); ?></h2>
                <h3>Are you ready to study ?</h3>
                <p>When in need for the correct course books or printed slides, you should have a look to our course book website for EA. Here you can find an overview of all course material that is needed for every course within the EA program. Select your fase and see what is needed....</p>
                <p>This <b>Course Book Service</b> site is specially designed as a demonstration for the web technology course. In the end, this page can be found on the development web server <a href="https://www.studev.groept.be">studev.groept.be</a> Within this demonstration we will step-by-step create this site.</p>
            </div>
            <div class="side-block-container">
                <h2>Opening Hours:</h2>
                <p>Mon: 9am-11am<br><br>Tue: 1pm-4pm<br><br>Fri: 1pm-4pm</p>
                <h2>Feedback</h2>
                <ul><?php foreach ($feedback_list as $feedback): ?>
                        <li class="comment" style="list-style-type: none">
                            <?php echo $feedback->getText();?><br>
                            <em><strong><?php echo $feedback->getAuthor();?></strong>
                                <?php echo $feedback->getCreated();?>
                            </em>
                        </li>
                    <?php endforeach; ?>
                </ul>
               <a href="feedback.php">Add feedback...</a>
            </div>
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
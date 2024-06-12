<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/events.css"/>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css"/>
    <script src="https://kit.fontawesome.com/1dc78f8de1.js" crossorigin="anonymous"></script>

    <title>UniLink | <?= $event->getTitle(); ?></title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
</head>

<body>

    <div class="base-container">

        <div class="flex-row-left-center header">
            <img class="logo" src="public/img/logo.svg">
            <a href="logout"><button type="submit" class="logout"></button></a>
        </div>

        <div class="lower-container">

            <div class="flex-left-center nav-bar">

                <img class="profile-photo" src="public/img/profile-photo.svg">
                <h3 class="default-font bold"><?=$_SESSION['firstname'].' '.$_SESSION['lastname']; ?></h3>
                <p class="default-font"><?=$_SESSION['university']; ?></p>

                <form class="flex-center">

                    <?php

                    if ($_SESSION['role'] !== 3) {
                        echo '<button type="submit" class="filled-button default-font" formaction="add_event">ADD EVENT</button>';
                        echo '<button type="submit" class="filled-button default-font" formaction="events">YOUR EVENTS</button>';
                    }
                    ?>

                    <button type="submit" class="filled-button default-font" formaction="events">HOMEPAGE</button>
                </form>
            </div>
            
            <div class="events-container">
                <div class="flex-center">

                    <img src="public/uploads/<?= $event->getImage(); ?>">

                    <div class="flex-center">
                        <h3 class="default-font bold" style="color: black;"><?= $event->getTitle(); ?></h3>

                        <div class="info-section">
                            <i class="fa-solid fa-calendar-days" style="color: black;"><?= $event->getDate()." ".$event->getHour(); ?></i>
                            <i class="fa-solid fa-user" style="color: black;">0/<?= $event->getSlots(); ?></i>
                        </div>
                        <br>
                        <p class="default-font bold" style="color: black;"><?= $event->getAddress().", ".$event->getZip()." ".$event->getCity(); ?></p>
                        <br>
                        <p class="default-font" style="color: black;"><?= $event->getDescription(); ?></p>
                        <br><br>
                    </div>

                    <form>
                        <?php
                        if ($_SESSION['role'] !== 3) {
                            echo '<button type="submit" class="apply-button default-font">ATTEND</button>';
                        }

                        if ($_SESSION['role'] === 1) {
                            echo '<button type="submit" class="del-button default-font">REMOVE</button>';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
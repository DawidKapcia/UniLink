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
                            echo '<button type="submit" class="filled-button default-font add-event-icon" formaction="add_event">ADD EVENT</button>';
                            echo '<button type="submit" class="filled-button default-font your-events-icon" formaction="your_events">YOUR EVENTS</button>';
                        }
                    ?>

                    <button type="submit" class="filled-button default-font home-icon" formaction="events">HOMEPAGE</button>
                </form>
            </div>
            
            <div class="events-container">
                <div class="flex-center">
                    
                    <?
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo "<br><p class='warning-box default-font'>".$message."</p><br>";
                        }
                    }
                    ?>

                    <img src="public/uploads/<?= $event->getImage(); ?>">

                    <div class="flex-center">
                        <h3 class="default-font bold" style="color: black;"><?= $event->getTitle(); ?></h3>

                        <div class="info-section">
                            <i class="fa-solid fa-calendar-days" style="color: black;"><?= $event->getDate()." ".$event->getHour(); ?></i>
                            <i class="fa-solid fa-user" style="color: black;"><?= $event->getEnroled()."/".$event->getSlots(); ?></i>
                        </div>
                        <br>
                        <p class="default-font bold" style="color: black;"><?= $event->getAddress().", ".$event->getZip()." ".$event->getCity(); ?></p>
                        <br>
                        <p class="default-font" style="color: black;"><?= $event->getDescription(); ?></p>
                        <br><br>
                    </div>

                    <form method="post">
                        <?php
                        if ($_SESSION['role'] !== 3) {

                            if (is_null($is_enroled)) {
                                echo '<button type="submit" class="apply-button default-font" formaction="attend_event?id='.$event->getId().'">ATTEND</button>';
                            }
                            else {
                                echo '<button type="submit" class="del-button default-font" formaction="cancel_attendance?id='.$event->getId().'">CANCEL</button>';
                            }
                        }

                        if ($_SESSION['role'] === 1) {
                            echo '<button type="submit" class="del-button default-font" formaction="remove_event?id='.$event->getId().'">REMOVE</button>';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
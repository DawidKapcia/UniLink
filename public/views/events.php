<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/events.css"/>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css"/>
    <script src="https://kit.fontawesome.com/1dc78f8de1.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>

    <title>UniLink | Events board</title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
</head>

<body>

    <div class="base-container">

        <div class="flex-row-left-center header">
            <img class="logo" src="public/img/logo.svg">

            <input placeholder="Search an event...">
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

                <div class="events">
                    <?php foreach ($events as $event):?>
                    
                        <a href="event_details?id=<?=$event->getId();?>">
                            <div id="<?=$event->getId();?>">
                                <img src="public/uploads/<?= $event->getImage(); ?>">
                                <div>
                                    <h3 class="default-font bold" style="color: black;"><?= $event->getTitle(); ?></h3>
                                    <p class="default-font bold" style="color: black;"><?= $event->getAddress().", ".$event->getZip()." ".$event->getCity(); ?></p>
                                    <br>

                                    <div class="info-section">
                                        <i class="fa-solid fa-calendar-days" style="color: black;"><?= $event->getDate()." ".$event->getHour(); ?></i>
                                        <i class="fa-solid fa-user" style="color: black;"><?= $event->getEnroled()."/".$event->getSlots(); ?></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>

<template id="event-template">
    <a href="">
        <div id="">
            <img src="">
            <div>
                <h3 class="default-font bold" style="color: black;">title</h3>
                <p class="default-font bold" style="color: black;">address, zip_code city</p>
                <br>

                <div class="info-section">
                    <i class="fa-solid fa-calendar-days" style="color: black;">date</i>
                    <i class="fa-solid fa-user" style="color: black;">slots</i>
                </div>
                <br>
            </div>
        </div>
    </a>
</template>
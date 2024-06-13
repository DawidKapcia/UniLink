<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/events.css"/>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css"/>
    <title>UniLink | Add new event</title>
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
            
            <div class="events-container flex-center">

                <form class="flex-center" action="add_event" method="POST" ENCTYPE="multipart/form-data">

                    <?php
                        if(isset($messages)){
                            foreach($messages as $message) {
                                echo "<p class='warning-box default-font'>".$message."</p>";
                            }
                        }
                    ?>

                    <input class="default-font" type="text" name="title" placeholder="Name" required>
                    <input class="default-font" style="line-height: 10px" type="date" name="date" required>
                    <input class="default-font" type="text" name="hour" placeholder="Hour" required>
                    <input class="default-font" type="number" name="max_slots" placeholder="Available slots" min=1 required>
                    <input class="default-font" type="text" name="address" placeholder="Address" required>
                    <input class="default-font" type="text" name="city" placeholder="City" required>
                    <input class="default-font" type="text" name="zip_code" placeholder="Zip code" required>
                    <input class="default-font" type="text" name="description" placeholder="Description" required>
                    <input class="default-font" style="border: 0px; box-shadow: none" type="file" name="file" required>
                    
                    <br><button type="submit" class="filled-button default-font last-button">CONFIRM</button>
                </form>
            </div>
        </div>
    </div>
</body>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/forms.css"/>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css"/>
    <title>UniLink | Forgot password?</title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
    <script type="text/javascript" src="./public/js/password.js" defer></script>
</head>

<body>
    <div class="flex-center start-background">
        <div class="start-container">

            <img class="logo" src="public/img/logo.svg">
            <h3 class="default-font cell">Change your password to continue</h3>

            <form class="flex-center" action="password" method="POST">
                
                <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo "<p class='warning-box default-font'>".$message."</p>";
                        }
                    }
                ?>

                <input class="default-font" type="email" name="email" placeholder="Email address" required>
                <input class="default-font password-hidden" type="password" name="new-password" placeholder="New password" required>
                <input class="default-font password-hidden" type="password" name="repeated-password" placeholder="Repeat new password" required>
                <button type="submit" class="filled-button default-font last-button">CONFIRM</button>
            </form>

        </div>
    </div>
</body>
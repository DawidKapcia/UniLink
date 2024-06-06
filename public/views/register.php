<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/forms.css"/>
    <title>UniLink | Create a new account</title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
</head>

<body>
    <div class="flex-center start-background">
        <div class="start-container">
            
            <img class="logo" src="public/img/logo.svg">
            <h3 class="default-font">Sing up to begin your journey!</h3>

            <form class="flex-center" action="register" method="POST">
                
                <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo "<p class='warning-box default-font'>".$message."</p>";
                        }
                    }
                ?>

                <input class="default-font" type="email" name="email" placeholder="Email address" required>
                <input class="default-font" type="text" name="first-name" placeholder="First name" required>
                <input class="default-font" type="text" name="last-name" placeholder="Last name" required>
                <input class="default-font password-hidden" type="password" name="password" placeholder="Password" required>

                <button type="submit" class="filled-button default-font last-button">SIGN UP</button>
            </form>
            
            <p class="default-font">Have an account? <a href="login">Login here</a></p>
        </div>
    </div>
</body>
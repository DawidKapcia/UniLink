<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/forms.css"/>
    <title>UniLink | Login to your account</title>
    <link rel="icon" type="image/x-icon" href="public/img/icon.svg">
</head>

<body>
    <div class="flex-center start-background">
        <div class="start-container">

            <img class="logo" src="public/img/logo.svg">

            <h3 style="margin-bottom: -1vh;" class="default-font">Welcome back!</h3>
            <h3 class="default-font">Please login to continue</h3>
            
            <form class="flex-center" action="login" method="POST">
                
                <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo "<p class='warning-box default-font'>".$message."</p>";
                        }
                    }
                ?>

                <input class="default-font" type="email" name="email" placeholder="Email address" required>
                <input class="default-font password-hidden" type="password" name="password" placeholder="Password" required>
            
                <p class="default-font"><a href="password">Forgot password?</a></p>

                <button type="submit" class="filled-button default-font last-button">LOGIN</button>
            </form>
            <p>Not a member? <a href="register">Create an account</a></p>

        </div>
    </div>
</body>

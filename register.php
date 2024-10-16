<?php

if (isset($_COOKIE['logged_in'])){
    header("Location: index.php", true, 302);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $Name = $_POST['name-register'];
    $username = $_POST['username-register'];
    $password = $_POST['password-register'];
    $password_confirm = $_POST['password-confirm-register'];
    $securityQuestion = $_POST['security-question'];
    $securityAnswer = $POST['security-answer'];

    $file = fopen("db/users.csv", "r");
    while (($data = fgetcsv($file)) !== false){
        if ($data[0] === $username){
            header("Location: register.php?username_taken", true, 302);
            die();
        }
    }
    
    fclose($file);
    if (strcmp($password, $password_confirm) === 0){
        header("Location: register.php?passwords_dont_match", true, 302);
        die();
    } else {
        $file = fopen("db/users.csv", "a");
        fputcsv($file, array($username, password_hash($password, PASSWORD_DEFAULT), $Name, $securityQuestion, $securityAnswer));
        session_start();
        setcookie("logged_in", $username, time() + 60 * 60 * 24 * 30);
        header("Location: index.php", true, 302);
        die();
    }

}

require_once("includes/header.php");
?>
<h1 class="py-2">Sign Up</h1>
<?php
    if (isset($_GET['username_taken'])){
        echo "<h3 class='error-message'>UserName Taken</h3>";
    }
    if (isset($_GET['passwords_dont_match'])){
        echo "<h3 class='error-message'>Passwords Dont Match</h3>";
    }
?>
<form action="register.php" method="POST" class="form-signin sign-in register-frm m-3">
    <div>
        <div class="form-floating">
            <input type="text" name="name-register" id="name-register" class="form-control" required>
            <label for="name-register">Full Name</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password-register" id="password-register" class="form-control" required>
            <label for="password-register">Password</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password-register-confirm" id="password-register-confirm" class="form-control" required>
            <label for="password-register-confirm">Confirm Password</label>
        </div>
    </div>
    <div class="d-flex flex-column">
        <div class="form-floating">
            <?php
                if (isset($_GET['username_taken'])){
                    echo <<<START
                        <input type="text" name="username-register" class="form-control" placeholder="USERNAME TAKEN" required>
                        <label for="username-register">Username</label>
                    START;
                } else {
                    echo <<<START
                        <input type="text" name="username-register" class="form-control" required>
                        <label for="username-register">Username</label>
                    START;
                }
            ?>
            
        </div>
        <div class="form-floating">
            <input type="text" name="security-question" class="form-control" required>
            <label for="security-question">Security Question</label>
        </div>
        <div class="form-floating">
            <input type="password" name="security-Answer" class="form-control" required>
            <label for="security-question">Security Answer</label>
        </div>
    </div>
    <button type="submit" class="btn-primary btn w-100 register-submit">register</button>
</form>

<?php
    require_once("includes/footer.php");
?>
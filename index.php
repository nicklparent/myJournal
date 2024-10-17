<?php
require_once("includes/header.php");
if (!isset($_COOKIE['logged_in'])) {
    echo '<h1 class="text-center">Sign In</h1>';
    if (isset($_GET['login_error'])) {
        echo "<h5 class='error-message'>UserName or Password Wrong</h5><p class='text-center'><a href='register.php'>Register</a></p>";
    }
    echo '
        <form action="includes/login.php" method="POST" class="form-signin sign-in register-frm m-3 login d-flex flex-column">
            <div class="form-floating">
                <input type="text" name="username" id="username" class="form-control" required>
                <label for="username">UserName</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" id="password" class="form-control" required>
                <label for="password">Password</label>
            </div>
            <div class="d-flex ">
                <button type="submit" class="btn-primary btn w-100 signIn-submit">Sign In</button>
                <button class="reg-btn btn-primary btn w-100>Register</button>
            </div>
        </form>';
} else {
    ?>
        <div>
            <h1 class="greeting">Welcome <?php echo $_COOKIE['logged_in'];?></h1>
            <br>
        </div>
        <div>
            <?php
                $file = fopen("db/entries.csv", "r");
                while (($data = fgetcsv($file)) !== false){
                    if ($_COOKIE['logged_in'] === $data[0]){
                        echo '
                        <div class="entry">
                            <div class="entry-header">
                                <h5>' . $data[1] . '</h5>
                                <p>|</p>
                                <h5>' . $data[3] . '</h5>
                            </div>
                            <div class="entry-body">
                                <p>' . $data[2] . '</p>
                            </div>
                        </div>';
                    }
                }
            ?>
        </div>
    <?php
}
require_once("includes/footer.php");
?>

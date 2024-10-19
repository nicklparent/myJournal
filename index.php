<?php
session_start();
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
                <a class="btn-primary btn w-100" id="reg-btn">Register</a>
            </div>
            <a href="index.php?forgot_password" class="btn" style="background-color: white;">Forgot Password</a>
        </form>';
    
} else {

    ?>
        <div>
            <h1 class="greeting">Welcome <?php echo (isset($_SESSION['display_name'])) ? $_SESSION['display_name']: "Login";?></h1>
            <br>
        </div>
        <a href="add_entry.php" class="entry-btn">+New Entry</a>
        <div>
            <?php
                $file = fopen("db/entries.csv", "r");
                while (($data = fgetcsv($file)) !== false){
                    if ($_COOKIE['logged_in'] === $data[0]){
                        echo '
                        <div class="entry">
                            <div class="entry-header">
                                <h5 style="font-weight: 600;">' . $data[1] . '</h5>
                                <p>|</p>
                                <div class="dropdown" >
                                    <h6 style="color: #4b5257;" class="dropdown-toggle">' . $data[3] . '</h6>
                                    <ul class="dropdown-menu">
                                        <li><button class="dropdown-item"' . $data[2] . '" id="edit-btn" onclick="setEditCookie(\'' . $data[2] . '\')">Edit</button></li>
                                        <li><button class="dropdown-item"' . $data[2] . '" id="edit-btn" onclick="setDeleteCookie(\'' . $data[2] . '\')">Delete</button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="entry-body">
                                <p>' . $data[2] . '</p>
                            </div>
                        </div>';
                    }
                }

            ?>
        </div>
        <script>
            function setEditCookie(content){
                document.cookie = "edit_entry=" + encodeURIComponent(content) + "; path=/";
                window.location.href = "edit_entry.php";
            };
            function setDeleteCookie(content){
                document.cookie = "delete_entry=" +encodeURIComponent(content) + "; path=/";
                window.location.href = "delete_entry.php";
            };
        </script>
    <?php
}
require_once("includes/footer.php");
?>

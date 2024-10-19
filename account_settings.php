<?php
    session_start();
    if (!isset($_COOKIE['logged_in'])){
        header("Location: index.php", true, 302);
        die();
    }
    $userinfo = array();
    
    require_once("includes/header.php");
    
    $file = fopen("db/users.csv", "r");
    $rows = array();

    //store user data and a copy of csv file
    while (($data = fgetcsv($file)) !== false){
        $rows[] = $data;
        if ($data[0] === $_COOKIE['logged_in']){
            $userinfo = $data;
        }
    }
    fclose($file);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username-setting'])){
        $file = fopen("db/users.csv", "r");
        $rows = array();
        while (($data = fgetcsv($file)) !== false){
            $rows[] = $data;
        }
        fclose($file);
        
        for ($i = 0; $i < count($rows); $i++){
            if ($rows[$i][0] === $_COOKIE['logged_in']){
                $rows[$i][0] = $_POST['username-setting'];
                setcookie("logged_in", $rows[$i][0], time() + 60 * 60 * 24 * 30,"/");
                break;
            }
        }
        $file = fopen("db/users.csv", "w");
        foreach ($rows as $curr){
            fputcsv($file, $curr);
        }
        fclose($file);
        header("Location: account_settings.php", true, 302);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['displayname-setting'])){
        session_regenerate_id();
        $_SESSION['display_name'] = $_POST['displayname-setting'];
        header("Location: account_settings.php", true, 302);
        die();
    }

    if (isset($_GET['reset_password']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $found = false;
        for ($i = 0; $i < count($rows); $i++){

            if ($rows[$i][0] === $userinfo[0] && password_verify($_POST['old-password'], $rows[$i][1])){
                if ($_POST['new-password'] === $_POST['confirm-password']){
                    $rows[$i][1] = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
                    $found = true;
                    break;
                }
            }
        }
        
        if (!$found){
            echo "<h1 class='error-message'>Invalid Password</h1>";
        } else {
            $file = fopen("db/users.csv", "w");
            foreach ($rows as $curr){
                fputcsv($file, $curr);
            }
            fclose($file);
            header("Location: account_settings.php", true, 302);
            die();
        }
    }
    
    
    
    if (isset($_GET['reset_password'])){
        ?>
            <form action="account_settings.php?reset_password" method="POST" class="flex-d w-50">
                <div class="form-floating">
                    <input type="password" name="old-password" id="old-password" class="form-control">
                    <label for="password">Old password</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="new-password" id="new-password" class="form-control">
                    <label for="password">New password</label> 
                </div>
                <div class="form-floating">
                    <input type="password" name="confirm-password" id="confirm-password" class="form-control">
                    <label for="confirm-password">Confirm Password</label>

                </div>
                <button class="btn btn-primary w-100">Submit</button>
            </form>
        <?php
    } else {
    
?>
<h1><?php echo $_SESSION['display_name'];?> Settings</h1>
<form action="account_settings.php" method="POST" class="flex-d">
    <div class="form-floating setting-form">
        <input type="text" name="username-setting" id="username-setting" class="form-control"
        value=<?php echo $userinfo[0];?>>
        <label for="username-setting">UserName</label>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>

    <div class="form-floating setting-form">
        <input type="text" name="displayname-setting" id="displayname-setting" class="form-control"
        value=<?php echo $_SESSION['display_name'];?>>
        <label for="username-setting">Display Name</label>
        <button type="submit" class="btn btn-primary">Set Name</button>
    </div>

    <div class="form-floating setting-form">
        <a href="account_settings.php?reset_password" class="btn">Reset Password</a>
        <a href="includes/logout.php" class="btn btn-primary">Logout</a>
    </div>

</form>

<script>
    
</script>

<?php
    }
    require_once("includes/footer.php")
?>
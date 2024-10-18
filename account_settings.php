<?php
    session_start();
    if (!isset($_COOKIE['logged_in'])){
        header("Location: index.php", true, 302);
    }

    //get account settings
    $file = fopen("db/users.csv", "r");
    $userinfo = array();
    while (($data = fgetcsv($file)) !== false){
        if ($data[0] === $_COOKIE['logged_in']){
            for ($i = 0; $i < count($data); $i++){
                $userinfo[] = $data[$i];
            }
        }
    }
    require_once("includes/header.php");

    
?>
<h1><?php echo $_COOKIE['logged_in'];?> Settings</h1>
<form action="account_settings.php" method="POST" class="flex-d">
    <div class="form-floating setting-form">
        <input type="text" name="username-setting" id="username-setting" class="form-control"
        value=<?php echo $userinfo[0];?>>
        <label for="username-setting">UserName</label>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
    <div class="form-floating setting-form">
        <input type="text" name="displayname-setting" id="displayname-setting" class="form-control"
        value=<?php $_SESSION['display_name']?>>
        <label for="username-setting">Display Name</label>
        <button type="submit" class="btn btn-primary">Set Name</button>
    </div>
</form>
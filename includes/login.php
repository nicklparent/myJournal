<?php

if (isset($_COOKIE['logged_in'])){
    session_start();
    header("Location: ../index.php", true, 302);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $file = fopen("../db/users.csv", "r");
    
    while (($data = fgetcsv($file)) !== false){
        if ($username === $data[0] && password_verify($password, $data[1])){
            session_start();
            $_SESSION['display_name'] = $username;
            setcookie("logged_in", $username, time() + 60 * 60 * 24 * 30, "/");
            header("Location: ../index.php", true, 302);
            die();
        }
    }
    fclose($file);
    header("Location: ../index.php?login_error", true, 302);
    die();
}
?>

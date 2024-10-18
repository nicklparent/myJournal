<!-- logout syntax aided from chatgpt
 accessed october 18th, https://chatgpt.com/share/671290f7-a820-8003-90f5-abee32aa09f7 -->

<?php
    session_start();

    $_SESSION = array();

    foreach ($_COOKIE as $currcookie => $cookie_value){
        setcookie($currcookie, '', time() - 1000, '/', '', false, true);
    }

    if (ini_get("session.use_cookies")){
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 1000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header("Location: ../index.php", true, 302);
    die();
?>
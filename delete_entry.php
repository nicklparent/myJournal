<?php
    if (!isset($_COOKIE['logged_in'])){
        header("Location: index.php", true, 302);
        die();
    }

    $file = fopen("db/entries.csv", "r");

    $rows = array();

    while (($data = fgetcsv($file)) !== false){
        if (!($data[2] === $_COOKIE['delete_entry'] && $data[0] === $_COOKIE['logged_in'])){
            $rows[] = $data;
        }
    }
    fclose($file);

    $file = fopen("db/entries.csv", "w");
    foreach ($rows as $curr){
        fputcsv($file, $curr);
    }
    fclose($file);
    header("Location: index.php", true, 302);
    setcookie("delete_entry", "", time() - 1000, "/");
?>
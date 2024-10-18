<?php
session_start();
setcookie("edit_entry", "Test", time() + 10000000);
function cleanInput($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = preg_replace('/\s+/', ' ', $data);
    return $data;  
}

$file = fopen("db/entries.csv", "r");

$rows = array();

$title = '';
$entry = '';
$date = '';
$username = '';

while (($data = fgetcsv($file)) !== false){
    $rows[] = $data;
    if ($data[2] === $_COOKIE['edit_entry'] && $data[0] === $_COOKIE['logged_in']){
        $username = $data[0];
        $title = $data[1];
        $entry = $data[2];
        $date = $data[3];
    }
}

fclose($file);

$new_title = "temp title";
$new_entry = "tmep_entry";

for ($i = 0; $i < count($rows); $i++){
    if ($rows[$i][2] === $_COOKIE['edit_entry'] && $rows[$i][0] === $_COOKIE['logged_in']){
        $rows[$i][2] = $new_entry;
        $rows[$i][1] = $new_title;
    }
}

$file = fopen("db/entries.csv", "w");
foreach ($rows as $curr){
    fputcsv($file, $curr);
}
header()
?>
<div class="entry">
    <div class="entry-header">
        <h5 style="font-weight: 600;">' . $data[1] . '</h5>
        <div class="dropdown" >
            <h6 style="color: #4b5257;" class="dropdown-toggle">' . $data[3] . '</h6>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="edit_entry.php?entry=<?php echo $data[2] . "name=" . $data[0];?>">Edit</a></li>
                <li><a class="dropdown-item" href="delete_entry.php">Delete</a></li>
            </ul>
        </div>
    </div>
    <div class="entry-body">
        <p>' . $data[2] . '</p>
    </div>
</div>'
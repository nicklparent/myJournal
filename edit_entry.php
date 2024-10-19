<?php
    function cleanInput($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = preg_replace('/\s+/', '', $data);
        return $data;  
    }
    
    if (!isset($_COOKIE['logged_in'])){
        header("Location: index.php", true, 302);
        die();
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $new_title = $_POST['title-in'];
        $new_entry = $_POST['entry-input'];

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
        fclose($file);
        setcookie("edit_entry", "", time() - 1000);
        header("Location: index.php", true, 302);
        die();
    }
    
    require_once("includes/header.php");
?>

<h1 class="greeting">Edit Entry</h1>
<div class="entry" style="width: 60%">
    <form action="edit_entry.php" method="POST" class="flex-d">    
        <div class="entry-header form-floating">
            <h5><?php echo $username;?></h5>
            <p>|</p>
            <h5> <?php echo $date;?></h5>
        </div>
        <?php
            if (isset($_GET['invalid'])){
        ?>
            <h2 class="error-message">Invalid Input</h2>
        <?php
            }
        ?>
        <div class="form-floating">
            <input type="text" name="title-in" id="title-in" class="form-control w-50" value="<?php echo $title;?>" required>
            <label for="title-in">Title</label>
        </div>
        <br>
        <div class="entry-body form-floating">
            <textarea name="entry-input" class="form-control entry-input" style="height: 30vh; white-space: pre-wrap;"><?php echo $entry;?></textarea>
            <label for="entry-input">Journal Entry</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>

<?php
    require_once("includes/footer.php");
?>
<?php
    function cleanInput($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = preg_replace('/\s+/', ' ', $data);
        return $data;  
    }
    
    if (!isset($_COOKIE['logged_in'])){
        header("Location: index.php", true, 302);
        die();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $file = fopen("bd/entries.csv");
        $rows = array();

        while (($data = fgetcsv($file)) !== false){
            $rows[] = $data;
        }
        fclose($file);
    }

    require_once("includes/header.php");
?>

<h1 class="greeting">Edit Entry</h1>
<div class="entry" style="width: 60%">
    <form action="edit_entry.php" method="POST" class="flex-d">    
        <div class="entry-header form-floating">
            <h5><?php echo $_COOKIE['logged_in'];?></h5>
            <p>|</p>
            <h5> <?php echo date("Y-m-d");?></h5>
        </div>
        <?php
            if (isset($_GET['invalid'])){
        ?>
            <h2 class="error-message">Invalid Input</h2>
        <?php
            }
        ?>
        <div class="form-floating">
            <input type="text" name="title-in" id="title-in" class="form-control w-50">
            <label for="title-in">Title</label>
        </div>
        <br>
        <div class="entry-body form-floating">
            <textarea name="entry-input" class="form-control entry-input" style="height: 30vh; white-space: pre-wrap;"></textarea>
            <label for="entry-input">Journal Entry</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
</div>

<?php
    require_once("includes/footer.php");
?>
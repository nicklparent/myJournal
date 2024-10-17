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
        $entry = cleanInput($_POST['entry-input']);
        $title = $_POST['title-in'];

        $file = fopen("db/entries.csv", "a");
        
        if ($entry !== null && strlen($title) < 50){
            fputcsv($file, array($_COOKIE['logged_in'], $title, $entry, date("Y-m-d")));
            header("Location: index.php", true, 302);
            die();
        } else {
            header("Location: add_entry.php?invalid", true, 302);
        }
        
    }
    require_once("includes/header.php");  
?>
<h1 class="greeting">New entry</h1>
<div class="entry" style="width: 60%">
    <form action="add_entry.php" method="POST" class="flex-d">    
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
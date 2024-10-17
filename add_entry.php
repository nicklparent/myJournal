<?php
    if (!isset($_COOKIE['logged_in'])){
        header("Location: index.php", true, 302);
        die();
    }
    require_once("includes/header.php");  
?>
<h1 class="greeting">New entry</h1>
<div class="entry" style="width: 70%">
    <form action="add_entry.php" method="POST" class="flex-d">
        
        <div class="entry-header form-floating">
            <h5><?php echo $_COOKIE['logged_in'];?></h5>
            <p>|</p>
            <h5> <?php echo date("Y-m-d");?></h5>
        </div>
        <div class="entry-body form-floating">
            <input type="text" name="entry-input-" class="form-control">
            <label for="entry-input">Journal Entry</label>
        </div>
    </form>
</div>

<?php
    require_once("includes/footer.php");
?>
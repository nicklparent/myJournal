
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal</title>
    <!-- 
    Boostrap retrieved on October 7th 2024 from https://getbootstrap.com/
    -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- 
Boostrap header accessed october 7th 2024 from https://getbootstrap.com/docs/5.3/examples/headers/ 
-->
<header class="p-3 text-bg-dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <h4 class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"> My Journal </h4>
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="add_entry.php" class="nav-link px-2 text-secondary">Add Entry</a></li>
        </ul>
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
        </form>

        <div class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <button type="button" class="btn btn-primary dropdown-toggle"><img class="rounded-circle" src="icons/profile.png" alt="profile" width="40" height="25">
          Account
          </button>
          <ul class="dropdown-menu">
            <?php 
              if (isset($_COOKIE['logged_in'])){
                echo <<<DROPDOWN
                  <li><a class='dropdown-item' href='account_settings.php'>{$_COOKIE['logged_in']}</a></li>
                  <li><a class='dropdown-item' href='includes/logout.php'>Logout</a></li>
                DROPDOWN;
              } else {
                echo <<<DROPDOWN
                  <li><a class='dropdown-item' href='index.php'>Sign In</a></li>
                  <li><a class='dropdown-item' href='register.php'>Register</a></li>
                DROPDOWN;
              }
            ?>
            
          </ul>
        </div>
      </div>
    </div>
  </header>
  <main class="pg-main d-flex align-items-center flex-column">
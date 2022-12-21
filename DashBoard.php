<?php 
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php'); 

  Confirm_Admin_Login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome link for icons -->
    <script src="https://kit.fontawesome.com/871a1b0612.js" crossorigin="anonymous"></script>
    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Dashboard</title>
</head>
<body style="background: linear-gradient(to right, #000000, #222831);">
    
    <!-- start of navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background:#393E46;">
        <div class="container">
          <a class="navbar-brand" href="Dashboard.php">Origin Library</a>         
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav"> 
            <li class="nav-item">
                  <a class="nav-link active" href="Dashboard.php">Dashboard</a>
            </li>             
              <li class="nav-item">
                <a class="nav-link" href="AddNewAdmin.php">Admins</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="ViewUsers.php">Users</a>
              </li>  
              <li class="nav-item">
                <a class="nav-link" href="Books.php">Books</a>
              </li>  
              <li class="nav-item">
                <a class="nav-link" href="Categories.php">Categories</a>
              </li>                         
            </ul>            
          </div>
          <!-- list for aligning items to the right of the navbar -->
          <ul class="navbar-nav">            
            <li class="nav-item"><a href="AdminLogout.php" class="nav-link">Logout</a></li> 
            <li class="nav-item"><a class="nav-link disabled">WELCOME ADMIN: <?php echo strtoupper($_SESSION["UserName"]); ?></a></li>            
        </ul>
        </div>
      </nav>
    <!-- end of navbar -->
    
    <!-- START OF HEADER -->

      <header class="text-white py-4 bg-dark">
        <div class="container">
            <div class="row">  
                <div class="col-md-12">              
                    <h1><i class="fa-solid fa-gear" style="color:#00FFF5;"></i> Dashboard</h1>
                </div> 
                <div class="d-grid gap-2 col-lg-3 btn" style="padding:12px;">
                    <a href="AddNewBook.php" class="btn btn-primary btn-block"> <i class="fa-solid fa-pen-clip"></i> Add New Book </a>
                </div> 
                <div class="d-grid gap-2 col-lg-3 btn" style="padding:12px;">
                    <a href="Categories.php" class="btn btn-info btn-block"> <i class="fa-solid fa-folder-open"></i> Add New Category </a>
                </div> 
                <div class="d-grid gap-2 col-lg-3 btn" style="padding:12px;">
                    <a href="AddNewAdmin.php" class="btn btn-success btn-block"> <i class="fa-solid fa-user-plus"></i> Add New Admin</a>
                </div> 
                <div class="d-grid gap-2 col-lg-3 btn" style="padding:12px;">
                    <a href="ViewUsers.php" class="btn btn-warning btn-block"> <i class="fa-solid fa-users"></i> View Users</a>
                </div>           
            </div>
        </div>
      </header>     

    <!-- END OF HEADER -->

    <!-- MAIN CONTENT START -->
    <section class="container py-2 mb-4">
        
        <div class="row">  
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>        
            <div class="col-lg-2">
                <div class="card text-center bg-light text-dark mb-3">
                    <div class="card-body">
                        <h1 class="lead">Books</h1>
                        <h4 class="display-5">
                            <i class="fa-brands fa-readme"></i>
                            <?php 
                            global $ConnectingDB;
                            $sql = "SELECT COUNT(*) FROM book";
                            $stmt = $ConnectingDB->query($sql);
                            $TotalRows = $stmt->fetch();
                            $TotalBooks=array_shift($TotalRows);
                            echo $TotalBooks;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-light text-dark mb-3">
                    <div class="card-body">
                        <h1 class="lead">Users</h1>
                        <h4 class="display-5">
                            <i class="fa-solid fa-users"></i>
                            <?php 
                            global $ConnectingDB;
                            $sql = "SELECT COUNT(*) FROM users";
                            $stmt = $ConnectingDB->query($sql);
                            $TotalRows = $stmt->fetch();
                            $TotalUsers=array_shift($TotalRows);
                            echo $TotalUsers;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-light text-dark mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h4 class="display-5">
                            <i class="fa-solid fa-folder"></i>
                            <?php 
                            global $ConnectingDB;
                            $sql = "SELECT COUNT(*) FROM category";
                            $stmt = $ConnectingDB->query($sql);
                            $TotalRows = $stmt->fetch();
                            $TotalCategories=array_shift($TotalRows);
                            echo $TotalCategories;
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-light text-dark mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h4 class="display-5">
                            <i class="fa-solid fa-user-tie"></i>
                            <?php 
                            global $ConnectingDB;
                            $sql = "SELECT COUNT(*) FROM admins";
                            $stmt = $ConnectingDB->query($sql);
                            $TotalRows = $stmt->fetch();
                            $TotalAdmins=array_shift($TotalRows);
                            echo $TotalAdmins;
                            ?>
                        </h4>
                    </div>
                </div>                        
            </div>
            <div class="col-lg-10">
                <h1 class="text-white">Recent Publishes</h1>
                <table class="table table-striped table-hover text-white" style="background:#393E46;">
                    <thead >
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>                            
                        </tr>
                    </thead>
                    <?php 
                    global $ConnectingDB;
                    $sql = "SELECT * FROM book ORDER BY id desc LIMIT 0,7"; 
                    $stmt = $ConnectingDB->query($sql);
                    while($DataRows=$stmt->fetch()){
                        $BookId = $DataRows["id"];
                        $BookTitle = $DataRows["title"];
                        $BookAuthor = $DataRows["author"];
                        $BookCategory = $DataRows["category"];                      
                    
                    ?>
                
                <tbody class="table-light">
                    <tr>
                        <td><?php echo $BookId; ?></td>
                        <td><?php echo $BookTitle; ?></td>
                        <td><?php echo $BookAuthor; ?></td>
                        <td><?php echo $BookCategory; ?></td>
                    </tr>
                </tbody>
                <?php } ?>
                </table>
            </div>
        </div>

    </section>
    <!-- MAIN CONTENT END -->

    <!-- starting of footer -->
      <footer class="bg-dark text-white fixed-bottom pt-3">
        <div class="container">
            <div class="row">
                <div class="col">
                <p class="lead text-center" style="font-size:15px ;"> &copy; 2022 All rights reserved</p>
                </div>
            </div>
        </div>
      </footer>
    <!-- ending of footer -->


    <!-- bundle link for bootstrap dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- script for bootstrap 5.1.3 from the separate section -->
    <!-- NB: not certain if these links below are needed since ive added the bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
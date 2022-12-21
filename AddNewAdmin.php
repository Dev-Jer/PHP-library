<?php  
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php'); 
 
  Confirm_Admin_Login();

  if(isset($_POST["Submit"])){
    $UserName = $_POST["Username"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];


  
    //varification of category title
    if(empty($UserName)||empty($Password)||empty($ConfirmPassword)){
      $_SESSION["ErrorMessage"]= "All field must be filled out.";
      Redirect_to("AddNewAdmin.php");
    }elseif (strlen($UserName) < 3) {
        $_SESSION["ErrorMessage"]= "Username Too Short";
        Redirect_to("AddNewAdmin.php");
    }elseif (strlen($UserName) > 19) {
        $_SESSION["ErrorMessage"]= "Username Too Long";
        Redirect_to("AddNewAdmin.php");
    }elseif (strlen($Password) < 4) {
      $_SESSION["ErrorMessage"]= "Password Too Short";    
      Redirect_to("AddNewAdmin.php");
    }elseif (strlen($Password) > 19) {
      $_SESSION["ErrorMessage"]= "Password Too Long";
      Redirect_to("AddNewAdmin.php");
    }elseif ($Password !== $ConfirmPassword) {
      $_SESSION["ErrorMessage"]= "Both Password should match";
      Redirect_to("AddNewAdmin.php");
    }
    elseif (CheckAdminUserNameExist($UserName)) {
      $_SESSION["ErrorMessage"]= "Username Exist";
      Redirect_to("AddNewAdmin.php");
    }
    else{
      //=========================
      //query to executed if validation was successful
      global $ConnectingDB;
      $sql = "INSERT INTO admins(username,password)";
      $sql .= "VALUES(:userName,:passWord)";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindValue(':userName',$UserName);
      $stmt->bindValue(':passWord',$Password);
      $Execute=$stmt->execute();

      if ($Execute) {
        $_SESSION["SuccessMessage"]="New Admin Added Successfully";
      Redirect_to("AddNewAdmin.php");
      }else {
        $_SESSION["ErrorMessage"]="Error in Operation";
      Redirect_to("AddNewAdmin.php");
      }
    }
  }
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
    <title>Admins</title>
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
          <!-- ------------  -->
        </div>
      </nav>
    <!-- end of navbar -->
    
    <!-- START OF HEADER -->

      <header class="text-white py-4 bg-dark">
        <div class="container">
            <div class="row">
                <h1><i class="fa-solid fa-user-tie" style="color:#00FFF5;"></i> Manage Admins</h1>
            </div>
        </div>
      </header>

    <!-- END OF HEADER -->

    <!-- MAIN CONTENT START -->
    <section class="container py-2 mb-4">

    <div class="row">
        <div class="offset-lg-3 col-lg-6">
          <!-- error message call -->
          <?php 
          echo ErrorMessage();
          echo SuccessMessage();
          ?>
        <form class="" accept="AddNewAdmin.php" method="post">
            <div class="card  bg-secondary text-dark mb-3">
                <div class="card-header" >
                    <h1>Admin Registration</h1>
                </div>
                <div class="card-body" style="background:#F3EFE0;">
                    <div class="form-group">
                        <label class="form-label" for="Username" style="font-weight:bold; font-size:17px"> Username</label>
                        <input class="form-control" type="text" name="Username" id="username" value="">
                    </div> 
                    <div class="form-group">
                        <label class="form-label" for="Password" style="font-weight:bold; font-size:17px"> Password</label>
                        <input class="form-control" type="password" name="Password" id="password" value="">
                    </div> 
                    <div class="form-group">
                        <label class="form-label" for="ConfirmPassword" style="font-weight:bold; font-size:17px"> Confirm Password</label>
                        <input class="form-control" type="password" name="ConfirmPassword" id="confirmpassword" value="">
                    </div>  
                    <div class="row">
                      <div class="d-grid gap-2 col-lg-6" style="padding:12px;">
                        <a href="Dashboard.php" class="btn btn-warning" type="button"><i class="fa-solid fa-arrow-left-long"></i> Back</a>                        
                      </div>
                      <div class="d-grid gap-2 col-lg-6 btn" style="padding:12px;">
                        <button class="btn btn-success" type="submit" name="Submit"><i class="fa-solid fa-check"></i> Submit</button>                        
                      </div>
                    </div>                 
                </div>
            </div>
        </form>
        <h2 class="text-white">Existing Admins</h2>
        <table class="table table-striped table-hover table-light mb-5">
                    <thead class="table-dark">                    
                    <tr>
                        <th>ID#</th>                        
                        <th>Admin Username</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <?php 
                    
                    global $ConnectingDB;
                    $sql = "SELECT * FROM admins ORDER BY id desc";
                    $Execute =$ConnectingDB->query($sql);
                    $Sr = 0;
                    while ($DataRows = $Execute->fetch()) {                       
                        $AdminId = $DataRows["id"];
                        $AdminUserName   = $DataRows["username"];
                        //$Sr++        ;                              
                    ?>
                    
                    <tr>
                        <td><?php echo $AdminId; ?></td>
                        <td><?php echo $AdminUserName; ?></td>
                        <td>
                            <a href="DeleteAdmin.php?id=<?php echo $AdminId; ?>"><span class="btn btn-danger">Delete</span></a>                                                                                             
                        </td>                
                    </tr>
                    
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
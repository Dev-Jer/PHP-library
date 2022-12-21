<?php  
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php');
   
  Confirm_Admin_Login();
?>

<?php
  $SearchQueryParameter = $_GET['id'];
  if(isset($_POST["Submit"])){
    $FullName = $_POST["FullName"];
    $UserName = $_POST["UserName"];
    //$Email = $_POST["Email"];
    $Gender = $_POST["Gender"];
    $Address = $_POST["Address"];
    $UserImage = $_FILES["UserImage"]["name"];
    $Target     = "profile/".basename($_FILES["UserImage"]["name"]);
    $Bio = $_POST["Bio"];
    
    if(empty($FullName)||empty($UserName)){
      $_SESSION["ErrorMessage"]= "Full name, User name or Email cannot be empty";
      Redirect_to("ViewUsers.php");      
    }elseif (strlen($FullName) <= 2) {
      $_SESSION["ErrorMessage"]= "Full name should be more than two (2) characters";    
      Redirect_to("ViewUsers.php");
    }elseif (strlen($FullName) > 49) {
      $_SESSION["ErrorMessage"]= "User name should be less than Fifty (50) characters";
      Redirect_to("ViewUsers.php");
    }elseif (strlen($UserName) <= 2) {
        $_SESSION["ErrorMessage"]= "User name should be more than two (2) characters";    
        Redirect_to("ViewUsers.php");
    }elseif (strlen($UserName) > 49) {
        $_SESSION["ErrorMessage"]= "Full name should be less than Fifty (50) characters";
        Redirect_to("ViewUsers.php");   
    }else{ 
      //=========================
      //query to executed if validation was successful
      global $ConnectingDB;
      if (!empty($_FILES["UserImage"]["name"])) {
        $sql = "UPDATE users 
                SET fullname='$FullName', username='$UserName', gender='$Gender', address='$Address', userimage='$UserImage',bio='$Bio'
                WHERE id='$SearchQueryParameter'";                
      }else{
            $sql = "UPDATE users 
            SET fullname='$FullName', username='$UserName', gender='$Gender', address='$Address', bio='$Bio'
            WHERE id='$SearchQueryParameter'";
      }
      
      $Execute =$ConnectingDB->query($sql);
      move_uploaded_file($_FILES["UserImage"]["tmp_name"],$Target);      
      if ($Execute) {
        $_SESSION["SuccessMessage"]="Book Published Successfully";
      Redirect_to("ViewUsers.php");
      }else {
        $_SESSION["ErrorMessage"]="Error in Operation";
      Redirect_to("ViewUsers.php");
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
    <title>Manage User</title>
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
                <h1><i class="fa-solid fa-user-group" style="color:#00FFF5;"></i> Manage User</h1>
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

          global $ConnectingDB;
          $SearchQueryParameter = $_GET["id"];
          $sql = "SELECT * FROM users WHERE id='$SearchQueryParameter'";
          $stmt =$ConnectingDB->query($sql);
          while ($DataRows=$stmt->fetch()){
            $FullNameUpdate = $DataRows['fullname'];
            $UserNameUpdate = $DataRows['username'];
            $EmailUpdate = $DataRows['email'];
            $GenderUpdate = $DataRows['gender'];
            $AddressUpdate = $DataRows['address'];
            $ImageUpdate = $DataRows['userimage'];
            $BioUpdate = $DataRows['bio'];
          }
          ?>
        <form class="" action="EditUser.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
            <div class="card  bg-secondary text-dark mb-3">
                <div class="card-header" >
                    <h1>Edit User</h1>
                </div>
                <div class="card-body" style="background:#F3EFE0;">
                    <div class="form-group">
                        <input class="form-control mb-4" type="text" name="FullName" placeholder="full name" id="booktitle" value="<?php  echo $FullNameUpdate; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control mb-4" type="text" name="UserName" placeholder="user name" id="booktitle" value="<?php  echo $UserNameUpdate; ?>">
                    </div>  
                    
                    <div class="form-group mb-4">
                        <select class="form-select" id="CategoryTitle" name="Gender">
                            <option selected hidden value="<?php echo $GenderUpdate?>"><?php echo $GenderUpdate?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Prefer Not To Say">Prefer Not To Say</option>                           
                        </select>
                    </div> 
                    <div class="form-group mb-4">
                        <input class="form-control mb-4" type="text" name="Address" placeholder="user name" id="Address" value="<?php  echo $AddressUpdate; ?>">
                    </div>
                    <div class="form-group">
                        <label style="font-weight:600; color:darkblue"><span>Current Profile Picture</span></label>
                        <br>
                        <img src="profileupload/<?php echo $ImageUpdate ?>" width="200px"; height="200px";>
                        <div class="input-group mt-3">
                            <input type="file" disabled class="form-control" name="UserImage" id="ImageSelect">
                            <label class="input-group-text" for="ImageSelect">Upload</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mt-3">
                            <textarea class="form-control" placeholder="Book content here" id="BookContent" name="Bio" style="height: 100px"><?php echo $BioUpdate ?></textarea>
                            <label for="BookContent">User Bio:</label>
                        </div>
                    </div>
                    <div class="row">
                      <div class="d-grid gap-2 col-lg-6" style="padding:12px;">
                        <a href="ViewUsers.php" class="btn btn-warning" type="button"><i class="fa-solid fa-arrow-left-long"></i> Back</a>                        
                      </div>
                      <div class="d-grid gap-2 col-lg-6 btn" style="padding:12px;">
                        <button class="btn btn-success" type="submit" name="Submit"><i class="fa-regular fa-pen-to-square"></i> Update</button>                        
                      </div>
                    </div>                 
                </div>
            </div>
        </form>
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
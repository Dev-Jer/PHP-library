<?php  
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php');
   
  Confirm_Admin_Login();
?>

<?php
    global $ConnectingDB;
    $SearchQueryParameter = $_GET["id"];
    $sql = "SELECT * FROM users WHERE id='$SearchQueryParameter'";
    $stmt =$ConnectingDB->query($sql);
    while ($DataRows=$stmt->fetch()){
    $FullNameDeleted = $DataRows['fullname'];
    $UserNameDeleted = $DataRows['username'];
    $EmailDeleted = $DataRows['email'];
    $GenderDeleted = $DataRows['gender'];
    $AddressDeleted = $DataRows['address'];
    $ImageDeleted = $DataRows['userimage'];
    $BioDeleted = $DataRows['bio'];
    }

  $SearchQueryParameter = $_GET['id'];
  if(isset($_POST["Submit"])){         
      
      //query to executed if validation was successful
      global $ConnectingDB;
      $sql = "DELETE FROM users WHERE id='$SearchQueryParameter'";      
      $Execute =$ConnectingDB->query($sql);
            
      if ($Execute) {
        $Target_Path_To_Delete_Proile_Picture = "profile/$ImageDeleted";
        unlink($Target_Path_To_Delete_Proile_Picture);
        $_SESSION["SuccessMessage"]="User DELETED Successfully";
      Redirect_to("ViewUsers.php");
      }else {
        $_SESSION["ErrorMessage"]="Error in Operation";
      Redirect_to("ViewUsers.php");
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
                <h1><i class="fa-solid fa-user-xmark" style="color:#00FFF5;"></i> Delete User</h1>
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
        <form class="" action="DeleteUser.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
            <div class="card  bg-secondary text-dark mb-3">
                <div class="card-header" >
                    <h1>Delete User</h1>
                </div>
                <div class="card-body" style="background:#F3EFE0;">
                    <div class="form-group">
                        <input class="form-control mb-4" type="text" disabled name="FullName" placeholder="full name" id="booktitle" value="<?php  echo $FullNameDeleted; ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control mb-4" type="text" disabled name="UserName" placeholder="user name" id="booktitle" value="<?php  echo $UserNameDeleted; ?>">
                    </div>  
                    <div class="form-group">
                        <input class="form-control mb-4" disabled type="email" placeholder="email" name="Email" id="bookauthor" value="<?php  echo $EmailDeleted; ?>">
                    </div> 
                    <div class="form-group mb-4">
                        <select class="form-select" disabled id="CategoryTitle" name="Gender">
                            <option selected hidden value="<?php echo $GenderDeleted?>"><?php echo $GenderDeleted?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Prefer Not To Say">Prefer Not To Say</option>                           
                        </select>
                    </div> 
                    <div class="form-group mb-4">
                        <input class="form-control mb-4" disabled type="text" name="Address" placeholder="user name" id="Address" value="<?php  echo $AddressDeleted; ?>">
                    </div>
                    <div class="form-group">
                        <label><span>Current Profile Picture</span></label>
                        <br>
                        <img src="profileupload/<?php echo $ImageDeleted ?>" width="200px"; height="200px";>
                        <div class="input-group mt-3">
                            <input type="file" disabled class="form-control" name="UserImage" id="ImageSelect">
                            <label class="input-group-text" for="ImageSelect">Upload</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-floating mt-3">
                            <textarea class="form-control" disabled placeholder="Book content here" id="BookContent" name="Bio" style="height: 100px"><?php echo $BioDeleted ?></textarea>
                            <label for="BookContent">Book Content</label>
                        </div>
                    </div>
                    <div class="row">
                      <div class="d-grid gap-2 col-lg-6" style="padding:12px;">
                        <a href="Books.php" class="btn btn-success" type="button"><i class="fa-solid fa-arrow-left-long"></i> Back</a>                        
                      </div>
                      <div class="d-grid gap-2 col-lg-6 btn" style="padding:12px;">
                        <button class="btn btn-danger" type="submit" name="Submit"><i class="fa-solid fa-trash"></i> Confirm Delete</button>                        
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
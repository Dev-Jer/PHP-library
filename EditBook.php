<?php 
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php');
  Confirm_Admin_Login(); 
?>

<?php
$SearchQueryParameter = $_GET['id'];
  if(isset($_POST["Submit"])){
    $BookTitle = $_POST["BookTitle"];
    $BookAuthor = $_POST["BookAuthor"];
    $Category = $_POST["Category"];
    $BookImage = $_FILES["BookImage"]["name"];
    $Target     = "bookimages/".basename($_FILES["BookImage"]["name"]);
    $Content = $_POST["Content"];
    //varification of adding book
    if(empty($BookTitle)){
      $_SESSION["ErrorMessage"]= "Title cannot be empty";
      Redirect_to("EditBook.php?id=$SearchQueryParameter");
    }elseif (strlen($BookTitle) <= 2) {
      $_SESSION["ErrorMessage"]= "Title of book should be more than two (2) characters";    
      Redirect_to("EditBook.php?id=$SearchQueryParameter");
    }elseif (strlen($BookTitle) > 49) {
      $_SESSION["ErrorMessage"]= "Title of book should be less than Fifty (50) characters";
      Redirect_to("EditBook.php?id=$SearchQueryParameter");
    }elseif (empty($BookAuthor)) {
        $_SESSION["ErrorMessage"]= "Author cannot be empty";
      Redirect_to("EditBook.php?id=$SearchQueryParameter");
    }elseif (strlen($BookAuthor) <= 2) {
        $_SESSION["ErrorMessage"]= "Author of book should be more than two (2) characters";    
        Redirect_to("EditBook.php?id=$SearchQueryParameter");
    }
    elseif (strlen($BookAuthor) > 49) {
        $_SESSION["ErrorMessage"]= "Author of book should be less than Fifty (50) characters";    
        Redirect_to("EditBook.php?id=$SearchQueryParameter");
    }elseif (empty($Content)) {
        $_SESSION["ErrorMessage"]= "Content of book cannot be empty";    
        Redirect_to("EditBook.php?id=$SearchQueryParameter");
    }else{    
      //=========================
      //query to executed if validation was successful
      global $ConnectingDB;
      if (!empty($_FILES["BookImage"]["name"])) {
      $sql = "UPDATE book 
              SET title='$BookTitle', author='$BookAuthor', category='$Category', bookimage='$BookImage', content='$Content'
              WHERE id='$SearchQueryParameter'";
      }else{
        $sql = "UPDATE book 
                SET title='$BookTitle', author='$BookAuthor', category='$Category', content='$Content'
                WHERE id='$SearchQueryParameter'";
      }
      //-----------------------
      
      $Execute =$ConnectingDB->query($sql);        
      //-----------------------       
      move_uploaded_file($_FILES["BookImage"]["tmp_name"],$Target);       
      if ($Execute) {
      $_SESSION["SuccessMessage"]="Book Updated Successfully";
      Redirect_to("Books.php");
      }else {
      $_SESSION["ErrorMessage"]="Error in Operation";
      Redirect_to("Books.php");
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
    <title>Edit Books</title>
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
                <a class="nav-link" href="#AddNewAdmin.php">Admins</a>
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
                <h1><i class="fa-solid fa-file-pen" style="color:#00FFF5;"></i> Edit Book</h1>
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
          //this variable get the id from the url          
          $sql = "SELECT * FROM book WHERE id='$SearchQueryParameter'";
          $stmt = $ConnectingDB->query($sql);
          while ($DataRows = $stmt->fetch()){
            $TitleToBeUpdated = $DataRows['title'];
            $AuthorToBeUpdate = $DataRows['author'];
            $CategoryToBeUpdated = $DataRows['category'];
            $ImageToBeUpdated = $DataRows['bookimage'];
            $ContentToBeUpdated = $DataRows['content'];        
          }
          ?>
        <form class="" action="EditBook.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
            <div class="card  bg-secondary text-dark mb-3">                
                <div class="card-body" style="background:#F3EFE0;">
                    <div class="form-group">
                        <label class="form-label" for="booktitle" style="font-weight:bold; font-size:17px"> Current Book Title</label>
                        <input class="form-control" type="text" name="BookTitle" id="booktitle" value="<?php echo $TitleToBeUpdated; ?>">
                    </div>  
                    <div class="form-group">
                        <label class="form-label" for="bookauthor" style="font-weight:bold; font-size:17px"> Current Author</label>
                        <input class="form-control" type="text" name="BookAuthor" id="bookauthor" value="<?php echo $AuthorToBeUpdate;?>">
                    </div> 
                    
                    <div class="form-group">
                    <label class="form-label pt-2" style="font-weight:bold; font-size:17px; color:#e4013e;">Current Category: <?php echo $CategoryToBeUpdated ?> </label>
                    <br>
                        <label class="form-label" for="CategoryTitle" style="font-weight:bold; font-size:17px"> Choose New Category</label>
                        <select class="form-select" id="CategoryTitle" name="Category">
                            <?php 
                            //fetching categories from category table
                            global $ConnectingDB; 
                            $sql = "SELECT id,title FROM category";
                            $stmt = $ConnectingDB->query($sql);
                            while ($DataRows = $stmt->fetch()) {
                                $Id = $DataRows["id"];
                                $CategoryName = $DataRows["title"];
                                                        
                            ?>
                            <option><?php echo $CategoryName ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                    <div class="form-group">
                    <label class="form-label mt-2" style="font-weight:bold; font-size:17px; color:#e4013e;">Current Book Photo:</label>
                    <div class="form-group">
                    <img class="pt-2" src="bookimages/<?php echo $ImageToBeUpdated; ?>" width="250px"; height="250px";>
                    </div>
                    <div class="input-group mt-3">                            
                            <input type="file" class="form-control" name="BookImage" id="ImageSelect" accept="image/png, image/jpg, image/jpeg">
                            <label class="input-group-text" for="ImageSelect">Choose New Picture</label>
                        </div>
                    </div>
                    <div class="form-floating mt-3">
                        <textarea class="form-control" placeholder="Content here" id="floatingTextarea2" name="Content" style="height: 200px"><?php echo $ContentToBeUpdated ?></textarea>
                        <label for="floatingTextarea2">Content</label> 
                    </div>
                    <div class="row">
                      <div class="d-grid gap-2 col-lg-6" style="padding:12px;">
                        <a href="Books.php" class="btn btn-warning" type="button"><i class="fa-solid fa-arrow-left-long"></i> Back</a>                        
                      </div>
                      <div class="d-grid gap-2 col-lg-6 btn" style="padding:12px;">
                        <button class="btn btn-success" type="submit" name="Submit"><i class="fa-solid fa-pen-to-square"></i> Update Book</button>                        
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

<?php 
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php'); 

  if(isset($_GET["id"])){
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $sql = "DELETE FROM admins WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
        $_SESSION["SuccessMessage"]="Administrator Deleted Successfully";
        Redirect_to("AddNewAdmin.php");
    }else{
        $_SESSION["ErrrorMessage"]="Something Went Wrong";
        Redirect_to("AddNewAdmin.php");
    }
  }
?>
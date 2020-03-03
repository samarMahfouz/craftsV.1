<?php
session_start();
if(isset($_SESSION['name'])){
  header('Location:index.php');
  exit();
}
$nonavbar = '';
$pageTitle = 'Login';
include 'init.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = filter_var(strip_tags($_POST['username']), FILTER_SANITIZE_STRING);
  $password = strip_tags($_POST['password']);
   $stmt = $con->prepare("SELECT
                            username, password
                         FROM
                               users
                        WHERE
                         username= ?
                        AND
                          password =?");
   $stmt->execute(array($username, $password));
   $row = $stmt->fetch();
   $count= $stmt->rowCount();
   if($count > 0) {
       $_SESSION['name'] = $username;

       header('Location:index.php');
       exit();
   }else{
     header('Location:login.php');
      exit();
    }
}
 ?>
    <div class="register">
      <div class="container">
                <form class="login" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                  <h2 class="text-center">login</h2>
                  <span class="text-center logg"><a href="signup.php"> don't have an accout signup now</a></span>
                  <div class="input-container">
                    <input class="form-control  pull-right"
                           type="text"
                           name="username"
                           placeholder="write your username"
                           required="required"/>
                  </div>
                  <div class="input-container">
                    <input type="password"
                           name="password"
                           class="form-control  pull-right"
                           placeholder="write your password"
                           required="required"/>
                   </div>
                   <div class="input-container">
                     <input type="submit"
                            class="btn btn-info btn-block"
                            value="Enter"/>
                    </div>
                    <span><a href="newpassword.php"> forget your password?!  </a></span>
                  </form>
      </div>
    </div>
<?php include $temps . 'footer.php';?>

<?php
session_start();
if(isset($_SESSION['email'])){
  header('Location:dashboard.php');
  exit();
}
$nonavbar = '';
$pageTitle = 'Login';
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = filter_var(strip_tags($_POST['email']), FILTER_SANITIZE_EMAIL);
  $password = strip_tags($_POST['password']);

   // STEP2 check if user exist in database
   $stmt = $con->prepare("SELECT
                            email, password
                         FROM
                               users
                        WHERE
                         email= ?
                        AND
                          password =?
                          AND
                           groupid = 1
                           LIMIT 1");
   $stmt->execute(array($email, $password));
   $row = $stmt->fetch();
   $count= $stmt->rowCount();


   if($count > 0) {
       $_SESSION['email'] = $email;
       header('Location:dashboard.php');
       exit();
   }else{
     header('Location:index.php');
      exit();
    }
}
 ?>
 <div class="login">
   <div class="container">
     <h2 class="text-center">login form</h2>
   <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
      <input type="email" name="email" class="form-control" placeholder="Write your Email">
    </div>
    <div class="form-group">
      <input type="password" name="password" class="form-control" placeholder="Write the password">
    </div>
    <button type="submit" class="btn btn-info">Enter</button>
  </form>
  </div>
</div>
<?php include $temps . 'footer.php'; ?>

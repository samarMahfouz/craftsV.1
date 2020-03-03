<?php
session_start();
if(isset($_SESSION['name'])){
  header('Location:index.php');
  exit();
}
$nonavbar = '';
$pageTitle = 'signup';
include 'init.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = filter_var(strip_tags($_POST['email']), FILTER_SANITIZE_EMAIL);
  $username = filter_var(strip_tags($_POST['username']), FILTER_SANITIZE_STRING);
  $password = strip_tags($_POST['password']);
   $stmt = $con->prepare("INSERT INTO
                             users(username, password, email)
                          VALUES(:zname, :zpass, :zemail)");
    $stmt->execute(array(
      'zname'  => $username,
      'zpass' => $password,
      'zemail'  => $email
    ));

    $theMsg =  '<div class="btn btn-success">welcome to my website   </div>';
    header('Location:index.php');
}
?>
    <div class="register">
      <div class="container">
                  <form class="signup" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <h2 class="text-center">signup</h2>
                    <span class="text-center signn "><a href="login.php"> have an accout login</a></span>
                    <div class="input-container">
                      <input class="form-control  pull-right"
                             type="email"
                             name="email"
                             placeholder="write your email"
                             required="required"/>
                    </div>
                    <div class="input-container">
                      <input class="form-control  pull-right"
                             type="text"
                             name="username"
                             placeholder="user name"
                             required="required"/>
                    </div>
                    <div class="input-container">
                      <input type="password"
                             name="password"
                             class="form-control  pull-right"
                             placeholder="write password"
                             required="required"/>
                     </div>
                     <div class="input-container">
                       <input type="submit"
                              class="btn btn-info btn-block"
                              value="Enter"/>
                      </div>
                    </form>
      </div>
    </div>
<?php include $temps . 'footer.php';?>

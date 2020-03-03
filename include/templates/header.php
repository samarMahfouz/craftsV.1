<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <!-- IE Compatibility meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- First mobile meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css"/>
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aref+Ruqaa&display=swap">
    <link rel="stylesheet" href="<?php echo $css; ?>style.css"/>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="wrapper">
    <!-- Start navbar -->
    <nav  class="sec">
      <div class="container">
        <section class="logo">
          <h2><a href="index.php">samar dünyası</a></h2>
        </section>
        <ul class="links">
          <li class="select"><a href="index.php">home</a></li>
          <li ><a data-value="design" href="items.php">designs</a></li>
            <?php
              if(isset($_SESSION['name'])){ // secure me please :)
                echo '<li>';
                  echo "<a href='' >welcome " . $_SESSION['name'] . "</a>";
                echo '</li>';
                echo '<li>';
                  echo '<a href="logout.php">logout</a>';
                echo '</li>';
            }else{
              echo '<li>';
              ?>
                <a  data-value="about" href="login.php">login/signup</a>
          <?php echo '</li>'; } ?>
        </ul>
        <div class="clearfix"></div>
      </div>
    </nav>
    <!-- End navbar -->

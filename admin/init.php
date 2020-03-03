<?php
  // ROUTES
  $temps = 'include/templates/';
  $funcs = 'include/functions/';


  // includes files
  include 'connect.php';
  include $funcs . 'functions.php';
  include $temps . 'header.php';
  if(isset($nonavbar)){
  }else{
    include $temps . 'navbar.php';
  }

<?php
/*
  *** page title function v1.0
  *** function to get the title of the page
  *** $pageTitle is the variable (include in every page)
  *** getTitle is the name of the function
  ***
*/
function getTitle() {
  global $pageTitle;
  if(isset($pageTitle)){
    echo  $pageTitle;
  }else{
    echo 'Default';
  }
}
function redirectTo($theMsg, $url= null, $s= 6) {
  if($url === null){
    $url = 'index.php';
    $link = 'homepage';
  }elseif($url === 'back'){
    if(isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER'] !== ''){
      $url = $_SERVER['HTTP_REFERER'];
      $link = 'Previous page';
    }else{
      $url = 'index.php';
      $link = 'Homepage';
    }
  }else{
    $url;
  }
  echo $theMsg;
  echo "<div class='alert alert-info'>you will be redirect to $url after $s seconds.</div>";
  header("refresh:$s; url = $url");
  exit();
}
/*
  *** check items function v1.0
  *** function to check items in database
  ***
  ***
  ***
*/
function checkItemsExist($item, $table, $iN) {
  global $con;
  $cIe = $con->prepare("SELECT $item FROM $table WHERE $item = ? ");
  $cIe->execute(array($iN));
  $count =  $cIe->rowCount();
  return $count;
}

/*
  *** Count number of rows function v1.0
  *** function to count number of rows
  *** i used it in dashboard to collect the items
  ***
  ***
*/
function countRows($rid, $table) {
  global $con;
  $cr = $con->prepare("SELECT COUNT($rid) FROM $table");
  $cr->execute();
  return $cr->fetchColumn();
}
function countRows2($num) {
  global $con;
  $cr = $con->prepare("SELECT COUNT(id) FROM items WHERE cat_id = $num;");
  $cr->execute();
  return $cr->fetchColumn();
}
function countColumn($m, $table, $fkey, $vs) {
  global $con;
  $stmt = $con->prepare("SELECT count($m) FROM $table WHERE $fkey = ?");
  $stmt->execute(array($vs));
  return $stmt->fetchColumn();
}
/*
  *** Get latest rows on database  function v1.0
  *** function to Get latest rows on database
  *** i used it in dashboard to get the latest comments the items
  ***
  ***
*/
function gLatest($select, $table, $order, $limit = 7) {
  global $con;
  $gl = $con->prepare("SELECT $select FROM  $table ORDER BY $order DESC LIMIT $limit");
  $gl->execute();
  $glr = $gl->fetchAll();
  return $glr;
}

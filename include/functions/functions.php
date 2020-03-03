<?php
function getTitle() {
  global $pageTitle;
  if(isset($pageTitle)){
    echo  $pageTitle;
  }else{
    echo 'Default';
  }
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

<?php
  function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
      echo $pageTitle;
    }else{
      echo lang('DEFAULT');
    }
  }

  //////////////////////////////////////////
  /**
   * Summary of checkItem
      check if item is exsist at database or not 
   */
  function checkItem($item, $table, $value){

    global $con;

    $st = $con->prepare("SELECT $item FROM $table WHERE $item=?");
    $st->execute([$value]);
    $r = $st->rowCount();
    return $r;
  }

  //////////////////////////////////////
  function count_items($field, $table){
    global $con;
    $stmt = $con->prepare("SELECT COUNT($field) FROM $table");
    $stmt->execute();
    $result = $stmt->fetchColumn();
    return $result;
  }

  function countPending(){
    global $con;
    $stmt = $con->prepare("SELECT COUNT('user_id') FROM users WHERE reg_status=0");
    $stmt->execute();
    $result = $stmt->fetchColumn();
    return $result;
  }

  /////////////////////////////////////

  function getLatest($feild, $table, $order, $limit = 5){
    global $con;
    $stmt = $con->prepare("SELECT $feild FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;

  }
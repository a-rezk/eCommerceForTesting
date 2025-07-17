<?php
  ob_start();
  session_start();
  $pageTitle = 'Categories';
  if(isset($_SESSION['username'])){
    include 'init.php'; 
  
    if($do == 'Manage'){ 

    }elseif($do == 'Add'){

    }elseif($do == 'Edit'){  
    
    }elseif($do == 'Update'){

    }elseif($do == 'delete'){
   
    }else{
      echo 'Error There\'s no page with this title';
    }
    include $tpl."footer.php";
  }else{

    header('location:index.php');
    exit();
  }
  ob_end_flush();
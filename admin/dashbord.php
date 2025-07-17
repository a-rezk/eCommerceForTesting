<?php
  session_start();
  $pageTitle = 'Dashboard';
  if(isset($_SESSION['full_name'])){
    include 'init.php';
    $latestUsers = 5;
    $users =  getLatest("full_name, user_id", "users", "user_id",$latestUsers ); 
    ?>

    <div class="container text-center home-stats">
      <h1>Dashboard</h1>
      <div class="row">
        <div class="col-md-3">
          <div class="stat">
            Total Members
            <span><a href="members.php"><?php echo count_items('user_id', "users");?></a></span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat">
            Pending Members
            <span><a href="members.php?page=pending"><?php echo countPending();?></a></span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat">
            Total Items
            <span>2000</span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat">
            Total Comments
            <span>2000</span>
          </div>
        </div>
      </div>
    </div>
    <div class="container latest">
      <div class="row">
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-users"></i> Latest <?php echo $latestUsers?> Registerd Users
            </div>
            <div class="panel-body">
              <?php  
                for($i = 0; $i < count($users); $i++){
                  echo $i+1 . " => " . "\"" . $users[$i]["full_name"] . "\"";?>
                  <br>
                  <a href="members.php?do=Edit&user_id=<?php echo $users[$i]['user_id']?>" class="btn btn-success">Edit</a>
                  <br> ------------------------------------------- <br> 
              <?php }
              ?>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-home"></i> Latest Items
            </div>
            <div class="panel-body">
              Test
            </div>
          </div>
        </div>
      </div>
    </div>


<?php
    include $tpl."footer.php";
  }else{

    header('location:index.php');
    exit();
  }
  


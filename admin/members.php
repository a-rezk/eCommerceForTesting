<?php
  ob_start();
  session_start();
  $pageTitle = 'Members';
  if(isset($_SESSION['username'])){
    include 'init.php'; 
  
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == 'Manage'){?>

      <h1 class="text-center">Manage Members</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table table table-bordered text-center">
            <tr class="text-center">
              <th>#ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Full Name</th>
              <th>Regsitered Date</th>
              <th>Control</th>
            </tr>
<?php 
          $q = '';
          if(isset($_GET['page']) && $_GET['page'] == 'pending'){
            $q='AND reg_status=0';
          }
          $stmt = $con->prepare("SELECT * FROM users WHERE group_id!=1 $q");
          $stmt->execute();
          while($raw = $stmt->fetch()){?>
          <center>
            <tr>
              <td><?php echo $raw['user_id']?></td>
              <td><?php echo $raw['username']?></td>
              <td><?php echo $raw['email']?></td>
              <td><?php echo $raw['full_name']?></td>
              <td><?php echo $raw['date']?></td>
              <td>
<?php       if($raw['reg_status'] == 0){?>
              <a href="members.php?do=pending&user_id=<?php echo $raw['user_id']?>" class="btn btn-primary">Active</a>
              <a href="members.php?do=delete&user_id=<?php echo $raw['user_id']?>" class="btn btn-danger">Delete</a>

<?php       }else{ ?>
              <a href="members.php?do=Edit&user_id=<?php echo $raw['user_id']?>" class="btn btn-success">Edit</a>
              <a href="members.php?do=delete&user_id=<?php echo $raw['user_id']?>" class="btn btn-danger">Delete</a>
<?php } ?>
              </td>
            </tr>
          </center>
<?php
          }       
?>
          </table>
        </div>
        <a class="btn btn-primary" href="members.php?do=Add"><i class="fa fa-plus"></i>Add New Member</a>
      </div>
<?php   
    }elseif($do == 'Add'){
?>
      <h1 class="text-center">Add Member</h1>
      <div class="container">
        <form action="" class="form-horizontal" method="POST">
          <div class="form-group form-group-lg">
            <label for="" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="username" class="form-control" autocomplete="off" required="required">
            </div>
          </div>
          
          <div class="form-group form-group-lg">
            <label for="" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-4">
              <input type="password" name="password" class="form-control" autocomplete="new-password " required="required">
            </div>
          </div>
          
          <div class="form-group form-group-lg">
            <label for="" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-4">
              <input type="email" name="email" class="form-control "required="required" >
            </div>
          </div>
          
          <div class="form-group form-group-lg">
            <label for="" class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="full_name" class="form-control " required="required">
            </div>
          </div>
          
          <div>
            <label >Group ID</label>
              <select name="group_id" id="">
                <option value="0">0</option>
                <option value="1">1</option>
              </select>
            </div>
          
          <div>
            <label >Seller Status</label>
              <select name="seller_status" id="">
                <option value="0">0</option>
                <option value="1">1</option>
              </select>
            </div>
          
          <div class="form-group">
            <div class="col-sm-10 col-md-4">
              <input type="submit" value="Save" class="btn btn-primary btn-lg">
            </div>
          </div>
        </form>
      </div>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(!empty($_POST['username']) && 
        !empty($_POST['password']) && 
        !empty($_POST['email']) &&
        !empty($_POST['full_name'])){
          $userName = $_POST['username'];
          $password = sha1($_POST['password']);
          $email = $_POST['email'];
          $fullname = $_POST['full_name'];
          $groupID = $_POST['group_id'];
          $seller_status = $_POST['seller_status'];

          if(checkItem('username', 'users', $userName) == 1 || checkItem('email', 'users', $email) == 1){
            echo 'sorry something wrong';
          }else{
            $stmt = $con->prepare('INSERT INTO users
            (username, password, email, full_name, group_id, seller_status, reg_status, date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$userName, $password, $email, $fullname, $groupID, $seller_status, 1, date("Y-m-d H-i-s")]);
            header('location: members.php');
            exit();
          }

        }
    }
    }elseif($do == 'Edit'){  
    $userid = isset($_GET['user_id']) && is_numeric($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    $stmt = $con->prepare('SELECT * FROM users WHERE user_id=? LIMIT 1');
    $stmt->execute([$userid]);
    $raw = $stmt->fetch();
    $count = $stmt->rowCount(); 
   
    if($count > 0){
?>
      <h1 class="text-center">Edit Member</h1>
      <div class="container">
        <form action="members.php?do=Update" class="form-horizontal" method="POST">
          <input type="hidden" value="<?php echo $userid?>" name="userid">
          <div class="form-group form-group-lg">
            <label for="" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="username" value="<?= $raw['username']?>" class="form-control" autocomplete="off" required="required">
            </div>
          </div>
          
          <div class="form-group form-group-lg">
            <label for="" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-4">
              <input type="hidden" name="oldpassword" value="<?php echo $raw['password']?>">
              <input type="password" name="newpassword" class="form-control" autocomplete="new-password ">
            </div>
          </div>
          
          <div class="form-group form-group-lg">
            <label for="" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-4">
              <input type="email" value="<?= $raw['email']?>" name="email" class="form-control "required="required" >
            </div>
          </div>
          
          <div class="form-group form-group-lg">
            <label for="" class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-10 col-md-4">
              <input type="text" name="full_name" value="<?= $raw['full_name']?>" class="form-control " required="required">
            </div>

          <div class="form-group">
            <div class="col-sm-10 col-md-4">
              <input type="submit" value="Save" class="btn btn-primary btn-lg">
              <a href="members.php?do=un-act&user_id=<?php echo $raw['user_id']?>" class="btn btn-danger btn-lg">UN-Active</a>
              <button></button>
            </div>
          </div>
        </form>
      </div>
<?php
    }else{
      echo'there is no such id';
    }
    }elseif($do == 'Update'){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $userID = $_POST['userid'];
      $userName = $_POST['username'];
      $email = $_POST['email'];
      $fullName = $_POST['full_name'];
      $_SESSION['full_name'] = $fullName;
            // if(isset($_POST['password']) && strlen($_POST['password']) > 5){
            //   $stmt = $con->prepare('UPDATE users SET password=? WHERE user_id=?');
            //   $stmt->execute([$newpassword, $userID]);
            // }  
      $newpassword = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

      $errors = [];

      if(empty(filter_var($email, FILTER_VALIDATE_EMAIL))){
        $errors[] = 'Email Not Valid';
      }
      if(empty($userName) || strlen($userName) < 4){
        $errors[] = 'Username Not Valid';
      }

      foreach($errors as $e){
        echo $e . '<br>';
      }
      if(count($errors)){
        echo 'Faild';
      }else{
        $stmt = $con->prepare('UPDATE users SET username = ?, email = ?, full_name = ?, password=? WHERE user_id = ?');
        $stmt->execute([$userName, $email, $fullName, $newpassword, $userID]);
      }
      
    }else{
      echo 'you can not browse this page';
    }

    echo 'Done';

    }elseif($do == 'delete'){
        $user_id = $_GET['user_id'];
        $stmt = $con->prepare('DELETE FROM users WHERE user_id=?');
        $stmt->execute([$user_id]);
        header('location:members.php');
    }elseif($do == 'pending'){
      $user_id = $_GET['user_id'];
      $stmt = $con->prepare("UPDATE users SET reg_status=1 WHERE user_id=?");
      $stmt->execute([$user_id]);
      header('location:members.php?do=Manage');
      exit();
    }elseif($do == 'un-act'){
      $user_id = $_GET['user_id'];
      $stmt = $con->prepare("UPDATE users SET reg_status=0 WHERE user_id=?");
      $stmt->execute([$user_id]);
      header('location:members.php?do=Manage');
      exit();
    }else{
      echo 'Error There\'s no page with this title';
    }
    include $tpl."footer.php";
  }else{

    header('location:index.php');
    exit();
  }
  ob_end_flush();
  ?>
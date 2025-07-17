<?php 
  $noNav = '';
  $pageTitle = 'Login';
  session_start();
  if(isset($_SESSION['username'])){
    header('location:dashbord.php');

  }
  include 'init.php';

  if($_SERVER['REQUEST_METHOD'] === "POST"){

    $username = $_POST['username'];
    $hashedpass = sha1($_POST['pass']);

    $stmt = $con->prepare('SELECT username, password, user_id, full_name FROM users WHERE username=? AND password=? AND group_id=1 LIMIT 1');
    $stmt->execute([$username, $hashedpass]);
    $raw = $stmt->fetch();
    $count = $stmt->rowCount();

    if($count>0){
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $raw['user_id'];
      $_SESSION['full_name'] = $raw['full_name'];
      header('location:dashbord.php');
      exit();
    }
  }

?>
<center>
  <form class="login" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
        <label class="form-label">Admin Login</label>
        <input name="username" type="text" class="form-control" placeholder="Username">
        <input name="pass" type="password" class="form-control" placeholder="Password">
        <button name="login" type="submit" class="btn btn-primary btn-block">Login</button>
  </form>
</center>

<?php 
  include $tpl."footer.php"
?>
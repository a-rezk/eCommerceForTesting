<?php
  ob_start();
  session_start();
  $pageTitle = 'Categories';
  if(isset($_SESSION['username'])){
    include 'init.php'; 
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    if($do == 'Manage'){ 
        $sort = 'ASC';
        $sort_arr = ['ASC', 'DESC'];
        if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_arr)){
          $sort = $_GET['sort'];
        }
        $stmt = $con->prepare("SELECT * FROM categories ORDER BY ordering $sort");
        $stmt->execute();
        // $raw = $stmt->fetchAll();
        // print_r($raw);
      ?>
      <h1 class="text-center">Manage Categories</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table table table-bordered text-center">
            <tr class="text-center">
              <th>#</th>
              <th>Category Name</th>
              <th>description</th>
              <th>Visibility</th>
              <th>Comments</th>
              <th>Ads</th>
              <th>Control</th>
              Sort BY : 
              <a href="?sort=ASC" class="btn btn-primary btn-sm"> ASC </a>
              |
              <a href="?sort=DESC" class="btn btn-primary btn-sm"> DESC</a>
            </tr>
<?php  
          while($raw = $stmt->fetch()){?>
          <center>
            <tr>
              <td><?php echo $raw['ordering']?></td>
              <td><?php echo $raw['category']?></td>
              <td><?php echo $raw['description']?></td>
              <td><?php $raw['visibility'] == 0 ? $x = "Yes" : $x = "No";echo $x;?></td>
              <td><?php $raw['allow_comment'] == 0 ? $x = "Yes" : $x = "No";echo $x;?></td>
              <td><?php $raw['allow_ads'] == 0 ? $x = "Yes" : $x = "No";echo $x;?></td>
              <td> 
                <a href="categories.php?do=edit&id=<?php echo $raw['id']?>" class="btn btn-success">Edit</a>
                <a href="categories.php?do=delete&id=<?php echo $raw['id']?>" class="btn btn-danger">Delete</a>
              </td>
            </tr>
          </center>
<?php
          }       
?>
          </table>
        </div>
        <a class="btn btn-primary" href="categories.php?do=add"><i class="fa fa-plus"></i>Add New Category</a>
      </div>
<?php
    }elseif($do == 'add'){
?>    <h1 class="text-center">Add Category</h1>
      <div class="container">
        <form action="" class="form-horizontal" method="POST">
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Category Name</label>
          <div class="col-sm-10 col-md-4">
          <input type="text" name="category" class="form-control" autocomplete="off" required="required">
          </div>
        </div>

        <div class="form-group form-group-lg">
          <label for="" class="col-sm-2 control-label">Description</label>
          <div class="col-sm-10 col-md-4">
          <input type="text" name="description" class="form-control" autocomplete="off" required="required">
          </div>
        </div>

        <div class="form-group form-group-lg">
          <label for="" class="col-sm-2 control-label">Ordering</label>
          <div class="col-sm-10 col-md-4">
          <input type="number" name="ordering" class="form-control" autocomplete="off" required="required">
          </div>
        </div>
    
    <div>
      <label >visibility</label>
        <select name="visibility" id="">
          <option value="0">Yes</option>
          <option value="1">No</option>
        </select>
      </div>
    
    <div>
      <label >allow_comment</label>
        <select name="allow_comment" id="">
          <option value="0">Yes</option>
          <option value="1">No</option>
        </select>
      </div>

    <div>
      <label >allow_ads</label>
        <select name="allow_ads" id="">
        <option value="0">Yes</option>
        <option value="1">No</option>
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
    if(!empty($_POST['category']) && 
    !empty($_POST['description']) && 
    !empty($_POST['ordering'])){
    $category = $_POST['category'];
    $description = $_POST['description'];
    $ordering = $_POST['ordering'];
    $visibility = $_POST['visibility'];
    $allow_comment = $_POST['allow_comment'];
    $allow_ads = $_POST['allow_ads'];

    if(checkItem('category', 'categories', $category) == 1){
      echo 'sorry something wrong';
    }else{
      $stmt = $con->prepare('INSERT INTO categories
      (category, description, ordering, visibility, allow_comment, allow_ads, date)
      VALUES (?, ?, ?, ?, ?, ?, ?)');
      $stmt->execute([$category, $description, $ordering, $visibility, $allow_comment, $allow_ads, date("Y-m-d H-i-s")]);
      header('location: categories.php');
      exit();
    }

  }
}

    }elseif($do == 'edit'){  
    
    }elseif($do == 'update'){

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
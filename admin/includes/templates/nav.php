<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashbord.php"><?= lang('HOME-ADMIN')?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?= lang('CATEGORIES')?></a></li>
        <li><a href=""><?= lang('ITEMS')?></a></li>
        <li><a href="members.php"><?= lang('MEMBERS')?></a></li>
        <li><a href=""><?= lang('STATISTICS')?></a></li>
        <li><a href=""><?= lang('LOGS')?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['full_name']?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=Edit&user_id=<?= $_SESSION['user_id']?>"><?= lang('EDIT-PROFILE')?></a></li>
            <li><a href="#"><?= lang('SETTINGS')?></a></li>
            <li><a href="logout.php"><?= lang('LOGOUT')?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
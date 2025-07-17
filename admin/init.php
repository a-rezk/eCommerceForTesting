<?php

  // Connect to database //
  include "connect.php";
  
  //  routes // 

  $tpl = 'includes/templates/';
  $css = 'layout/css/';
  $js = 'layout/js/';
  $func = 'includes/func/';
  $libs = 'includes/libs/';
  $langs = 'includes/langs/';

  include $func . 'function.php';
  include $langs.'english.php';
  include $tpl.'header.php';

  if(!isset($noNav)) include 'includes/templates/nav.php';

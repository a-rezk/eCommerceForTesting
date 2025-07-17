<?php

  function lang ($phrase){
    static $lang = array(
      //Nav Bar Words
      "HOME-ADMIN"     => "Home",
      "CATEGORIES"     => "Categories",
      'EDIT-PROFILE'   =>'Edit Profile',
      'SETTINGS'       =>'Settings',
      'LOGOUT'         =>'Logout',
      'ITEMS'          =>'Items',
      'MEMBERS'        =>'Members',
      'STATISTICS'     =>'Statistics',
      'LOGS'           =>'Logs',
      
      //Functions
      'DEFAULT'        =>'Default',
    );
    return $lang[$phrase];
  }
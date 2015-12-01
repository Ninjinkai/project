<?php
  require_once 'db_connect.php';
  require_once 'functions.php';

  if (isset($_POST['user']))
  {
    $user   = sanitizeString($db, $_POST['user']);
    $result = queryMysql("SELECT * FROM USERS WHERE userid='$user'");

    if ($result->num_rows)
      echo "That username already exists.";
    else
      echo "That username is available.";
  }
?>
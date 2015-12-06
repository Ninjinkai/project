<?php
  require_once 'db_connect.php';
  require_once 'functions.php';

// Called when a user enters a character into the sign up form.
// Checks the database for the input username and informs availability.
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
<?php

// Use session to determine if user is signed in.
  session_start();

// Begining HTML header.
  echo "<!DOCTYPE html>\n<html>\n<head>\n";

// Connect to database and establish backend control functions.
  require_once 'php/functions.php';

  $userstr = ' (Guest)';

// Check if user is signed in.
  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;
?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="photo sharing php COP3813 Nick Petty homework 8">
  <meta name="author" content="Nick Petty">
  <link rel="icon" href="icons/favicon.ico">
<?php
echo "  <title>$appname</title>\n";
?>
  <!-- Stylesheets -->
  <link rel='stylesheet' href='css/bootstrap.css' type='text/css'>
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel='stylesheet' href='css/signin.css' type='text/css'>
  <link rel='stylesheet' href='css/styles.css' type='text/css'>
  <!-- Javascript -->
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <div class="container">
<?php
// Check if user is signed in.  Sign them out if they are, otherwise direct to index.
  if (isset($_SESSION['user']))
  {
    destroySession();
// Show sign out confirmation, direct to index.
    echo "<div class='main container'>You have been signed out. Please <a href='index.php'>click here</a> to return to the welcome screen.";
  }
  else
  {
// If a user reaches this page without being signed in, they are directed to the index.
    echo "<div class='main container'>You cannot sign out because you are not signed in. Please <a href='index.php'>click here</a> to sign in or sign up.";
  }

  $db->close();
?>
      </div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

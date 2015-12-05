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
    <form id="primaryForm" class="form-signin">
<?php      
  echo "<h2 class=\"form-signin-heading\">Welcome to $appname</h2>\n";

// Users that are signed in can sign out or go to the wall, otherwise they can sign in or sign up.
  if ($loggedin)
  {
echo <<<_END
      <h3 class="form-signin-heading">$user is signed in.</p>
      <a id="appNameBtn" class="btn btn-lg btn-primary btn-block" href="wall.php" role="button">View Wall</a>
      <a id="signOutBtn" class="btn btn-lg btn-primary btn-block" href="logout.php" role="button">Sign out</a>
_END;
  }
  else
  {
echo <<<_END
      <a id="appNameBtn" class="btn btn-lg btn-primary btn-block" href="wall.php" role="button">View Wall</a>
      <a id="signUpBtn" class="btn btn-lg btn-primary btn-block" href="signup.php" role="button">Sign up</a>
      <a id="signInBtn" class="btn btn-lg btn-primary btn-block" href="signin.php" role="button">Sign in</a>
_END;
  }
?>
    </form>
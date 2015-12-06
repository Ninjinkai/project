<?php
    require_once "php/functions.php";

    session_start();

    $userstr = ' (Guest)';

// Check if user is signed in.
    if (isset($_SESSION['user']))
    {
        $user     = $_SESSION['user'];
        $loggedin = TRUE;
        $userstr  = " ($user)";
    }
    else $loggedin = FALSE;

// If the user is not signed in, they are redirected to the sign in/up form.
    if(!$loggedin)
    {
        header('Location: index.php');
    exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="COP3813 Homework 8 PHP Photo Sharing App Nick Petty">
    <meta name="author" content="Nick Petty">
    <link rel="icon" href="icons/favicon.ico">
<?php
    echo "    <title>$appname</title>\n";
?>
    <!-- CSS links. -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/jumbotron.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<?php
echo <<<_END
<!-- Navigation bar. -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <p class="navbar-brand">$appname</p>
            </div>
            <ul class="nav nav-pills">
                <li role="presentation" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">$user
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="wall.php">View wall</a></li>
                        <li><a href="form.php">Post pic</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="logout.php">Sign out</a></li>
                    </ul>
                </li>
            </ul>
    </nav>
<!-- Page content. -->
    <div class="container">    
        <div class="row">
            <div id="formParent" class="col-md-6 col-md-offset-3">
                <form id="form" class="form-horizontal" method="POST" action="reset.php">
                    <div class="form-group">
                        <label for="oldPassword" class="control-label col-xs-6">Old password</label>
                        <div class="col-xs-6">
                            <div class="input-group">
                                <input type="password" class="form-control" id="oldPassword" name="oldPassword" 
                            maxlength="16" size="16" required placeholder="16 characters" autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newPassword" class="control-label col-xs-6">New password</label>
                        <div class="col-xs-6">
                            <div class="input-group">
                                <input type="password" class="form-control" id="newPassword" name="newPassword" 
                            maxlength="16" size="16" required placeholder="16 characters">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" value="Reset Password" class="btn btn-lg btn-primary">
                    </div>
                </form>
                <hr>
                <form id="form" class="form-horizontal" method="POST" action="delete.php">
                    <div class="text-center">
                        <h4>Permanently delete your account from $appname.<br>Your posts will not be deleted.</h4>
                        <input type="submit" value="Delete account" class="btn btn-lg btn-danger">
                    </div>
                </form>
            </div>
        </div>
    </div>
_END;

$db->close();
?>
    <!-- JavaScript placed at bottom for faster page loadtimes. -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
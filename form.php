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
echo "<title>$appname</title>\n";
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
                        <li><a href="account.php">Account</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="logout.php">Sign out</a></li>
                    </ul>
                </li>
            </ul>
    </nav>
_END;
?>
    <!-- Photo upload form. -->
	<div class="container">    
		<div class="row">
			<div id="formParent" class="col-md-6 col-md-offset-3">
				<form id="form" class="form-horizontal" method="POST" action="wall.php" enctype="multipart/form-data">
                    <!-- Input for poster's name.  Default with user name, but can be edited, up to 16 characters. -->
                    <div class="form-group">
                        <label for="name" class="control-label col-xs-1">Name</label>
                        <div class="col-xs-11">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-user fa-fw"></span></span>
                                <input type="text" class="form-control" id="name" name="name" 
                            maxlength="16" size="16" value="<?php echo $user ?>" required>
                            </div>
                        </div>
                    </div>
                    <!-- Input for post title.  The database allows 140 characters, but we limit to 20 here. -->
                    <div class="form-group">
                        <label for="title" class="control-label col-xs-1">Title</label>
                        <div class="col-xs-11">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-header fa-fw"></span></span>
                                <input type="text" class="form-control" id="title" name="title" 
                            maxlength="20" size="20" value="" required placeholder="20 characters" autofocus>
                            </div>
                        </div>
                    </div>
                    <!-- The post text, limited to 140 characters. -->
                    <div class="form-group">
                        <label for="text" class="control-label col-xs-1">Text</label>
                        <div class="col-xs-11">
                            <textarea class="form-control" id="text" name="text" maxlength="140" placeholder="140 characters" required></textarea>
                        </div>
                    </div>
                    <!-- Shows a placeholder image, then the uploaded image with filters applied. -->
                    <div class="form-group">
                        <label class="sr-only" for="image">Original Image</label>
                        <img id="image" name="image" alt="picture.png" src="icons/picture.png">
                        <input type="file" id="upload" name="upload" accept="image/*" required>
                    </div>
                    <!-- Filter selection. When one is clicked, the preview image is updated. -->
                    <div class="form-group">
                        <h3>Filter Photo</h3>
                        <div class="checkbox-inline">
                            <label for="myNostalgia">My Nostalgia</label>
                            <input type="radio" name="filter" id="myNostalgia" value="myNostalgia" onclick="applyMyNostalgiaFilter();">
                        </div>
                        <div class="checkbox-inline">
                            <label for="grayscale">Grayscale</label>
                            <input type="radio" name="filter" id="grayscale" value="grayscale" onclick="applyGrayscaleFilter();">
                        </div>
                        <div class="checkbox-inline">
                            <label for="invert">Invert</label>
                            <input type="radio" name="filter" id="invert" value="invert" onclick="applyInvertFilter();">
                        </div>
                        <div class="checkbox-inline">
                            <label for="original">Revert to Original</label>
                            <input type="radio" name="filter" id="lomo" value="lomo" onclick="revertToOriginal();">
                        </div>
                    </div>
                    <!-- Form submission and reset buttons. Reset reloads the page. -->
                    <input type="submit" value="Upload image" class="btn btn-lg btn-primary col-md-offset-1">
                    <input type="button" id="resetForm" value="Reset form" class="btn btn-lg btn-default" onclick="location.reload(true);">
				</form>
			</div>
		</div>
	</div>
<?php $db->close(); ?>
	<!-- JavaScript placed at bottom for faster page loadtimes. -->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	<script src="functions.js"></script>
</body>
</html>
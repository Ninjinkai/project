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

// Handle form post.
    if(isset($_POST['title']) && isset($_POST['text']))
    {
        // Sanitze inputs.
        $title = sanitizeString($db, $_POST['title']);
        $text = sanitizeString($db, $_POST['text']);

        // Name the file with current timestamp.
        $time = $_SERVER['REQUEST_TIME'];
    	$file_name = $time . '.jpg';

        // Get filter setting.
        if (isset($_POST['filter']))
        {
            $filter = $_POST['filter'];
        }
        else
        {
            $filter = "NULL";
        }

        // Get image file, upload to 'users' folder.
        if ($_FILES)
        {
            $tmp_name = $_FILES['upload'][$user];
            $dstFolder = 'users';
            move_uploaded_file($_FILES['upload']['tmp_name'], $dstFolder . DIRECTORY_SEPARATOR . $file_name);
        }

        // Input post data to table.
        SavePostToDB($db, $user, $title, $text, $time, $file_name, $filter);

        // Prevent duplicate submissions on page refresh.
        header("Location: wall.php");
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

// If the user is not signed in, this will be the username.
if ($user == "")
{
    $user = "Not signed in";
}

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
                        <li><a href="form.php">Post pic</a></li>
                        <li><a href="account.php">Account</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="logout.php">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
_END;
?>
    <!-- Photo wall, generated by php script and SQL queries. -->
    <div class="container">
        <?php echo getPostcards($db); ?>
    </div>
<?php $db->close(); ?>
    <!-- JavaScript placed at bottom for faster page loadtimes. -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
<?php
require_once 'db_connect.php';

// The app can be renamed through this variable.
  $appname = "WallPics";

// Sanitizes the username and password strings to prevent injection attacks.
function sanitizeString($_db, $str)
{
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return mysqli_real_escape_string($_db, $str);
}

// Converts a photo upload form into a SQL query and executes it.  Returns error statement if failure.
function SavePostToDB($_db, $_user, $_title, $_text, $_time, $_file_name, $_filter)
{
	/* Prepared statement, stage 1: prepare query */
	if (!($stmt = $_db->prepare("INSERT INTO WALL(USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, FILTER) VALUES (?, ?, ?, ?, ?, ?)")))
	{
		echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
	}

	/* Prepared statement, stage 2: bind parameters*/
	if (!$stmt->bind_param('ssssss', $_user, $_title, $_text, $_time, $_file_name, $_filter))
	{
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	/* Prepared statement, stage 3: execute*/
	if (!$stmt->execute())
	{
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
}

// Reads database table and 'users' folder, then populates wall with data and images.
function getPostcards($_db)
{
    $query = "SELECT USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, FILTER FROM WALL ORDER BY TIME_STAMP DESC";
    
    if(!$result = $_db->query($query))
    {
        die('There was an error running the query [' . $_db->error . ']');
    }
    
    // Iterate through rows returned by table query, inserting them into HTML.
    $output = '';
    while($row = $result->fetch_assoc())
    {
        // Output posted date in a readable format.
        $postDate = date('F j, Y, g:i a T', $row['TIME_STAMP']);

        // Creates a single post from image and text.  Because ' is escaped with \' in the database, it is changed back here.
        $output = $output . '<div class="panel panel-default"><div class="panel-heading">"'
        . str_replace("\'", "'", $row['STATUS_TITLE'])
        . '" posted by ' . str_replace("\'", "'", $row['USER_USERNAME']) . '</div>'
        . '<div class="row"><div class="col-md-5">'
        . '<img class="img-responsive center-block w400 '. $row['FILTER'] . '" src="' . $server_root
        . 'users/' . $row['IMAGE_NAME'] . '" alt="' . $row['IMAGE_NAME'] . '"></div>'
        . '<div class="col-md-7"><br><p>' . str_replace("\'", "'", $row['STATUS_TEXT']) . '</p><hr><p>' . $postDate . '</p>'
        . '</div></div></div>' ;
    }
    
    return $output;
}

// Runs a MySQL query and returns results or an error message.
function queryMysql($query)
{
    global $db;
    $result = $db->query($query);
    if (!$result) die($db->error);
    return $result;
}

// Ends the signed in session.
function destroySession()
{
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}
?>
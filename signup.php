<?php
  require_once 'header.php';

  $error = $user = $pass = "";

// When form is submitted, sanitize inputs and check for validity.
  if (isset($_POST['user']))
  {
    $user = sanitizeString($db, $_POST['user']);
    $pass = sanitizeString($db, $_POST['pass']);

    if ($user == "" || $pass == "")
      $error = "Not all fields were entered<br><br>";
    else
    {
      $result = queryMysql("SELECT * FROM USERS WHERE userid='$user'");

      if ($result->num_rows)
        $error = "That username already exists<br><br>";
      else
      {
// Salt and hash passwords before adding to database.
        $salt1 = "2Qs0r@";
        $salt2 = "J0n@$";
        $token = hash('ripemd128', "$salt1$pass$salt2");

        queryMysql("INSERT INTO USERS VALUES('$user', '$token')");
// Clear forms and present sign in link.
        echo "<script>$(\"#primaryForm\").remove();</script>";
        die("<h4>Account created</h4>Please <a href='index.php'>sign in.</a><br><br>");
      }
    }
  }

// Remove top sign up button, present sign up form.
  echo <<<_END
    <script>
      $("#signUpBtn").remove();
    </script>
    <form class='form-signin' method='post' action='signup.php'>
      <div class='main'><h3>Please enter your details to sign up</h3>
        <input class="wideInput" type='text' maxlength='16' name='user' value='$user' placeholder='Username' required autofocus><br>
        <input class="wideInput" type='password' maxlength='16' name='pass' value='$pass' placeholder='Password' required><br>
        $error<br>
        <input class="btn btn-lg btn-primary btn-block" type='submit' value='Sign up'>
      </div>
    </form>
_END;

  $db->close();
?>
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
<?php
  require_once 'header.php';

  $error = $user = $pass = "";

// When form is submitted, sanitize inputs and check for validity.
  if (isset($_POST['user']))
  {
    $user = sanitizeString($db, $_POST['user']);
    $pass = sanitizeString($db, $_POST['pass']);
    
    if ($user == "" || $pass == "")
        $error = "Not all fields were entered<br>";
    else
    {
// Salt and hash passwords before adding to database.
      $salt1 = "2Qs0r@";
      $salt2 = "J0n@$";
      $token = hash('ripemd128', "$salt1$pass$salt2");

      $result = queryMySQL("SELECT userid,password FROM USERS
        WHERE userid='$user' AND password='$token'");

      if ($result->num_rows == 0)
      {
        $error = "<span class='error'>Username/Password
                  invalid</span><br>";
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
// Clear forms and present link to main app page.
        echo "<script>$(\"#primaryForm\").remove();</script>";
        die("You are now signed in. Please <a href='wall.php'>" .
            "click here</a> to continue.<br>");
      }
    }
  }

// Remove top sign in button, present sign in form.
  echo <<<_END
    <script>
      $("#signInBtn").remove();
    </script>
    <form class='form-signin' method='post' action='signin.php'>
      <div class='main'><h3>Please enter your details to sign in</h3>
        <input class="wideInput" type='text' maxlength='16' name='user' value='$user' placeholder='Username' required autofocus><br>
        <input class="wideInput" type='password' maxlength='16' name='pass' value='$pass' placeholder='Password' required><br>
        $error
        <input class="btn btn-lg btn-primary btn-block" type='submit' value='Sign in'>
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

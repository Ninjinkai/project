<?php
  require_once 'header.php';

echo <<<_END
  <script>
    function checkUser(user)
    {
      // Initialize the output element.
      if (user.value == '')
      {
        $("#info").text('')
        return
      }

      // Set up and execute the Ajax request.
      params  = "user=" + user.value
      request = new ajaxRequest()
      request.open("POST", "php/checkuser.php", true)
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      // removed bad setRequestHeader methods here

      // Display results of Ajax request.
      request.onreadystatechange = function()
      {
        if (this.readyState == 4)
          if (this.status == 200)
            if (this.responseText != null)
              $("#info").text(this.responseText)
      }
      request.send(params)
    }
    
    function ajaxRequest()
    {
      try { var request = new XMLHttpRequest() }
      catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
          try { request = new ActiveXObject("Microsoft.XMLHTTP") }
          catch(e3) {
            request = false
      } } }
      return request
    }
  </script>
_END;

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
      $result = queryMysql("SELECT * FROM USERS WHERE userid='$user'");

      if ($result->num_rows)
        $error = "That username already exists<br>";
      else
      {
// Salt and hash passwords before adding to database.
        $salt1 = "2Qs0r@";
        $salt2 = "J0n@$";
        $token = hash('ripemd128', "$salt1$pass$salt2");

        queryMysql("INSERT INTO USERS VALUES('$user', '$token')");
// Clear forms and present sign in link.
        echo "<script>$(\"#primaryForm\").remove();</script>";
        die("<h4>Account created</h4>Please <a href='signin.php'>sign in.</a><br>");
      }
    }
  }

// Remove top sign up button, present sign up form.
// The Ajax script is called when a character is typed into the username field.
echo <<<_END
    <script>
      $("#signUpBtn").remove();
    </script>
    <form class='form-signin' method='post' action='signup.php'>
      <div class='main'><h3>Please enter your details to sign up</h3>
        <input class="wideInput" type='text' maxlength='16' name='user' value='$user' placeholder='Username' required autofocus onkeyup='checkUser(this)'>
        <br>
        <input class="wideInput" type='password' maxlength='16' name='pass' value='$pass' placeholder='Password' required>
        <br>
        <span id='info'></span>
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
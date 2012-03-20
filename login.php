<?php

session_start();
if(isset($_SESSION['user'])) {
	header('Location: /');
}

?>

<html>
  <head>		
    <script 
      type="text/javascript" 
      src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js">
    </script>
    <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/js/login.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/master.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">

    <!-- Google Analytics Code -->
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-18888523-4']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </head>
	<body>
		<div class="container">
      <div class="page-header">
        <h1>schedulr</h1>
      </div>
      <div class="hidden well" id="signup_message">
        Looks like you don't have an account. Sign up by re-entering your password
      </div>
			<form 
        id="login_form" 
        action="/lib/forms/loginprocessor.php" 
        onsubmit="return submitLogin();" 
        class="well"
        method="POST">
        <div>
          If you are new here, enter your uniqname, and the password you would like to use for this site.<br/>
          DO NOT use your kerberos password!
        </div>
        <br/>
				<div><input id="uniqname" type="text" name="uniqname" placeholder="Uniqname"></div>
				<div><input id="password" type="password" name="password" placeholder="Password"></div>
        <div><input 
          class="hidden"
          id="password2" 
          type="password" 
          name="password2" 
          placeholder="Re-enter Password"></div>
				<button type="submit" class="btn btn-primary">Log In</button>
        <input id="submit_type" type="hidden" name="submit_type" value="login">
			</form>
		</div>
	</body>
</html>

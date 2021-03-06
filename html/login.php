<?php

session_start();
if(isset($_SESSION['user'])) {
  header('Location: /');
}

?>

<!DOCTYPE html>
<html>
  <head>    
    <script 
      type="text/javascript" 
      src="http://code.jquery.com/jquery-latest.min.js">
    </script>
    <script type="text/javascript" src="/assets/js/login.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/master.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/login.css">
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
        Looks like you don't have an account. Sign up by re-entering your password. 
        <a href="#" onclick="removeSignup()">Not true, I just mistyped my uniqname</a>
      </div>
      <div class="well login-form-small">
        <form 
          id="login_form" 
          action="/lib/forms/loginprocessor.php" 
          onsubmit="return submitLogin();" 
          class="span5"
          method="POST">
          <h3>Login or Signup</h3><br/>
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
        <div align="center" class="span1">
        <div style="border-left:1px solid #CCC; margin-left: 30px; height:95px"></div>
        <h2>OR</h2>
        <div style="border-left:1px solid #CCC; margin-left: 30px; height:95px"></div>
        </div>
        <div align="right" class="span5">
          <h3>Try Schedulr Out</h3><br/>
          You can try out Schedulr without signing up or logging in! <br/><br/>
          Note: You won't be able to save your schedules<br/> or use multiple schedules in trial mode<br/><br/>
          <a class="btn" href="/trial">Try it out</a>
        </div>
      </div>
      <div class="well about">
        <h2>Schedulr helps you schedule your classes</h2>
        <br/>
        <div class="row">
          <img align="left" class="span6" src="/assets/img/schedule.png" />
          <dl style="margin-top:0px" class="span5">
            <h3><dt>Weekly Calendar View</dt></h3>
            <p><dd>Watch your weekly schedule fill out as you add classes. See how each class will fit in your schedule before adding it.</dd></p>
            <br/>
            <h3><dt>Multiple Schedules</dt></h3>
            <p><dd>Plan out multiple potential schedules so that you can make sure you're going to end up with a schedule you want, no matter what happens.</dd></p>
            <br/>
            <h3><dt>Advanced Search</dt></h3>
            <p><dd>Search by department, course number range, distribution requirement, number of credits or professor.</dd></p>
          </dl>
        </div>
      </div>
    </div>
  </body>
</html>

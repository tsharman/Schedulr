function removeSignup() {
  $(signup_message).addClass("hidden");
  $(password2).addClass("hidden");
  $(password2).val("");
  $(submit_type).val("login");
  $(".login-form-large").addClass("login-form-small");
  $(".login-form-small").removeClass("login-form-large");
}

function submitLogin() {
  if($(submit_type).val() == "signup") {
    if($(password).val() != $(password2).val()) {
      alert("passwords don't match");
      return false;
    }
  }

  else {
    // Check if uniqname currently exists
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","/lib/ajax/checkuniqname.php?uniqname="+$(uniqname).val(),false);
    xmlhttp.send();
    if(xmlhttp.responseText == 0) {
      $(".login-form-small").addClass("login-form-large");
      $(".login-form-large").removeClass("login-form-small");
      $(submit_type).val("signup");
      $(signup_message).removeClass("hidden");
      $(password2).removeClass("hidden");
      return false;
    }
  }
}

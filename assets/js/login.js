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
      $(submit_type).val("signup");
      $(signup_message).removeClass("hidden");
      $(password2).removeClass("hidden");
      return false;
    }
  }
}

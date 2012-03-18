document.onkeydown=keyPressed;
function keyPressed(e) {
  if(!e) e=window.event;
  if(e.keyCode == 13) {
    search();
  }
}

function addEventHandlers() {
  $(".courseInfo").bind({
    click: function(event) {
      var id = $(this).attr("data-id");
      addClass(id);
    },
    mouseenter: function(event) {
      if(event.target === this) {
        var id = $(this).attr("data-id");
        ghostClass(id);
      }
    },
    mouseleave: function(event) {
      if(event.target === this) {
        unghostClass();
      }
    }
  });
}

function showAdvancedSearch() {
  $("#basic-search").addClass("hidden");
  $("#advanced-search").removeClass("hidden");
  $("#search-type").val("advanced");
}

function search() {
  $(results).html("");
  if($("#search-type").val() == "basic") {
    var query = $("#query").val();
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        if (xmlhttp.responseText != "") {
          $(results).append(xmlhttp.responseText);
          addEventHandlers();
        }
      }
    }
    url = "/lib/ajax/search.php?query="+query;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
  } else {
    $("#basic-search").removeClass("hidden");
    $("#advanced-search").addClass("hidden");
    $("#search-type").val("basic");
    
    var dept = $("#in_dept").val();
    var num_select = $("#num_select").val();
    var num = $("#in_num").val();
    var dist = $("#in_dist").val();
    var credits = $("#in_credits").val();
    var prof = $("#in_prof").val();
   
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        if (xmlhttp.responseText != "") {
          $(results).append(xmlhttp.responseText);
          addEventHandlers();
        }
      }
    }
    url = "/lib/ajax/searchadvanced.php?dept="+dept+
                                      "&num_select="+num_select+
                                      "&num="+num+
                                      "&dist="+dist+
                                      "&credits="+credits+
                                      "&prof="+prof;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
  }
}

function addClass(id) {
  $(".ghost").remove();
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      $("#calendarBackground").append(xmlhttp.responseText);
    }
  }
  xmlhttp.open("GET","/lib/ajax/addclass.php?id="+id+"&schedule="+schedule, true);
  xmlhttp.send();
}

function ghostClass(id) {
  console.log(id);
  $(".ghost").remove();
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      $("#calendarBackground").append(xmlhttp.responseText);
    }
  }
  xmlhttp.open("GET","/lib/ajax/ghostclass.php?id="+id+"&schedule="+schedule, true);
  xmlhttp.send();
}

function unghostClass(e) {
  $(".ghost").remove();
}

function removeClass(id) {
  $("."+id).remove();
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      console.log(xmlhttp.responseText);
    }
  }
  xmlhttp.open("GET","/lib/ajax/removeclass.php?id="+id+"&schedule="+schedule, true);
  xmlhttp.send();
}

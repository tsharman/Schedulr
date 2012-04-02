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
      addCourse(id);
    },
    mouseenter: function(event) {
      if(event.target === this) {
        var id = $(this).attr("data-id");
        ghostCourse(id);
      }
    },
    mouseleave: function(event) {
      if(event.target === this) {
        unghostCourse();
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
    $.ajax({
      url: "/lib/ajax/search.php",
      data: { query: query }
    }).done(function(data) {
      if (data != "") {
        $(results).append(data);
        addEventHandlers();
      }
    });
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
   
    $.ajax({
      url: "/lib/ajax/searchadvanced.php",
      data: {
        dept: dept, 
        num_select: num_select, 
        num: num, 
        dist: dist,
        credits: credits, 
        prof: prof
      },
    }).done(function(data) {
      if (data != "") {
        $(results).append(data);
        addEventHandlers();
      }
    });
  }
}

function addCourse(id) {
  for(i in calendar.ghosts) {
    if(calendar.ghosts[i].id == id)
      calendar.courses.push(calendar.ghosts[i]);
  } 
  if(trial)
    return;
  $.ajax({
    url: "/lib/ajax/addclass.php",
    data: {id:id, schedule:schedule},
  }).done(function() {
    calendar.init();
  });
}

function ghostCourse(id) {
  calendar.redraw();
  $.ajax({
    url: "/lib/ajax/ghostclass.php",
    data: {id: id},
    dataType: "json"
  }).done(function(data) {
    for(i in data) {
      calendar.drawCourse(data[i], true);
      calendar.ghosts = data;
    }
  });
}

function unghostCourse(e) {
  calendar.redraw();
}

function removeCourse(id) {
  var newCourses = new Array();
  for(i in calendar.courses) {
    if(calendar.courses[i].id != id)
      newCourses.push(calendar.courses[i]);
  }
  calendar.courses = newCourses;
  calendar.redraw();
  $.ajax({
    url: "/lib/ajax/removeclass.php",
    data: {id: id, schedule: schedule}
  }).fail(function() {
    console.log("Something went wrong");
    calendar.init();
  })
}

function showSignup() {
  $("#shadow").width($(document).width());
  $("#shadow").height($(document).height());
  $("#shadow").removeClass("hidden");
  $("#alert-message").removeClass("hidden");
  var markup = 
    "<h3>"+
      "This is a list of your course IDs. Enter these into "+
      "<a href='http://wolverineaccess.umich.edu' target='_blank'>Wolverine Access</a>"+
    "</h3><br/>";

  markup += "<p>";
  var ids = new Array();
  for(i in calendar.courses) {
    var name = calendar.courses[i].dept + " " + calendar.courses[i].num;
    var id = calendar.courses[i].id;
    if($.inArray(id, ids) === -1) {
      markup += name + " : " + id + "<br/>";
      ids.push(id);
    }
  }
  markup += "</p>";

  $("#alert-message").html(markup);
  var messageleft = ((($(document).width())/2) - (($("#alert-message").width())/2));
  $("#alert-message").offset({ top: 200, left: messageleft});

  $("#shadow").click(function() {
    $("#shadow").addClass("hidden");
    $("#alert-message").addClass("hidden");
  });
}

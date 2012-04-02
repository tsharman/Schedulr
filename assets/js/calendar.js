var calendar = {
  init: function() {
    this.canvas = document.getElementById('canvas-calendar');
    this.context = this.canvas.getContext('2d');

    $.ajax({
      url: "/lib/ajax/getscheduleclasses.php",
      data: { id: schedule },
      dataType: 'json',
      context: calendar
    }).done(function(data) {
      this.courses = data;
      this.redraw();
    });
  },

  redraw: function() {
    this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    $(".close").remove();
    this.drawBackground(8, 18);
    for(i in this.courses) {
      this.drawCourse(this.courses[i]);
    }
  },
  
  drawBackground: function(start, end) {
    this.canvas.height = 35 + 50 * (end - start + 1);
    this.drawRoundedRectangle(0, 0, this.canvas.width, this.canvas.height, 7, "#CCC");

    // Draw rows
    this.context.font = "bold 18px sans-serif";
    this.context.textAlign = "right";
    this.context.textBaseline = "middle";
    for(var i = 0; i <= (end-start); i++) {
      var y = 35 + 50*i;
      this.drawLine(40, y, this.canvas.width, y, "#DDD");
      this.drawLine(40, y+25, this.canvas.width, y+25, "#F5F5F5");

      var time = i + start;
      if(time > 12)
        time -= 12;
      this.context.fillText(time, 35, y);
    }

    // Draw columns
    this.drawLine(40, 0, 40, this.canvas.height, "#DDD");
    this.drawLine(156, 0, 156, this.canvas.height, "#DDD");
    this.drawLine(272, 0, 272, this.canvas.height, "#DDD");
    this.drawLine(388, 0, 388, this.canvas.height, "#DDD");
    this.drawLine(504, 0, 504, this.canvas.height, "#DDD");

    // Write in days
    this.context.textAlign = "center";
    this.context.textBaseline = "top";
    this.context.fillText("Mon", 98, 7);
    this.context.fillText("Tues", 214, 7);
    this.context.fillText("Wed", 330, 7);
    this.context.fillText("Thurs", 446, 7);
    this.context.fillText("Fri", 562, 7);
  },

  drawCourse: function(course, ghost) {
    this.context.font = "normal 12px sans-serif";
    if(ghost === true)
      this.context.globalAlpha = 0.5;
    // for each day 
    for(i in course["days"]) {
      // Draw background
      x1 = 41 + 116 * course["days"][i];
      x2 = x1 + 115;
      y1 = ((course["caltime"][0] - 8) * 50) + 35;
      y2 = y1 + (course["caltime"][1] * 50);
      this.fillRoundedRectangle(x1, y1, x2, y2, 5, "#555", "#BBB");

      // Fill in courseinfo 
      this.context.strokeStyle = "#000";
      this.context.fillStyle = "#000";
      this.context.textAlign = "left";
      this.context.textBaseline = "top";
      var courseName = course["dept"] + " " + course["num"];
      this.context.fillText(courseName, x1 + 5, y1 + 5);
      this.context.fillText(course["location"], x1 + 5, y1 + 25);

      // Draw x
      $("#div-calendar").append(
        "<a  \
          style='position: absolute; top: "+(y1)+"px; left: "+(x2-15)+"' \
          class='close' \
          onclick='removeCourse("+course["id"]+")'> \
          &times; \
        </a>"
      );
    }

    this.context.globalAlpha = 1;
  },

  /* Helper functions */
  drawRoundedRectangle: function(x1, y1, x2, y2, radius, color) {
    this.context.strokeStyle = color;

    this.context.beginPath();
    this.context.moveTo(x1+radius, y1);

    this.context.lineTo(x2-radius, y1);
    this.context.quadraticCurveTo(x2, y1, x2, y1+radius);
    this.context.lineTo(x2, y2-radius);
    this.context.quadraticCurveTo(x2, y2, x2-radius, y2);
    this.context.lineTo(x1+radius, y2);
    this.context.quadraticCurveTo(x1, y2, x1, y2-radius);
    this.context.lineTo(x1, y1+radius);
    this.context.quadraticCurveTo(x1, y1, x1+radius, y1);

    this.context.closePath();
    this.context.stroke();
  },

  fillRoundedRectangle: function(x1, y1, x2, y2, radius, strokecolor, fillcolor) {
    this.context.fillStyle = fillcolor;
    this.context.strokeStyle = strokecolor;

    this.context.beginPath();
    this.context.moveTo(x1+radius, y1);

    this.context.lineTo(x2-radius, y1);
    this.context.quadraticCurveTo(x2, y1, x2, y1+radius);
    this.context.lineTo(x2, y2-radius);
    this.context.quadraticCurveTo(x2, y2, x2-radius, y2);
    this.context.lineTo(x1+radius, y2);
    this.context.quadraticCurveTo(x1, y2, x1, y2-radius);
    this.context.lineTo(x1, y1+radius);
    this.context.quadraticCurveTo(x1, y1, x1+radius, y1);

    this.context.stroke();
    this.context.fill();
    this.context.closePath();
  },

  drawLine: function(x1, y1, x2, y2, color) {
    x1 += 0.5;
    x2 += 0.5;
    y1 += 0.5;
    y2 += 0.5;
    this.context.strokeStyle = color;
    this.context.lineWidth = 1;
    this.context.beginPath();
    this.context.moveTo(x1, y1);
    this.context.lineTo(x2, y2);
    this.context.closePath();
    this.context.stroke();
  },
};

$(document).ready(function() { calendar.init(); });

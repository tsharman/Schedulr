<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/user.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/model/schedule.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/ui/uicalendar.php');

?>
 
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <script 
      type="text/javascript" 
      src="http://code.jquery.com/jquery-latest.min.js">
    </script>
    <script type="text/javascript" src="/assets/js/schedule.js"></script>
    <script type="text/javascript">
			var trial = true;
		</script>
	  <link rel="stylesheet" type="text/css" href="/assets/css/master.css">
	  <link rel="stylesheet" type="text/css" href="/assets/css/calendar.css">
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
        <div class="row">
          <div class="span10">
						<h3>Sign up to be able to save your schedule, or plan out multiple schedules.</h3>
					</div>
					<div class="span2">
						<a href="/login" class="pull-right btn btn-primary">Sign Up</a>
					</div>
				</div>
      <br/>
      <div class="row">
        <div class="span8">
          <? echo <sc:calendar /> ?>
        </div>
        <div class="span4">
          <input id="search-type" type="hidden" value="basic">
          <div id="basic-search"> 
            <input id="query" type="text" class="input-medium search-query">
            <span class="pull-right btn-group">
              <button class="btn" onclick="search()">Search</button>
              <button class="btn" onclick="showAdvancedSearch()">Advanced</button>
            </span>
          </div>

          <div class="form-horizontal hidden" id="advanced-search" >
            <fieldset>
              <div class="control-group">
                <label class="control-label" for="in_dept">Department:</label>
                <div class="controls">
                  <input id="in_dept" type="text" class="input-medium" placeholder="department" />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="in_num">Course Number:</label>
                <div class="controls">
                  <select id="num_select" style="width: 50px">
                    <option><</option>
                    <option>=</option>
                    <option>></option>
                  </select>
                  <input id="in_num" type="text" class="input-small" placeholder="num" />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="in_dist">Distributions:</label>
                <div class="controls">
                  <select style="width: 145px" multiple="multiple" id="in_dist">
                    <option>CE</option>
                    <option>HU</option>
                    <option>SS</option>
                    <option>ID</option>
                    <option>MSA</option>
                    <option>NS</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="in_credits">Credits:</label>
                <div class="controls">
                  <select style="width: 145px" multiple="multiple" id="in_credits">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5+</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="in_prof">Professor:</label>
                <div class="controls">
                  <input id="in_prof" type="text" class="input-medium" placeholder="professor" />
                </div>
              </div>
              <div class="form-actions">
                <button class="btn" onclick="search()">Search</button>
              </div>
            </fieldset>
          </div>
          <div id="results" style="margin-top: 20px; height:520px; overflow-y:scroll">
        </div>
      </div>
    </div>
  </body>
</html>

<!DOCTYPE html> 
<html>
<head>
    <link href="/css/main.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container">

	<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
  
    <div class="navbar-header">
      <a class="navbar-brand" href="#" data-bind="click: returnHome">How To Train Your Robot</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <li><a href="#" data-bind="click: function(){ changeView('about'); }">About</a></li>
          <li><a href="#" data-bind="click: function(){ changeView('high-scores'); }">High Scores</a></li>
      </ul>
    
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Score: <span data-bind="text: score"/></a></li>
       
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

    </div><!-- /.container -->
<script src="/vendor/requirejs/require.js"></script>
<script>
	requirejs.config({
		baseUrl:  "<?php echo (strpos($_SERVER["HTTP_HOST"], 'amazonaws.com') !== false) ? '/js-built' : '/js'; ?>",
	});
	require(['common'], function(common){
		/*require(
			['jquery', 'knockout', 'app/gameViewModel', 'jstree'],
			function($, ko, GameViewModel, jstree){
				
				
			}
		);*/
	});
</script>
</body>
</html>
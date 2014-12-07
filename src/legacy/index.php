<?php
require_once(dirname(__FILE__) . '/includes/data_access.php');
$data_access = new DataAccess();
$eras = $data_access->get_eras();
$categories = $data_access->get_categories();
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/main.css">
</head>
<body>

<div class="container">

<!-- header -->

<div id="header">
<div id="header-left">
		  <a class="navbar-brand" href="#" data-bind="click: returnHome" title="Explore Farmington on the timeline">
		  <img src="../public/images/DigitalFarmington.png" alt="Digital Farmington" style="margin-left:0px; margin-top:-5px; position:relative; border:0px;"/>
		  </a>
</div>

<div id="header-right">
 <a href="http://www.stanleywhitman.org/" title="Stanley Whitman House Web">
<img src="../public/images/StanleyWhitmanHName.png" alt="StanleyWhitman House" style="margin-right:25px; margin-top:10px; position:relative; border:0px;" width="250" height="30"/>
</a>
</div>
  
</div>
<!-- header -->
<!-- page -->
<div id="page">	

 <!-- containerIn -->
  <div id="containerIn">
  
	 <!--/ content1 -->
	  <div id="content1">
     <div class="row" >
	 
	 
	 <!-- sidecenter -->
      <div id="sidecenter">
       

            <div id="map">

            </div>

            <div id="selectyear">
			
				<img src="../public/images/selectaYear.png" alt="Select a Year" />
				

                <input name="era" type="text"/>

            </div>

        
		
		
      </div>
<!--/ sidecenter -->

<!-- sideright -->
        <div id="sideright">
		
        <div class="col-md-3">

            <h3>
			<img src="../public/images/filterCategories.png" alt="Filter Categories" />
			</h3>
            <?php foreach ($categories as $category): ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="categories" value="<?php echo $category['label']; ?>"
                               checked/> <?php echo $category['label']; ?>
                    </label>
                </div>
            <?php endforeach; ?>

        </div>
		
		</div>
<!--/ sideright -->

    </div>
<!--/ content1 -->		
 </div>

	<!-- clear --><div class="clearer"><span></span></div><!--/ clear -->
	<p> <p/>
	
<!-- main-text-draw1 -->
				<div id="main-text-draw1">
				
	           <img src="../public/images/historicMaps.jpg" alt="Historical Maps" style="margin-left:0px; margin-top:0px; position:relative; border:0px;"/>
	            
				<br/><br/>
				<p style="font-style:italic; font-size:9pt">
					
				    <div class="row">
        <div class="col-md-2">
		
		  <p class="titleNameMap">Name Map1 <p/>
		 <img src="../public/images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />
		 
		   <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                <img src="../public/images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="150"/>
            </a>
        </div>
        <div class="col-md-2">
            
			  <p class="titleNameMap">Name Map2 <p/>
		 <img src="../public/images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />
		 
			<a class="thumbnail" data-toggle="modal" data-target="#myModal">
                <img src="../public/images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="150"/>
            </a>
        </div>
        <div class="col-md-2">
            
			  <p class="titleNameMap">Name Map3 <p/>
		 <img src="../public/images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />
		 
			<a class="thumbnail" data-toggle="modal" data-target="#myModal">
                <img src="../public/images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="1"/>
            </a>
        </div>
        <div class="col-md-2">
		  <p class="titleNameMap">Name Map4 <p/>
		 <img src="../public/images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />
		 
            <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                 <img src="../public/images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="1"/>
            </a>
        </div>
        <div class="col-md-2">
              <p class="titleNameMap">Name Map5 <p/>
		 <img src="../public/images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />
		 
			<a class="thumbnail" data-toggle="modal" data-target="#myModal">
                 <img src="../public/images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="1"/>
            </a>
        </div>
        <div class="col-md-2">
		  <p class="titleNameMap">Name Map6 <p/>
		 <img src="../public/images/titlecaret.png" alt="" width="12" height="6" style="margin-left:3px; margin-top:-10px; position:absolute;" />
		 
            <a class="thumbnail" data-toggle="modal" data-target="#myModal">
                 <img src="../public/images/1800sCT213x157.jpg" alt="Historical Maps" width="350" height="1"/>
            </a>
        </div>
    </div>	
				</p>
				</div>
				<!-- /main-text-draw1 -->

    <?php include "historic-map-modal.php"; ?>
    <?php include "poi-detail-modal.php"; ?>
	
<!-- menubottom -->
<div id="menubottom">
   	    <div id="menubottom-left">
			<a accesskey="c" href="http://www.stanleywhitman.org" title="About">ABOUT</a> - 
		    <a href="http://www.stanleywhitman.org" title="Contact">CONTACT</a> 
	</div>

</div>
<!--/ menubottom -->

	<!-- clear --><div class="clearer"><span></span></div><!--/ clear -->
<!-- underfooter -->
    <div id="underfooter">
        <div id="underfooterleft">
	     	 Copyright &copy;  2014  STANLEY WHITMAN HOUSE  
	     </div>
       
		 <div id="underfooterright">
		  Web Design  by Alex Shorthouse/Kevin Gregory/Marianella Rydzewski
		    </div>
	
	     <div id="underfootercenter">
 	     
         </div>
   
	  <br>
	</div>
    <!--/ underfooter -->
	
</div>
</div>
<!-- /.containerIn -->

</div>
<!--/ page -->
<!-- clear --><div class="clearer"><span></span></div><!--/ clear -->
<!-- clear --><div class="clearer"><span></span></div><!--/ clear -->
<br>
<br>
<br>
</div>
<!--/ container -->

<script charset="utf-8" type="text/javascript">var switchTo5x=false;</script>
<script charset="utf-8" type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher:"22ff76a7-01e5-4ac8-98d7-8b175f44c98f"});</script>
<script charset="utf-8" type="text/javascript" src="http://s.sharethis.com/loader.js"></script>
<script charset="utf-8" type="text/javascript">var options={ publisher:"22ff76a7-01e5-4ac8-98d7-8b175f44c98f", "position": "left", "chicklets": { "items": ["facebook","twitter","linkedin"] } }; var st_hover_widget = new sharethis.widgets.hoverbuttons(options);</script>


<script type="text/javascript" src="/vendor/requirejs/require.js"></script>
<script type="text/javascript">
requirejs.config({
    baseUrl: "<?php echo (strpos($_SERVER["HTTP_HOST"], 'amazonaws.com') !== false) ? '/js-built' : '/js'; ?>"
});
require(['common'], function (common) {

});
</script>
</body>
</html>
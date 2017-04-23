<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex">
	<title>NETWORK</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="style.css"> <!-- 較優先 -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script> <!-- for ajax -->	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans|Maven+Pro:500' rel='stylesheet' type='text/css'> 
	<!-- 字型 -->
</head>
<body>
	<header>
  		<h1>Network</h1>
  		<h3>
    		Live boldy. Push yourself. Don't settle. <!-- TODO: find subtile and href -->
  		</h3>
  		<a href="https://www.instagram.com/penny_tien">pennytien.me</a> 
	</header>
	<section class="main">
	  	<a class="arrow-wrap" href="#content"> <!-- move to #content -->
	  		<span class="arrow"></span>     <!-- TODO: 改成箭頭 + start -->
	  	<!--<span class="hint">scroll</span>--> 
	  	</a>

		<div class="container" id="content">
			<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">

				    <!-- Modal content-->
				    <div class="modal-content">
				    	<div class="modal-header">
				      		<button type="button" class="close" data-dismiss="modal" onClick="window.location.reload()">&times;</button>
				        	<h4 class="modal-title">SELECT NODES</h4>
				      	</div>
				      	<div class="modal-body">
				        	<div id="show_area">
				        	</div>    	 <!-- display node select table -->
				   	 	</div>
				    	<div class="modal-footer">
				    	<button type="button" class="btn btn-default" data-dismiss="modal" onClick="window.location.reload()">Close</button>
				    	<!-- refresh to clean the table -->
				    	<!-- TODO: click gray area shold refresh -->
				    	<!-- TODO: click gray area not long enough -->
				   	 	</div>
				    </div>
				</div>
			</div>	

	  		<div class="inputarea">
	    		<h2>Input Data</h2>
					<textarea name="InputText" id="InputText" class="form-control" style="height:500px;width:200px"></textarea>
					<p>
						<!-- pass funtion called ajax and the result display at .show_area -->
						<button type="button" class="btn btn-primary" id="load" data-toggle="modal" data-target="#myModal" onclick="passNodeNames()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Submit</button>
						<button type="button" class="btn btn-link" onclick="example()">Example</button>
					</p> 
	    	</div>
	    	<footer class="footer">
	     		<div class="container">
	        		<p class="text-muted">Place sticky footer content here.</p>
	     	 	</div>
	    	</footer>
	    </div>
    </section>
</body>
</html>



<!DOCTYPE html>
<html>
	<head>
		<title>network demo</title>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.css">
		<!-- <link href="style.css" rel="stylesheet" /> -->
		<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.js"></script>
		<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>
		<script src="cytoscape-cxtmenu.js"></script>
		<script src="cytoscape-qtip.js"></script>
		<script src="function.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.9.1.js "></script> <!-- add -->
		<script src="http://ajax.aspnetcdn.com/ajax/knockout/knockout-3.0.0.js "></script>	<!-- add -->
		<script src="http://html2canvas.hertzen.com/build/html2canvas.js"></script>	<!-- add -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 	<!-- add -->
		
		
		
		<style>
		body, html {
			font-family: helvetica;
			font-size: 14px;
			width: 100%;
			height: 100%;
			position: absolute;
			padding: 0;
			margin: 0;
		}

		#cy {
			width: 100%;
			height: 95%;				/* modify */
			position: absolute;
			left: 0;
			top: 0;
		}

		h1 {
			opacity: 0.5;
			font-size: 1em;
			margin: 0.25em;
		}
		
		#downloadButtom {   			/* add start */
			position:absolute;
			bottom: 30px;
			right: 60px;
			z-index: 999;
		}								/* add  end */


		</style>
		
		
		
		<?php
		include_once("function.php");
		mysql_connect("localhost", "root", "ngs1706c")or die('Error with MySQL connection');
		mysql_select_db("network");
		
		
		
		/*preprocess input data*/
		$inputtext=$_POST["input_node"];
		$function="";
		$select_node="";
		$original_node="";
		
		//function
		if($inputtext!=""){//input data
			$function=1;
		}
		else{//menu's function
			$message=$_GET["message"];
			
			if($message!=""){
				//echo $message."<br>";
				$message_ary=explode(";", trim($message));
				$function=$message_ary[0];
				$select_node=$message_ary[1];
				$original_node=$message_ary[2];
			}
			else{
				echo "null<br>";
			}
			
		}
		/*
		echo "function: ".$function."<br>";
		echo "select_node: ".$select_node."<br>";
		echo "original_node: ".$original_node."<br>";
		*/
		
		//input node (biogrid)
		$input_node=array();
		if($function==1){//input data
			$input_node=$inputtext;
		}
		else if($function==2){//extend relations
			array_push($input_node, trim($select_node));
			$original_node_ary=explode(",", $original_node);
			for($a=0;$a<count($original_node_ary);$a++){
				if(in_array(trim($original_node_ary[$a]), $input_node)==false){
					array_push($input_node, trim($original_node_ary[$a]));
				}
			}
			
			$cmd="select Alt_IDs_Interactor_A,Alt_IDs_Interactor_B from BIOGRID where Alt_IDs_Interactor_A like '%biogrid:".trim($select_node)."%' or Alt_IDs_Interactor_B like '%biogrid:".trim($select_node)."%';";
			//echo $cmd."<br>";
			$dbcmd=mysql_query($cmd);
			for($a=0;$a<mysql_num_rows($dbcmd);$a++){
				$dbread=mysql_fetch_row($dbcmd);
				
				//A protein's biogrid
				$A_tempary=explode("|", trim($dbread[0]));
				$A_biogrid_tempary=explode(":", trim($A_tempary[0]));
				$A_biogrid_temp=trim($A_biogrid_tempary[1]);
				
				//B protein's biogrid
				$B_tempary=explode("|", trim($dbread[1]));
				$B_biogrid_tempary=explode(":", trim($B_tempary[0]));
				$B_biogrid_temp=trim($B_biogrid_tempary[1]);
				
				if(in_array($A_biogrid_temp, $input_node)==false){
					array_push($input_node, trim($A_biogrid_temp));
				}
				if(in_array($B_biogrid_temp, $input_node)==false){
					array_push($input_node, trim($B_biogrid_temp));
				}
			}
		}
		else if($function==3){//show relations
			array_push($input_node, trim($select_node));
			
			$cmd="select Alt_IDs_Interactor_A,Alt_IDs_Interactor_B from BIOGRID where Alt_IDs_Interactor_A like '%biogrid:".trim($select_node)."%' or Alt_IDs_Interactor_B like '%biogrid:".trim($select_node)."%';";
			//echo $cmd."<br>";
			$dbcmd=mysql_query($cmd);
			for($a=0;$a<mysql_num_rows($dbcmd);$a++){
				$dbread=mysql_fetch_row($dbcmd);
				
				//A protein's biogrid
				$A_tempary=explode("|", trim($dbread[0]));
				$A_biogrid_tempary=explode(":", trim($A_tempary[0]));
				$A_biogrid_temp=trim($A_biogrid_tempary[1]);
				
				//B protein's biogrid
				$B_tempary=explode("|", trim($dbread[1]));
				$B_biogrid_tempary=explode(":", trim($B_tempary[0]));
				$B_biogrid_temp=trim($B_biogrid_tempary[1]);
				
				if(in_array($A_biogrid_temp, $input_node)==false){
					array_push($input_node, trim($A_biogrid_temp));
				}
				if(in_array($B_biogrid_temp, $input_node)==false){
					array_push($input_node, trim($B_biogrid_temp));
				}
			}
		}
		else if($function==4){//hide
			$original_node_ary=explode(",", trim($original_node));
			for($a=0;$a<count($original_node_ary);$a++){
				if(trim($select_node)!=$original_node_ary[$a]){
					array_push($input_node, trim($original_node_ary[$a]));
				}
			}
		}
		else{
		}
		//print_array("input_node", $input_node);
		
		//action flag
		$action_flag=false;
		if($function!=""){
			$action_flag=true;
		}
		
		
		
		/*find drawing node and edge*/
		if($action_flag){
			$drawing_node_biogrid=array();//node biogrid
			$drawing_node=array();//protein name
			$drawing_edge_biogrid=array();//edge biogrid
			$drawing_edge=array();//protein interaction
			
			$nodestr="";
			for($a=0;$a<count($input_node);$a++){
				if($a==count($input_node)-1){
					$nodestr=$nodestr." (Alt_IDs_Interactor_A like '%biogrid:".$input_node[$a]."%' or Alt_IDs_Interactor_B like '%biogrid:".$input_node[$a]."%')";
				}
				else{
					$nodestr=$nodestr." (Alt_IDs_Interactor_A like '%biogrid:".$input_node[$a]."%' or Alt_IDs_Interactor_B like '%biogrid:".$input_node[$a]."%') or";
				}
			}
			$cmd="select Alt_IDs_Interactor_A,Alt_IDs_Interactor_B from BIOGRID where".$nodestr.";";
			//echo $cmd."<br>";
			$dbcmd=mysql_query($cmd);
			for($a=0;$a<mysql_num_rows($dbcmd);$a++){
				$dbread=mysql_fetch_row($dbcmd);
				
				//A protein
				$A_tempary=explode("|", trim($dbread[0]));
				$A_biogrid_tempary=explode(":", trim($A_tempary[0]));
				$A_biogrid_temp=trim($A_biogrid_tempary[1]);
				$A_protein_name_tempary=explode(":", trim($A_tempary[1]));
				$A_protein_name_temp=trim($A_protein_name_tempary[1]);
				
				//b protein
				$B_tempary=explode("|", trim($dbread[1]));
				$B_biogrid_tempary=explode(":", trim($B_tempary[0]));
				$B_biogrid_temp=trim($B_biogrid_tempary[1]);
				$B_protein_name_tempary=explode(":", trim($B_tempary[1]));
				$B_protein_name_temp=trim($B_protein_name_tempary[1]);
				
				/*
				echo "A_biogrid_temp: ".$A_biogrid_temp."<br>";
				echo "A_protein_name_temp: ".$A_protein_name_temp."<br>";
				echo "B_biogrid_temp: ".$B_biogrid_temp."<br>";
				echo "B_protein_name_temp: ".$B_protein_name_temp."<br><br>";
				*/
				
				//drawing node and drawing node's biogrid
				if(in_array($A_biogrid_temp, $input_node)==true && in_array($A_biogrid_temp, $drawing_node_biogrid)==false){
					array_push($drawing_node_biogrid, $A_biogrid_temp);
					array_push($drawing_node, $A_protein_name_temp);
				}
				if(in_array($B_biogrid_temp, $input_node)==true && in_array($B_biogrid_temp, $drawing_node_biogrid)==false){
					array_push($drawing_node_biogrid, $B_biogrid_temp);
					array_push($drawing_node, $B_protein_name_temp);
				}
				
				//drawing edge
				if(in_array($A_biogrid_temp, $input_node)==true && in_array($B_biogrid_temp, $input_node)==true){
					$drawing_edge_temp1=$A_protein_name_temp.",".$B_protein_name_temp;
					$drawing_edge_temp2=$B_protein_name_temp.",".$A_protein_name_temp;
					if(in_array($drawing_edge_temp1, $drawing_edge)==false && in_array($drawing_edge_temp2, $drawing_edge)==false){
						array_push($drawing_edge_biogrid, $A_biogrid_temp.",".$B_biogrid_temp);
						array_push($drawing_edge, $drawing_edge_temp1);
					}
				}
			}
			/*
			print_array("drawing_node_biogrid", $drawing_node_biogrid);
			print_array("drawing_node", $drawing_node);
			print_array("drawing_edge", $drawing_edge);
			*/
		}//end action flag
		?>
		
		
		
		<script>
		/*input_node, drawing_node_biogrid, drawing_node, drawing_edge from php to jscript*/
		var input_node=<?php echo json_encode($input_node) ?>;
		var drawing_node_biogrid=<?php echo json_encode($drawing_node_biogrid) ?>;
		var drawing_node=<?php echo json_encode($drawing_node) ?>;
		var drawing_edge_biogrid=<?php echo json_encode($drawing_edge_biogrid) ?>;
		var drawing_edge=<?php echo json_encode($drawing_edge) ?>;
		trim_array(input_node);
		trim_array(drawing_node_biogrid);
		trim_array(drawing_node);
		trim_array(drawing_edge_biogrid);
		trim_array(drawing_edge);
		/*
		print_array("input_node", input_node);
		print_array("drawing_node_biogrid", drawing_node_biogrid);
		print_array("drawing_node", drawing_node);
		print_array("drawing_edge_biogrid", drawing_edge_biogrid);
		print_array("drawing_edge", drawing_edge);
		*/
		
		
		
		/*cy's element*/
		var demo=make_elements(drawing_node, drawing_edge);
		var demo_node=demo[0];
		var demo_edge=demo[1];
		
		
		
		/*drawing*/
		document.addEventListener("DOMContentLoaded", function(){
			//cy init
			var cy=window.cy=cytoscape({
				container: document.getElementById("cy"),
				boxSelectionEnabled: false,
				autounselectify: true,
				
				layout: {
					name: "grid"
				},
				
				style: [
					{
						//node's style
						selector: "node",
						style: {
							"content": "data(name)",
							"height": 20,
							"width": 20,
							"background-color": "powderblue"
						}
					},
					{
						//edge's style
						selector: "edge",
						style: {
							"curve-style": "haystack",
							"haystack-radius": 0,
							"width": 5,
							"opacity": 0.4,
							"line-color": "powderblue"
						}
					},
				],//end style
				
				elements:{
					nodes: demo_node,
					edges: demo_edge
				}//end elements
			});//end cy init
			
			//cy.on
			cy.on("tap", "node", function(){
				var node_key=drawing_node.indexOf(this.data("id"));
				var message=drawing_node[node_key]+";"+drawing_node_biogrid[node_key];

				//window.open("detail.php?input_message="+message, message, config="height=200, width=500, top="+(window.screen.availHeight-200)/2+", left="+(window.screen.availWidth-500)/2);
				window.open("node_detail.php?input_message="+message, message, config="height=500, width=1000, top="+(window.screen.availHeight-500)/2+", left="+(window.screen.availWidth-1000)/2);
			});
			cy.on("tap", "edge", function(){
				var edge_temp=this.data("id");
				var edge_tempary=edge_temp.split(",");
				var node_key1=drawing_node.indexOf(edge_tempary[0]);
				var node_key2=drawing_node.indexOf(edge_tempary[1]);
				var message=drawing_node[node_key1]+","+drawing_node[node_key2]+";"+drawing_node_biogrid[node_key1]+","+drawing_node_biogrid[node_key2];

				window.open("edge_detail.php?input_message="+message, message, config="height=500, width=1000, top="+(window.screen.availHeight-500)/2+", left="+(window.screen.availWidth-1000)/2);
			});//end cy.on
			
			//qtip
			/*
			cy.elements("node").qtip({//node
				content: function(){
					return this.id();
				},
				position: {
					my: "top center",
					ar: "bottom center"
				},
				style: {
					classes: "qtip-bootstrap",
					tip: {
						width: 16,
						height: 8
					}
				}
			});
			cy.elements("edge").qtip({//edge
				content: function(){
					return this.id();
				},
				position: {
					my: "top center",
					ar: "bottom center"
				},
				style: {
					classes: "qtip-bootstrap",
					tip: {
						width: 16,
						height: 8
					}
				}
			});//end qtip
			*/
			
			//cxtmenu
			cy.cxtmenu({
				selector: "node",
				
				commands: [
					{
						content: "extend relations",
						select: function(element){
							//document.write(element.id());
							var node_biogrid=drawing_node_biogrid[drawing_node.indexOf(element.id())];
							var nodestr=make_node_string(input_node);
							var url="drawing.php?message=2;"+node_biogrid+";"+nodestr;
							window.location.replace(url);
						}
					},
					
					{
						content: "show relations",
						select: function(element){
							//document.write(element.id());
							var node_biogrid=drawing_node_biogrid[drawing_node.indexOf(element.id())];
							var nodestr=make_node_string(input_node);
							var url="drawing.php?message=3;"+node_biogrid+";"+nodestr;
							window.open(url);
						}
					},
					
					{
						content: "hide",
						select: function(element){
							//document.write(element.id());
							var node_biogrid=drawing_node_biogrid[drawing_node.indexOf(element.id())];
							var nodestr=make_node_string(input_node);
							var url="drawing.php?message=4;"+node_biogrid+";"+nodestr;
							window.location.replace(url);
						}
					}
				]
			});//end cxtmenu
		});//on dom ready
		</script>
	</head>

	<body>
		<h1>demo</h1>
		<div style="background-color:white;" id="cy"></div>					<!-- modify -->
		<button type='button' class="btn btn-default" id="downloadButtom" onclick='downLoadFunction()'>Download</button>	<!-- add start -->
		<script>
			function downLoadFunction(event) {
                        html2canvas($('#cy'), {
						        onrendered: function(canvas) {
							        var dataUrl = canvas.toDataURL(); //get's image string
							        //document.getElementById( 'dataID' ).href = dataUrl;
									window.open(dataUrl);   
						        }
						      });
                     
                      }
		</script>													<!-- add end -->

	</body>
</html>
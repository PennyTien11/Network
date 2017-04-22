<!DOCTYPE html>
<html>
	<head>
		<title>edge information</title>
	</head>
	
	<body>
		<?php
		/*connect to mysql*/
		mysql_connect("localhost", "root", "ngs1706c")or die('Error with MySQL connection');
		mysql_select_db("network");
		
		
		
		/*get input gene name*/
		$input_message=$_GET["input_message"];
		//echo $input_message."<br>";
		
		
		
		/*show information*/
		$edge_tempary=explode(";", trim($input_message));
		$node_name_tempary=explode(",", trim($edge_tempary[0]));
		$A_node_name=trim($node_name_tempary[0]);
		$B_node_name=trim($node_name_tempary[1]);
		$node_biogrid_tempary=explode(",", trim($edge_tempary[1]));
		$A_node_biogrid=trim($node_biogrid_tempary[0]);
		$B_node_biogrid=trim($node_biogrid_tempary[1]);
		//echo "edge: ".$A_node_name.",".$B_node_name."<br>";
		echo "<b><font color='#454545' size=4 face='monospace'>edge: </font></b>";
		echo "<b><font size=6 face='monospace'><u>".$A_node_name.",".$B_node_name."</u></font></b><br><br>";
		
		$Interaction_Detection_Method=array();
		$Publication_1st_Author=array();
		$Publication_Identifiers=array();
		$Interaction_Types=array();
		$Source_database=array();
		$Interaction_Identifiers=array();
		
		$cmd="select Interaction_Detection_Method,Publication_1st_Author,Publication_Identifiers,Interaction_Types,Source_database,Interaction_Identifiers from BIOGRID where (Alt_IDs_Interactor_A like '%".$A_node_biogrid."%' and Alt_IDs_Interactor_B like '%".$B_node_biogrid."%') or (Alt_IDs_Interactor_A like '%".$B_node_biogrid."%' and Alt_IDs_Interactor_B like '%".$A_node_biogrid."%');";
		//echo $cmd."<br>";
		$dbcmd=mysql_query($cmd);
		for($a=0;$a<mysql_num_rows($dbcmd);$a++){
			$dbread=mysql_fetch_row($dbcmd);
			
			if(in_array(trim($dbread[5]), $Interaction_Identifiers)==false){
				array_push($Interaction_Detection_Method, trim($dbread[0]));
				array_push($Publication_1st_Author, trim($dbread[1]));
				array_push($Publication_Identifiers, trim($dbread[2]));
				array_push($Interaction_Types, trim($dbread[3]));
				array_push($Source_database, trim($dbread[4]));
				array_push($Interaction_Identifiers, trim($dbread[5]));
			}
		}
		
		/*
		for($a=0;$a<count($Interaction_Identifiers);$a++){
			echo $a."<br>";
			echo "Interaction_Detection_Method: ".$Interaction_Detection_Method[$a]."<br>";
			echo "Publication_1st_Author: ".$Publication_1st_Author[$a]."<br>";
			echo "Publication_Identifiers: ".$Publication_Identifiers[$a]."<br>";
			echo "Interaction_Types: ".$Interaction_Types[$a]."<br>";
			echo "Source_database: ".$Source_database[$a]."<br>";
			echo "Interaction_Identifiers: ".$Interaction_Identifiers[$a]."<br><br>";
		}
		*/
		?>
		
		
		
		<!-- table -->
		<div align="center">
			<table width="98%" border="1"  align="center" style="word-break:break-all" >
				<tr bgcolor=#c1d0df align='center'>
					<td width="5%" height="30"><div align="center"><b>#</b></div></td>
					<td width="20%"><div align="center"><b>Interaction Detection Method</b></div></td>
					<td width="20%"><div align="center"><b>Publication 1st Author</b></div></td>
					<td width="20%"><div align="center"><b>Publication Identifiers</b></div></td>
					<td width="20%"><div align="center"><b>Interaction Types</b></div></td>
					<td width="20%"><div align="center"><b>Source Database</b></div></td>
				</tr>
		<?php
		for($a=0;$a<count($Interaction_Identifiers);$a++){
			echo "<tr>";
			echo "<td>".($a+1)."</td>";
			echo "<td>".$Interaction_Detection_Method[$a]."</td>";
			echo "<td>".$Publication_1st_Author[$a]."</td>";
			$Publication_Identifiers_tempary=explode(":", trim($Publication_Identifiers[$a]));
			$pubmed_url="https://www.ncbi.nlm.nih.gov/pubmed/?term=".trim($Publication_Identifiers_tempary[1]);
			echo "<td><a href='".$pubmed_url."'>".$Publication_Identifiers[$a]."</a></td>";
			echo "<td>".$Interaction_Types[$a]."</td>";
			echo "<td>".$Source_database[$a]."</td>";
			echo "</tr>";
		}
		?>
			</table>
		</div>
	</body>
</html>
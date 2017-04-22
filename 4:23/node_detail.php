<!DOCTYPE html>
<html>
	<head>
		<title>node information</title>
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
		$node_tempary=explode(";", trim($input_message));
		$node_name=trim($node_tempary[0]);
		$node_biogrid=trim($node_tempary[1]);
		//echo "node: ".$node_name."<br>";
		echo "<b><font color='#454545' size=4 face='monospace'>node: </font></b>";
		echo "<b><font size=6 face='monospace'><u>".$node_name."</u></font></b><br><br>";
		
		$cmd="select Alt_IDs_Interactor_A,Aliases_Interactor_A,Taxid_Interactor_A from BIOGRID where Alt_IDs_Interactor_A like '%biogrid:".$node_biogrid."%';";
		//echo $cmd."<br>";
		$dbcmd=mysql_query($cmd);
		if(mysql_num_rows($dbcmd)==0){
			$cmd="select Alt_IDs_Interactor_B,Aliases_Interactor_B,Taxid_Interactor_B from BIOGRID where Alt_IDs_Interactor_B like '%biogrid:".$node_biogrid."%';";
			$dbcmd=mysql_query($cmd);
		}
		$dbread=mysql_fetch_row($dbcmd);
		
		//Protein name
		$protein_name_tempary=explode("|", trim($dbread[0]));
		$protein_name="";
		for($a=1;$a<count($protein_name_tempary);$a++){
			$protein_name_tempary2=explode(":", trim($protein_name_tempary[$a]));
			$protein_name_temp=trim($protein_name_tempary2[1]);
			if($a==count($protein_name_tempary)-1){
				$protein_name=$protein_name.$protein_name_temp;
			}
			else{
				$protein_name=$protein_name.$protein_name_temp.",";
			}
		}
		//echo "Protein name: ".$protein_name."<br>";
		//echo "<b><font color='#454545' size=4 face='DFKai-sb'>node: </font></b>";
		echo "<b><font color='#454545' size=4 face='monospace'>Protein name: </font></b>";
		echo "<b><font size=4 face='monospace'>".$protein_name."</font></b><br>";
		
		//Protein alias
		$protein_alias_tempary=explode("|", trim($dbread[1]));
		$protein_alias="";
		for($a=0;$a<count($protein_alias_tempary);$a++){
			$protein_alias_tempary2=explode(":", trim($protein_alias_tempary[$a]));
			$protein_alias_tempary3=explode("(", trim($protein_alias_tempary2[1]));
			$protein_alias_temp=trim($protein_alias_tempary3[0]);
			if($a==count($protein_alias_tempary)-1){
				$protein_alias=$protein_alias.$protein_alias_temp;
			}
			else{
				$protein_alias=$protein_alias.$protein_alias_temp.",";
			}
		}
		//echo "Protein alias: ".$protein_alias."<br>";
		echo "<b><font color='#454545' size=4 face='monospace'>Protein alias: </font></b>";
		echo "<b><font size=4 face='monospace'>".$protein_alias."</font></b><br>";
		
		//Species ID
		$species_id_tempary=explode(":", trim($dbread[2]));
		$species_id=trim($species_id_tempary[1]);
		//echo "Species ID: ".$species_id."<br>";
		echo "<b><font color='#454545' size=4 face='monospace'>Species ID: </font></b>";
		echo "<b><font size=4 face='monospace'>".$species_id."</font></b><br>";
		?>
	</body>
</html>
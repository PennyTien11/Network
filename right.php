<!DOCTYPE html>
<html>
	<head>
		<title>network check</title>
	</head>
	
	<body>
		<?php
		/*connect to mysql*/
		mysql_connect("localhost", "root", "ngs1706c")or die('Error with MySQL connection');
		mysql_select_db("network");
		include_once("function.php");
		
		
		
		/*get left.php's InputText*/
		$inputtext=$_POST["InputText"];
		echo $inputtext."<br><br>";
		
		
		
		/*input node*/
		$input_node=explode("\n", trim($inputtext));
		for($a=0;$a<count($input_node);$a++){
			$input_node[$a]=trim($input_node[$a]);
		}
		//print_array("input_node", $input_node);
		
		
		
		/*get DB information*/
		$Alt_IDs_Interactor=array();
		$Aliases_Interactor=array();
		
		//Alt_IDs_Interactor_A
		$nodestr="";
		for($a=0;$a<count($input_node);$a++){
			$nodestr=$nodestr." (Alt_IDs_Interactor_A like '%".$input_node[$a]."%') or";
		}
		$nodestr=substr($nodestr, 0, strlen($nodestr)-3);
		$cmd="select Alt_IDs_Interactor_A,Aliases_Interactor_A from BIOGRID where".$nodestr.";";
		//echo $cmd."<br><br>";
		$dbcmd=mysql_query($cmd);
		for($a=0;$a<mysql_num_rows($dbcmd);$a++){
			$dbread=mysql_fetch_row($dbcmd);
			$temp1=trim($dbread[0]);
			$temp2=trim($dbread[1]);
			//echo $temp1."<br>";
			//echo $temp2."<br>";
			
			if(in_array($temp1, $Alt_IDs_Interactor)==false){
				array_push($Alt_IDs_Interactor, $temp1);
				array_push($Aliases_Interactor, $temp2);
			}
		}
		
		//Alt_IDs_Interactor_B
		$nodestr="";
		for($a=0;$a<count($input_node);$a++){
			$nodestr=$nodestr." (Alt_IDs_Interactor_B like '%".$input_node[$a]."%') or";
		}
		$nodestr=substr($nodestr, 0, strlen($nodestr)-3);
		$cmd="select Alt_IDs_Interactor_B,Aliases_Interactor_B from BIOGRID where".$nodestr.";";
		//echo $cmd."<br><br>";
		$dbcmd=mysql_query($cmd);
		for($a=0;$a<mysql_num_rows($dbcmd);$a++){
			$dbread=mysql_fetch_row($dbcmd);
			$temp1=trim($dbread[0]);
			$temp2=trim($dbread[1]);
			//echo $temp1."<br>";
			//echo $temp2."<br>";
			
			if(in_array($temp1, $Alt_IDs_Interactor)==false){
				array_push($Alt_IDs_Interactor, $temp1);
				array_push($Aliases_Interactor, $temp2);
			}
		}
		
		//print_array("Alt_IDs_Interactor", $Alt_IDs_Interactor);
		//print_array("Aliases_Interactor", $Aliases_Interactor);
		?>
		
		
		<!-- table -->
		<div align="center">
			<!-- <form name="InputNode" method="post" action="drawing.php" target="drawing"> -->
			<form name="InputNode" method="post" action="drawing.php" target="drawing">
				<table width="98%" border="1"  align="center" style="word-break:break-all" >
					<tr bgcolor=#c1d0df align='center'>
					<!--
						<td width="20%" height="30"><div align="center"><b>Biogrid</b></div></td>
						<td width="30%"><div align="center"><b>Protein Name</b></div></td>
						<td width="30%"><div align="center"><b>Protein Alias</b></div></td>
						<td width="20%"><div align="center"><b>Check</b></div></td>
					-->
						<td width="5%" height="30"><div align="center"><b>Check</b></div></td>
						<td width="20%"><div align="center"><b>Biogrid</b></div></td>
						<td width="25%"><div align="center"><b>Protein Name</b></div></td>
						<td width="50%"><div align="center"><b>Protein Alias</b></div></td>
					</tr>
		<?php
		for($a=0;$a<count($Alt_IDs_Interactor);$a++){
			//biogrid and protein name
			$tempary=explode("|", trim($Alt_IDs_Interactor[$a]));
			$biogrid_tempary=explode(":", trim($tempary[0]));
			$biogrid_temp=trim($biogrid_tempary[1]);
			$protein_name_temp="";
			for($b=1;$b<count($tempary);$b++){
				$protein_name_tempary=explode(":", trim($tempary[$b]));
				if($b==count($tempary)-1){
					$protein_name_temp=$protein_name_temp.$protein_name_tempary[1];
				}
				else{
					$protein_name_temp=$protein_name_temp.$protein_name_tempary[1].", ";
				}
			}
			
			//Protein Alias
			$tempary2=explode("|", trim($Aliases_Interactor[$a]));
			$protein_alias_temp="";
			for($b=0;$b<count($tempary2);$b++){
				$protein_alias_tempary=explode(":", trim($tempary2[$b]));
				$protein_alias_tempary2=explode("(", trim($protein_alias_tempary[1]));
				if($b==count($tempary2)-1){
					$protein_alias_temp=$protein_alias_temp.$protein_alias_tempary2[0];
				}
				else{
					$protein_alias_temp=$protein_alias_temp.$protein_alias_tempary2[0].", ";
				}
			}
			
			//checkbox
			echo "<tr>";
			echo "<td><input type=\"checkbox\" name=\"input_node[]\" value=\"".$biogrid_temp."\"></td>";
			echo "<td>".$biogrid_temp."</td>";
			echo "<td>".$protein_name_temp."</td>";
			echo "<td>".$protein_alias_temp."</td>";
			echo "</tr>";
		}
		?>
				</table>
				<p><input type="submit" name="submit" value="submit" /></p>
			</form>
		</div>
		
	</body>
</html>
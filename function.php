<?php
function print_array($array_name, $my_array){
	echo $array_name.":<br>";
	for($a=0;$a<count($my_array);$a++){
		echo "[".$a."]->".$my_array[$a]."<br>";
	}
	echo "<br>";
}
?>
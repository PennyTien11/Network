<!DOCTYPE html>
<html>
	<head>
		<title>network input</title>
	</head>
	
	<body>
		<h2>Input Data</h2>
		<form name="InputForm" method="post" action="right.php" target="right">
			<textarea name="InputText" id="InputText" style="height:500px;width:200px"></textarea>
			<p>
				<input type="submit" name="submit" value="submit" />
				<input type="button" value="example" onclick="example()">
			</p>
		</form>
		
		<script>
		function example(){
			document.getElementById("InputText").value="MAP2K4\nFLNC\nRPA2\nSTAT3";
		}
		</script>
	</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8;"/>
	<title>test</title>
<!-- 引入 jQuery(非必要,去掉時有些寫法要改為javascript) -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<!-- 引入AJAX(必要) -->
	<script type="text/javascript" src="ajax_example.js"></script> 
	<script type="text/javascript">
//賦與按鈕事件,點擊執行AJAX
	$(document).ready(function(){
	 $('#test').keyup(function(){  //當輸入時觸發test_ajax()並且傳入輸入框的值當參數
	  test_ajax($('#test').val());  //test_ajax()由ajax_example.js引入
	 });
	});
	</script>
</head>


<body>
	<div>以ajax實現頁面不刷新,從前端將值傳送到後端處理,並且回</div>
		<input type="text" id="test" value="test" />
	<div id="show_area"></div>
</body>
</html>
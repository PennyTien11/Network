
    function pass(){  //當輸入時觸發test_ajax()並且傳入輸入框的值當參數
        test_ajax($('#InputText').val());  //test_ajax()由ajax_example.js引入
    }
    function example(){
      document.getElementById("InputText").value="MAP2K4\nFLNC\nRPA2\nSTAT3";
    }

        function setAll(){
      //變數checkItem為checkbox的集合
      var checkItem = document.getElementsByName("input_node[]");
      for(var i=0;i<checkItem.length;i++){
        checkItem[i].checked=true; 
      }
    }

var http_request=false;
function test_ajax(variable){
 http_request=false;
 if(window.XMLHttpRequest){
  http_request=new XMLHttpRequest();
  if(http_request.overrideMimeType){
   http_request.overrideMimeType('text/xml');
  }
 }else if(window.ActiveXObject){
  try{ //6.0+
   http_request=new ActiveXObject("Msxml2.XMLHTTP");
  }catch(e){
   try{ //5.5+
    http_request=new ActiveXObject("Microsoft.XMLHTTP");
   }catch (e){}
  }
 }
 if(!http_request){
  alert('Giving up :( Cannot create a XMLHTTP instance');
  return false;
 }
var by_post='variable='+variable; //將變數放進字串
http_request.onreadystatechange=show_area;
http_request.open('POST','select.php',true);
http_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");  //**重要一定要加上
http_request.send(by_post);
}

function show_area(){
 if(http_request.readyState==4){
  if(http_request.status==200){
   $('#test').val('');  //將輸入框清空
   var disp = document.getElementById("show_area");
   $('#show_area').append(http_request.responseText);  //將結果顯示出來
  }
 }
}
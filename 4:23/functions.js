function print_array(array_name, my_array){
  document.write(array_name+":<br>")
  for(var a=0;a<my_array.length;a++){
    document.write("["+a+"]->"+my_array[a]+"<br>");
  }
  document.write("<br>");
}

function trim_array(my_array){
  for(var a=0;a<my_array.length;a++){
    my_array[a]=my_array[a].trim();
  }
}

function make_elements(drawing_node_array, drawing_edge_array){
  var node_array=new Array();
  var edge_array=new Array();
  
  for(var a=0;a<drawing_node_array.length;a++){
    node_array.push({
      data: {id: drawing_node_array[a], name: drawing_node_array[a]}
    });
  }
  
  for(var a=0;a<drawing_edge_array.length;a++){
      var temp=drawing_edge_array[a].split(",");
      edge_array.push({
        data: {id: drawing_edge_array[a], source: temp[0], target: temp[1]}
        //data: {source: temp[0], target: temp[1]}
      });
    }
    
    return [node_array, edge_array];
}

function make_node_string(node_array){
  var node_string="";
  for(var a=0;a<node_array.length;a++){
    if(a==node_array.length-1){
      node_string=node_string+node_array[a];
    }
    else{
      node_string=node_string+node_array[a]+",";
    }
  }
  return node_string;
}

function setAll(){
      //變數checkItem為checkbox的集合
  var checkItem = document.getElementsByName("input_node[]");
  var checkAll = document.getElementsByName("checkAll"); 
  if(!checkAll.checked){
    var check = false;
    for(var i=0;i<checkItem.length;i++){
      if(checkItem[i].checked == false){
        checkItem[i].checked=true; 
        check = true;
      }
    }
    if(check == false){
      for(var j=0;j<checkItem.length;j++){
        checkItem[j].checked=false;
      }
    }
  }
  else if(checkAll.checked){
    for(var j=0;j<checkItem.length;j++){
        checkItem[j].checked=false;
      }
  }
}


function passNodeNames(){  //當輸入時觸發test_ajax()並且傳入輸入框的值當參數
  test_ajax_forNodeNames($('#InputText').val());  //test_ajax()由ajax_example.js引入
}

function example(){
  document.getElementById("InputText").value="MAP2K4\nFLNC\nRPA2\nSTAT3";
}


//doing ajax
var http_request=false;
    function test_ajax_forNodeNames(variable){
        http_request=false;
        if(window.XMLHttpRequest){
            http_request=new XMLHttpRequest();
            if(http_request.overrideMimeType){
                http_request.overrideMimeType('text/xml');
            }
        }else if(window.ActiveXObject){
            try{ //6.0+
                http_request=new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch(e){
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

//this is where we apply opacity to the arrow
$(window).scroll( function(){

  //get scroll position
  var topWindow = $(window).scrollTop();
  //multipl by 1.5 so the arrow will become transparent half-way up the page
  var topWindow = topWindow * 1.5;
  
  //get height of window
  var windowHeight = $(window).height();
      
  //set position as percentage of how far the user has scrolled 
  var position = topWindow / windowHeight;
  //invert the percentage
  position = 1 - position;

  //define arrow opacity as based on how far up the page the user has scrolled
  //no scrolling = 1, half-way up the page = 0
  $('.arrow-wrap').css('opacity', position);

});


//Code stolen from css-tricks for smooth scrolling:
$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
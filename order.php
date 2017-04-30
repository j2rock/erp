<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-cn" />
<link rel="stylesheet" type="text/css" href="/erp/css/c1.css" />
<script type="text/javascript">
function showsku(schby, tag){
var xmlhttp;    
if (schby=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }

xmlhttp.open("GET","/erp/prdsch.php?by="+schby+"&t="+tag,true);
xmlhttp.send();
}

function selectAll(){
// 这个函数写在getSKU.php里面时不能使用，估计是这时函数在txtHint这个div里是不能用的
	
	var a = document.getElementsByTagName("input");
	for(var i = 0;i<a.length;i++){
//		if(a[i].type=="checkbox"){ 不用判断了，反正这个页面剩下的input都是checkbox，简单处理
		var j=0; //j用来判断r0找到了没，找到了就不用再找了，让j=1，做好内循环后，退出外循环
		if(a[i].name=="r0"){//找到全选的复选框，就把剩下的每个复选框全部处理
			j=1;
			if(a[i].checked){//如果点了全选
				for(i;i<a.length;i++){
					a[i].checked = true;
				}
			}
			else{//如果点了取消全选
				for(i;i<a.length;i++){
					a[i].checked = false;
				}
			}
		}
		if(j==1){break;} //找到全选的复选框并处理之后就可以退出循环了	
	}
}

</script>
</head>
<body>
<header><h2>ERP</h2></header>
<nav>
<ul>
<li><a href="/">首页</a></li>
<li><a href="/erp/jsq.htm" target="_blank">计算器</a></li>
</ul>
</nav>
<section>
<div>
SKU：<input type="text" id="sku" value=""/>
<button onfocus="showsku(sku.value, 0)" >搜索</button>
中文名：<input type="text" id="cn" value=""/>
<!-- 在IE里输入中文搜索结果为0 -->
<button onfocus="showsku(cn.value, 1)" >搜索</button> 
</div>
<br />
<br />
<div id="txtHint">搜索结果将在此处列出 ...</div>
</section>

</body>
</html>
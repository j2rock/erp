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
// �������д��getSKU.php����ʱ����ʹ�ã���������ʱ������txtHint���div���ǲ����õ�
	
	var a = document.getElementsByTagName("input");
	for(var i = 0;i<a.length;i++){
//		if(a[i].type=="checkbox"){ �����ж��ˣ��������ҳ��ʣ�µ�input����checkbox���򵥴���
		var j=0; //j�����ж�r0�ҵ���û���ҵ��˾Ͳ��������ˣ���j=1��������ѭ�����˳���ѭ��
		if(a[i].name=="r0"){//�ҵ�ȫѡ�ĸ�ѡ�򣬾Ͱ�ʣ�µ�ÿ����ѡ��ȫ������
			j=1;
			if(a[i].checked){//�������ȫѡ
				for(i;i<a.length;i++){
					a[i].checked = true;
				}
			}
			else{//�������ȡ��ȫѡ
				for(i;i<a.length;i++){
					a[i].checked = false;
				}
			}
		}
		if(j==1){break;} //�ҵ�ȫѡ�ĸ�ѡ�򲢴���֮��Ϳ����˳�ѭ����	
	}
}

</script>
</head>
<body>
<header><h2>ERP</h2></header>
<nav>
<ul>
<li><a href="/">��ҳ</a></li>
<li><a href="/erp/jsq.htm" target="_blank">������</a></li>
</ul>
</nav>
<section>
<div>
SKU��<input type="text" id="sku" value=""/>
<button onfocus="showsku(sku.value, 0)" >����</button>
��������<input type="text" id="cn" value=""/>
<!-- ��IE�����������������Ϊ0 -->
<button onfocus="showsku(cn.value, 1)" >����</button> 
</div>
<br />
<br />
<div id="txtHint">����������ڴ˴��г� ...</div>
</section>

</body>
</html>
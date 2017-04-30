<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-cn" />
<link rel="stylesheet" type="text/css" href="/erp/css/c1.css" />
</head>
<body>
<header><h2>ERP</h2></header>
<nav>
<ul>
<li><a href="/">首页</a></li>
<li><a href="/erp/product.php">产品</a></li>
<li><a href="/erp/jsq.htm" target="_blank">计算器</a></li>
</ul>
</nav>
<section>
<?php
//header("Content-type: text/html; charset=utf-8"); 
$q=$_GET["q"];
@$c=$_GET["c"];
@$p=$_GET["p"]; //加上@是为了不报错，p未定义
@$l=$_GET["l"];
@$n=$_GET["n"];
@$w=$_GET["w"];
@$s=$_GET["s"];
$con = mysql_connect('localhost', 'root', 'root');
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }
mysql_select_db("erp", $con);

$sql="select * from product WHERE SKU='".$q."'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

//第一次载入页面时p从上页定义了值为0，不要执行update，如果修改了价格后，sp不等于0，才修改
$i=0;
if($p!=0){
	//省略：验证$p是不是数字
	if($p!=$row['SUPPLIER_PRICE']){
		//	出错：因为没有给$q包上单引号，导致虽然纯数字sku可以，但是字符串sku不可以更新
		$sql="update product set SUPPLIER_PRICE=".$p." WHERE SKU='".$q."'";
		mysql_query($sql); $i++;
	}
	if($c!=$row['NAME_CN']){
		$sql="update product set NAME_CN='".$c."' WHERE SKU='".$q."'";
		mysql_query($sql); $i++;
	}
	if($l!=$row['SUPPLIER_LINK']){
		$sql="update product set SUPPLIER_LINK='".$l."' WHERE SKU='".$q."'";
		mysql_query($sql); $i++;
	}
	if($n!=$row['SUPPLIER_NAME']){
		$sql="update product set SUPPLIER_NAME='".$n."' WHERE SKU='".$q."'";
		mysql_query($sql); $i++;
	}
	if($w!=$row['WEIGHT']){
		$sql="update product set WEIGHT='".$w."' WHERE SKU='".$q."'";
		mysql_query($sql); $i++;
	}
	if($s!=$row['SHELF_POSITION']){
		$sql="update product set SHELF_POSITION='".$s."' WHERE SKU='".$q."'";
		mysql_query($sql); $i++;
	}
	//省略：验证update后的数据库数据与表单数据是否一致，否则更新失败
}
//取出更新后的信息并显示
if($i>0){
	echo "<div style=\"color:#0000FF\">你修改了 ".$i." 个数据</div>";
	$sql="select * from product WHERE SKU='".$q."'";
	//$sql="select * from product where sku=".$q;
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
}

echo "<form id=\"revsku\" action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" method=\"get\">"; //提交到本页，不用跳转
//为了把sku也作为参数传递到下个页面使用，加上了<input name=\"sku\">，但是不显示为输入框形式，所以HIDDEN
echo   "<h2>SKU 查看与修改</h2>";
echo   "<ul>";
echo   "<li><p><strong>SKU&nbsp;&nbsp;: <input name=\"q\" hidden value=\"".$q."\">".$q."</strong></p></li>";
echo   "<li><p>中文名&nbsp;: <input name=\"c\" value=\"".$row['NAME_CN']."\"></p></li>";
echo   "<li><p>采购价&nbsp;: <input name=\"p\" value=\"".$row['SUPPLIER_PRICE']."\"></p></li>";//p 指供应商价格或者叫采购价
echo   "<li><p>采购链接: <input name=\"l\" value=\"".$row['SUPPLIER_LINK']."\"></p></li>";
echo   "<li><p>供应商&nbsp;: <input name=\"n\" value=\"".$row['SUPPLIER_NAME']."\"></p></li>";
echo   "<li><p>重量克&nbsp;: <input name=\"w\" value=\"".$row['WEIGHT']."\"></p></li>";
echo   "<li><p>货架&nbsp;&nbsp;: <input name=\"s\" value=\"".$row['SHELF_POSITION']."\"></p></li>";
echo   "</ul>";
/*echo   "<br /><br />";
//点击提交如何不跳转页面，而只是出现一个提示成功失败的弹窗，或一行字
echo   "<input align=type=\"submit\" value=\"修改\" />";
echo "</form>";
*/

mysql_close($con);
?>
<br />
<input type="submit" value="修改" />

</form>
<br />
<a href="javascript:history.back(-1)">返回</a>
</section>
</body>
</html>

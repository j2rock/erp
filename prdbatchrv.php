<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-cn" />
<link rel="stylesheet" type="text/css" href="/erp/css/c1.css" />
</head>
<body>
<!--
从有打钩的找出sku：循环每个传过来的checkbox项，如果checked，则寻找通过DOM找到相应的sku
逐个列出待改项，填写，
确定提交更新数据库
-->
<header><h2>ERP</h2></header>
<nav>
<ul>
<li><a href="/">首页</a></li>
<li><a href="/erp/product.php">产品</a></li>
<li><a href="/erp/jsq.htm" target="_blank">计算器</a></li>
</ul>
</nav>
<section>

<form id=\"revisesku\" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get"> 
<table>
<tr>
<th>SKU</th>
<th>中文名</th>
<th style="width:5%">采购价</th>
<th>产品链接</th>
<th>供应商</th>
<th style="width:5%">重量克</th>
<th style="width:4%">货架</th>
<th>结果</th>
</tr>

<?php

$con = mysql_connect('localhost', 'root', 'root');
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }
mysql_select_db("erp", $con);

for($j=1; $j<=$_GET["sum"]; $j++){//find those skus
	//how to get  sku base on ri, unless pass arry[ri]=sku,
	if(@$_GET["r".$j]=="on"){
		$sku=$_GET["sku".$j];//get the sku
		//these stored new input info.
		@$c=$_GET["c".$j];
		@$p=$_GET["p".$j]; //加上@是为了不报错，p未定义
		@$l=$_GET["l".$j];
		@$n=$_GET["n".$j];
		@$w=$_GET["w".$j];
		@$s=$_GET["s".$j];
		//get info of this sku.
		$sql="select * from product WHERE SKU='".$sku."'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);

		$i=0;
		if($p!=0){ // ## In fact $p can be 0, should be ($p!=0 || $c!=0 || $l!=0 || $n!=0 || $w!=0 || $s!=0)
			//省略：验证$p是不是数字
			if($p!=$row['SUPPLIER_PRICE']){
				//	出错：因为没有给$q包上单引号，导致虽然纯数字sku可以，但是字符串sku不可以更新
				$sql="update product set SUPPLIER_PRICE=".$p." WHERE SKU='".$sku."'";
				mysql_query($sql); $i++;
			}
			if($c!=$row['NAME_CN']){
				$sql="update product set NAME_CN='".$c."' WHERE SKU='".$sku."'";
				mysql_query($sql); $i++;
			}
			if($l!=$row['SUPPLIER_LINK']){
				$sql="update product set SUPPLIER_LINK='".$l."' WHERE SKU='".$sku."'";
				mysql_query($sql); $i++;
			}
			if($n!=$row['SUPPLIER_NAME']){
				$sql="update product set SUPPLIER_NAME='".$n."' WHERE SKU='".$sku."'";
				mysql_query($sql); $i++;
			}
			if($w!=$row['WEIGHT']){
				$sql="update product set WEIGHT='".$w."' WHERE SKU='".$sku."'";
				mysql_query($sql); $i++;
			}
			if($s!=$row['SHELF_POSITION']){
				$sql="update product set SHELF_POSITION='".$s."' WHERE SKU='".$sku."'";
				mysql_query($sql); $i++;
			}
		}
		
		if($i>0){  // If some data was updated, then $i>0, select new data and print out.
			
			$sql="select * from product WHERE SKU='".$sku."'";
			//$sql="select * from product where sku=".$s;
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
		}
		//show info of this sku, 如果发现不是修改后的数据，则有错误或者，没有修改就提交
		echo "<tr>"; //add this two hidden input so that when submit, $_GET["sku".$j] and $_GET["r".$j] can be used.
		echo   "<td><input hidden name=\"sku".$j."\" value=\"".$sku."\" /><input hidden name=\"r".$j."\" value=\"on\" />".$sku."</td>";
		echo   "<td><input class='fullwidth' name=\"c".$j."\" value=\"".$row['NAME_CN']."\"></td>";
		echo   "<td><input class='fullwidth' name=\"p".$j."\" value=\"".$row['SUPPLIER_PRICE']."\"></td>";//p 指供应商价格或者叫采购价
		echo   "<td><input class='fullwidth' name=\"l".$j."\" value=\"".$row['SUPPLIER_LINK']."\"></td>";
		echo   "<td><input class='fullwidth' name=\"n".$j."\" value=\"".$row['SUPPLIER_NAME']."\"></td>";
		echo   "<td><input class='fullwidth' name=\"w".$j."\" value=\"".$row['WEIGHT']."\"></td>";
		echo   "<td><input class='fullwidth' name=\"s".$j."\" value=\"".$row['SHELF_POSITION']."\"></td>";
		if($i==0){
			echo "<td><div style=\"color:#FF0000\">采购价为必填</div></td>";
		}else{
			echo "<td><div style=\"color:#0000FF\">你修改了 ".$i." 个数据</div></td>";
		}
		echo "</tr>";
	}
	
}// end for: one sku info ends
//sum也要再次提交，更新sku时还要用它来循环
echo "<input hidden type=\"text\" name=\"sum\" value=\"".$_GET["sum"]."\" />";

mysql_close($con);

?>
</table>

<p><input type="submit" value="修改" /></p>
<p>* 如果提交修改后跳回原来的数据，则出现系统错误，请联系管理员</p>
</form>

<p><a href="javascript:history.back(-1)">返回</a></p>
</section>
</body>
</html>


<html>
<head>
<!--
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-cn" />
<link rel="stylesheet" type="text/css" href="/css/c1.css" />
当meta charset=gb2312时，html输出的中文没问题，但php输出的中文乱码，应该是因为数据库的编码设置为utf-8，
所以php输出的编码也是utf-8，两者有冲突，而以先顶一顶gb2312为准。
    但是把meta的charset改成utf-8时，php输出没问题，但是html输出全乱码，记事本另存为编码utf-8解决 -->
</head>
<body>
<form action="/erp/prdbatchrv.php" method="GET" >
<p><input type="submit" value="批量修改" /> </p>
<!--在原页面上面跳出修改页面，修改后刷新原页面 （困难，放弃） -->
<table>
<tr>
<th><input type="checkbox" name="r0" onclick="selectAll()" /></th>
<th style="width:300px;">图片</th>
<th style="width:10%">SKU</th>
<th>中文名</th>
<th style="width:5%">采购价</th>
<th>产品链接</th>
<th>供应商</th>
<th style="width:5%">重量克</th>
<th>创建时间</th>
<th style="width:4%">货架</th>
</tr>
<?php
$by=$_GET["by"];//search by this value
$t=$_GET["t"]; //indicate what kind the value is

$con = mysql_connect('localhost', 'root', 'root');
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }
mysql_select_db("erp", $con);

if($t==0){ //search by the sku value
	$sql="SELECT * FROM product WHERE SKU LIKE '".$by."%' or SKU LIKE ' ".$by."%'"; 
//纯数字的sku查不出来，格式不是varchar吗？只好先加 or sku=".$q
}else if($t==1){ //search by the chinese name
	$sql="SELECT * FROM product WHERE NAME_CN LIKE '%".$by."%'";
}else{
	return "不是sku也不是中文名？";
}
$result = mysql_query($sql);

//复选框序号，第一个全选，name=r0
$i=0; 
while($row = mysql_fetch_array($result))
 {
 $s=$row['SKU']; $i++; //从r1开始是每个搜索结果的复选框的name
 echo "<tr>";
 echo "<td><center><input type=\"checkbox\" name=\"r".$i."\" /></center></td>";
 echo "<td><img src=\"" . $row['PICTURE1'] . "\" width=\"300\" /></td>";
 // an input hidden here so that it can send the value of this sku to the link page
 echo "<td><a href=\"/erp/prdrv.php?q=".$s."\" target=\"_blank\">" . $s . "</a><input hidden type=\"text\" name=\"sku".$i."\" value=\"".$s."\" /></td>"; 
 echo "<td>" . $row['NAME_CN'] . "</td>";
 echo "<td>" . $row['SUPPLIER_PRICE'] . "</td>";
 echo "<td><a href=\"" . $row['SUPPLIER_LINK'] . "\" target=\"view_window\">" . $row['SUPPLIER_LINK'] . "</a></td>";
 echo "<td>" . $row['SUPPLIER_NAME'] . "</td>";
 echo "<td>" . $row['WEIGHT'] . "</td>";
 echo "<td>" . $row['CREATE_TIME'] . "</td>";
 echo "<td>" . $row['SHELF_POSITION'] . "</td>";
 echo "</tr>";
//if checked echo hidden input?".$i." 
 }
echo "</table>";
echo "<p>共 <input hidden type=\"text\" name=\"sum\" value=\"".$i."\" />".$i." 个搜索结果</p>";

mysql_close($con);

?>

<p><input type="submit" value="批量修改" /></p>
</form>

</body>
</html>
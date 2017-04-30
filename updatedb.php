<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-cn" />
</head>
<body>

<?php

$con = mysql_connect('localhost', 'root', 'root');
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }
mysql_select_db("erp", $con);

//$sql="update product set name_cn='Y镂空金属贴花 61mm', status='商品清仓', category='摩托车配件', warehouse='默认仓库' where sku=' 001'";mysql_query($sql);



echo "dd";

mysql_close($con);

?>
</body>
</html>
<?php

if (!$link = mysql_connect('localhost', 'root', 'root')) {
	echo 'Could not connect to mysql';
	exit;
}

if (!mysql_select_db('northwind', $link)) {
    echo 'Could not select database';
    exit;
}

$_array_cat=array("Beverages","Condiments","Confections","Dairy Products","Grains/Cereals","Meat/Poultry","Produce","Seafood");
$_category = "";

if(isset($_GET['category'])) $_category  = $_GET['category'];

$sql    = 'select distinct b.*, a.CategoryName from Categories a ' .
	'inner join Products b on a.CategoryID = b.CategoryID ' .
	'where b.Discontinued=\'N\' and a.CategoryName=\''. 
	$_category . '\' order by b.ProductName;';

if ($_category!="") { 
	$result = mysql_query($sql, $link);
	if (!$result) $_category = "";
}

if ($_category=="") {
	print "<form action=\"" . $_SERVER['PHP_SELF'] . "\">\n";
	print "please select a product\n";
	print "<select name=\"category\" onchange=\"this.form.submit()\">\n";
	if ($_category=="") print "<option value=\"\">choice products</option>\n";
	foreach ($_array_cat as $value) {
		print "<option value=\"". $value . "\">". $value . "</option>\n";
	}
	print "</select>\n";
	print "</form>\n";
	exit;
}

print "<form action=\"" . $_SERVER['PHP_SELF'] . "\">\n";
print "List of selected products :";
print "<select name=\"category\" onchange=\"this.form.submit()\">\n";
foreach ($_array_cat as $value) {
	$options = "";
	if ($_category==$value) $options = " selected ";
	print "<option value=\"". $value . "\"" . $options . ">". 
		$value . "</option>\n";
}
print "</select>\n";
print "</form><br>\n";

print "<table border=1 cellpadding=5 cellspacing=0>\n";
print "\t<tr>\n\t\t<td>ProductID</td><td>ProductName</td>" . 
	"<td>SupplierID</td><td>CategoryID</td><td>QuantityPerUnit</td>".
	"<td>UnitPrice</td><td>UnitsInStock</td><td>UnitsOnOrder</td>".
	"<td>ReorderLevel</td><td>Discountinued</td><td>CategoryName</td>".
	"\n\t</tr>";

while ($row = mysql_fetch_assoc($result)) {
    print "\t<tr>\n\t\t<td>" . $row['ProductID'] . "</td><td>" . 
	$row['ProductName'] . "</td><td>" . $row['SupplierID'] . "</td><td>" .
	$row['CategoryID'] . "</td><td>" . $row['QuantityPerUnit'] . "</td><td>" .
	$row['UnitPrice'] . "</td><td>" . $row['UnitsInStock'] . "</td><td>" .
	$row['UnitsOnOrder'] . "</td><td>" . $row['ReorderLevel'] . "</td><td>" .
	$row['Discontinued'] . "</td><td>" . $row['CategoryName'] .
	"</td>\n\t</tr>\n";
}
print "</table>\n";

mysql_free_result($result);
?>

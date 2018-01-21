<?php

if (!$link = mysql_connect('localhost', 'root', 'root')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db('northwind', $link)) {
    echo 'Could not select database';
    exit;
}

$_sort = "CategoryName";
if (isset($_GET['sort'])) $_sort = $_GET['sort'];

$_year="1997";

$sql = 'select CategoryName, format(sum(ProductSales), 2) as CategorySales ';
$sql .= 'from';
$sql .= '(';
$sql .= '    select distinct a.CategoryName,';
$sql .= '        b.ProductName,';
$sql .= '        format(sum(c.UnitPrice * c.Quantity * (1 - c.Discount)), 2) as ProductSales,';
$sql .= '        concat(\'Qtr \', quarter(d.ShippedDate)) as ShippedQuarter';
$sql .= '    from Categories as a';
$sql .= '    inner join Products as b on a.CategoryID = b.CategoryID';
$sql .= '    inner join `Order Details` as c on b.ProductID = c.ProductID';
$sql .= '    inner join Orders as d on d.OrderID = c.OrderID ';
$sql .= '    where year(d.ShippedDate)=\'' . $_year . '\'';
$sql .= '    group by a.CategoryName, ';
$sql .= '        b.ProductName, ';
$sql .= '        concat(\'Qtr \', quarter(d.ShippedDate))';
$sql .= '    order by a.CategoryName, ';
$sql .= '        b.ProductName, ';
$sql .= '        ShippedQuarter';
$sql .= ') as x ';
$sql .= 'group by CategoryName ';
$sql .= 'order by '. $_sort;

$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

print "Category Sales for " . $_year . "<br>";
print "Order by " . $_sort . "<br><br>\n";
print "CategoryName : CategorySales\n<br><br>";
print "<table border=1 cellpadding=5 cellspacing=0>\n";
while ($row = mysql_fetch_assoc($result)) {
    print "\t<tr>\n\t\t<td>" . $row['CategoryName'] . "</td><td>" . $row['CategorySales'] . "</td>\n\t</tr>\n";
}
print "</table>\n";

mysql_free_result($result);

?>

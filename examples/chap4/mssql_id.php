<?php

if (!$link = mssql_connect('mssql', 'sa', 'pentest1!')) {
	echo 'Could not connect to mssql';
	exit;
}

if (!mssql_select_db('northwind', $link)) {
    echo 'Could not select database';
    exit;
}

if(!isset($_GET['empid'])) {
 $_empid=1;
} else {
 $_empid  = $_GET['empid'];
}

$sql    = 'SELECT * FROM Employees WHERE EmployeeID='. $_empid;
$result = mssql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MSSQL Error: ' . mssql_error();
    exit;
}

$row = mssql_fetch_assoc($result);
print "<b>직원정보</b><br><br>";
print "<table border=1 cellpadding=5 cellspacing=0>\n";
print "\t<tr>\n\t\t<td>직원번호</td><td>" . str_pad($row['EmployeeID'],8,"0",STR_PAD_LEFT) . "</td>\n";
print "\t<tr>\n\t\t<td>이름</td><td>" . $row['FirstName'] . "</td></tr>\n";
print "\t<tr>\n\t\t<td>직급</td><td>" . $row['Title'] . "</td>\n";
print "\t<tR>\n\t\t<td>입사일자</td><td>" . $row['HireDate'] . "</td>\n\t</tr>\n";
print "</table>\n";

mssql_close($link);
?>

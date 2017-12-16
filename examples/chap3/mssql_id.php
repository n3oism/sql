<?php

if (!$link = mssql_connect('mssql', 'sa', 'pentest1!')) {
	echo 'Could not connect to mssql';
	exit;
}

if (!mssql_select_db('northwind', $link)) {
    echo 'Could not select database';
    exit;
}

$_empid  = $_GET['empid'];
$sql    = 'SELECT * FROM Employees WHERE EmployeeID='. $_empid;
$result = mssql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MSSQL Error: ' . mssql_error();
    exit;
}

print "<table border=1 cellpadding=5 cellspacing=0>\n";
print "\t<tr>\n\t\t<td>Employee ID</td><td>First Name</td><td>Title</td><td>Hire Date</td>\n\t</tr>";

$row = mssql_fetch_assoc($result);
print "\t<tr>\n\t\t<td>" . $row['EmployeeID'] . "</td><td>" . $row['FirstName'] . "</td><td>" . $row['Title'] . "</td><td>" . $row['HireDate'] . "</td>\n\t</tr>\n";
print "</table>\n";

mssql_close($link);
?>

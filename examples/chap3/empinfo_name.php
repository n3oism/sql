<?php

if (!$link = mysql_connect('localhost', 'root', 'root')) {
	echo 'Could not connect to mysql';
	exit;
}

if (!mysql_select_db('northwind', $link)) {
    echo 'Could not select database';
    exit;
}

$_empname  = $_GET['empname'];
$sql    = 'SELECT * FROM Employees WHERE FirstName like \'%' . $_empname . '%\'';
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

print "<table border=1 cellpadding=5 cellspacing=0>\n";
print "\t<tr>\n\t\t<td>Employee ID</td><td>First Name</td><td>Title</td><td>Hire Date</td>\n\t</tr>";

while ($row = mysql_fetch_assoc($result)) {
    print "\t<tr>\n\t\t<td>" . $row['EmployeeID'] . "</td><td>" . $row['FirstName'] . "</td><td>" . $row['Title'] . "</td><td>" . $row['HireDate'] . "</td>\n\t</tr>\n";
}
print "</table>\n";

mysql_free_result($result);
?>

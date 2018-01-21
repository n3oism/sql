<html>
<title>Pentest Example</title>
<body>
MSSQL 2017 : SQL Injection in INSERT Query
<br><br>
<hr>
<form action='/mssql_user_insert.php' method='post'>
USER ID : <input type='text' length='3' name='id'>&nbsp;USER NAME : <input type='text' length='3' name='name'>&nbsp;<input type='submit' value='ADD'>
</form>
<hr>
<br>
<br>
<?php
if (!$link = mssql_connect('mssql', 'sa', 'pentest1!')) {
	echo 'Could not connect to mssql';
	exit;
}

if (!mssql_select_db('northwind', $link)) {
    echo 'Could not select database';
    exit;
}

$sql ="IF NOT EXISTS(select * from sysobjects where name='users' and xtype=0x55)" .
        "CREATE TABLE users" .
        "(idx int identity(1,1) PRIMARY KEY," .
		"id   varchar(10)," .
		"name varchar(25)," .
		"lvl  int)";
$result = mssql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MSSQL Error: ' . mssql_error();
    exit;
}

$_id = '';
$_name = '';
if (isset($_POST['id'])) $_id = $_POST['id'];
if (isset($_POST['name'])) $_name = $_POST['name'];

$sql="INSERT INTO users (id,name,lvl) values ('$_id','$_name',9)";

if ($_id!='') $result = mssql_query($sql, $link);

$sql ="select * from users";
$result = mssql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MSSQL Error: ' . mssql_error();
    exit;
}

print "<table border='1' cellpadding='5' cellspacing='0'>";
print "<tr><td width='50'>NUM</td><td width='120'>ID</td><td width='240'>Name</td></tr>";

while ($row = mssql_fetch_assoc($result)) {
	print "<tr><td>" . $row["idx"] . "</td><td>" . $row["id"] . "</td><td>"  . $row["name"] . "</td></tr>";
}
print "</table>\n";

mssql_close($link);
?>
</html>
<html>
<title>Pentest Example</title>
<body>
<script language='javascript'>
    function edit(idx){
        document.webform.idx.value=idx;
		document.webform.submit();
    }
</script>

MSSQL 2017 : SQL Injection in DELETE Query
<br><br>
<form action='/mssql_user_del.php' method='post' name='webform'>
   <input type='hidden' name='idx'>
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

$_idx = 0;
if (isset($_POST['idx'])) $_idx = $_POST['idx'];

if ($_idx!=0) {
	$sql="delete from users where idx=" . $_idx;
	mssql_query($sql, $link);
}

$sql ="select * from users";
$result = mssql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MSSQL Error: ' . mssql_error();
    exit;
}

print "<table border='1' cellpadding='5' cellspacing='0'>";
print "<tr><td width='50'>NUM</td><td width='120'>ID</td><td width='240'>Name</td><td width='50'>Del</td></tr>";

while ($row = mssql_fetch_assoc($result)) {
	print "<tr><td>" . $row["idx"] . "</td><td>" . $row["id"] . "</td><td>"  . $row["name"] . "</td><td><input type=\"button\" onClick=\"edit('"  . $row["idx"] . "')\" value=\"Del\"></td></tr>";
}
print "</table>\n";

mssql_close($link);
?>
</html>
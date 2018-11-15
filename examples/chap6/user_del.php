<?php

if (!$link = mysql_connect('localhost', 'root', 'root')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db('test', $link)) {
    echo 'Could not select database';
    exit;
}

$queryCheck="select 1 from users";
$result = mysql_query($queryCheck, $link);

if($result == FALSE){
    $createQuery="CREATE TABLE USERS (" .
		 "idx int(11) AUTO_INCREMENT PRIMARY KEY," .
		 "ID varchar(12) NOT NULL," .
		 "NAME varchar(25) NOT NULL," .
		 "LEVEL int(2) NOT NULL);";
    $result = mysql_query($createQuery, $link);
}

echo "<script language='javascript'>\n";
echo "    function edit(idx,id,name){\n";
echo "        document.webform.idx.value=idx;\n";
echo "        document.webform.submit();\n";
echo "    }\n";
echo "</script>\n";

echo "MySQL : SQL Injection in DELETE Query<br><br>\n";
//echo "<hr>";
echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' name='webform'>\n";
echo "    <input type='hidden' name='idx'>\n";
echo "</form>\n";
echo "<hr>\n<br>\n<br>\n";

$_idx='';
if (isset($_POST['idx'])) $_idx = $_POST['idx'];

$sql = "delete from USERS where idx=$_idx";
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

echo 'Record Deleted : ' . mysql_affected_rows();

$sql = "select * from USERS";
$result = mysql_query($sql, $link);

print "<table border=1 cellpadding=5 cellspacing=0>\n";
print "\t<tr>\n\t\t<td width='50'>num</td><td width='120'>id</td><td width='240'>name</td><td width='50'>Edit</td>\n\t</tr>\n";

while ($row = mysql_fetch_assoc($result)) {
    print "\t<tr>\n\t\t<td>" . $row['idx'] . "</td><td>" . $row['ID'] . "</td><td>" . $row['NAME'] . "</td><td><input type='button' onClick=\"edit('" . $row['idx'] . "')\" value='Del'></td>\n\t</tr>\n";
}
print "</table>\n";

mysql_free_result($result);

?>

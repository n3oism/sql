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

echo "MySQL : Blind SQL Injection in INSERT Query<br><br>\n";
echo "<hr>\n";
echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>\n";
echo "USER ID : <input type='text' length='3' name='id'>&nbsp;";
echo "USER NAME : <input type='text' length='3' name='name'>&nbsp;";
echo "<input type='submit' value='ADD'>\n";
echo "</form>\n";
echo "<hr>\n<br>\n<br>\n";

$_id = '';
$_name = '';
if (isset($_POST['id'])) $_id = $_POST['id'];
if (isset($_POST['name'])) $_name = $_POST['name'];

$sql = "insert into USERS (id,name) select '$_id','$_name' from dual where (select count(*) from USERS Where id='$_id')=0";

if ($_id!='') $result = mysql_query($sql, $link);

echo 'Record Inserted : ' . mysql_affected_rows();

$sql = "select * from USERS";
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
	
print "<table border=1 cellpadding=5 cellspacing=0>\n";
print "\t<tr>\n\t\t<td width='50'>num</td><td width='120'>id</td><td width='240'>name</td>\n\t</tr>\n";

while ($row = mysql_fetch_assoc($result)) {
	print "\t<tr>\n\t\t<td>" . $row['idx'] . "</td><td>" . $row['ID'] . "</td><td>" . $row['NAME'] . "</td>\n\t</tr>\n";
}
print "</table>\n";

mysql_free_result($result);
?>

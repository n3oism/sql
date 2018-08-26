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
echo "        document.webform.id.value=id;\n";
echo "        document.webform.name.value=name;\n";
echo "        document.webform.btnSubmit.disabled=false;\n";
echo "    }\n";
echo "</script>\n";

echo "MySQL : SQL Injection in UPDATE Query<br><br>\n";
echo "<hr>\n";
echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' name='webform'>\n";
echo "    <input type='hidden' name='idx'>\n";
echo "    USER ID : <input type='text' length='3' name='id'>&nbsp;";
echo "USER NAME : <input type='text' length='3' name='name'>&nbsp;";
echo "<input type='submit' value='Update' name='btnSubmit' disabled='true'>\n";
echo "</form>\n";
echo "<hr>\n<br>\n<br>\n";

if (isset($_POST['idx'])) $_idx = $_POST['idx'];
if (isset($_POST['id'])) $_id = $_POST['id'];
if (isset($_POST['name'])) $_name = $_POST['name'];

if (!empty($_idx) and !empty($_id) and !empty($_name)){
    $sql = "update USERS set id='$_id',name='$_name' where idx=$_idx";

    $result = mysql_query($sql, $link);

    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        exit;
    }
}

$sql = "select * from USERS";
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

print "<table border=1 cellpadding=5 cellspacing=0>\n";
print "\t<tr>\n\t\t<td width='50'>num</td><td width='120'>id</td><td width='240'>name</td><td width='50'>Edit</td>\n\t</tr>";

while ($row = mysql_fetch_assoc($result)) {
    print "\t<tr>\n\t\t<td>" . $row['idx'] . "</td><td>" . $row['ID'] . "</td><td>" . $row['NAME'] . "</td><td><input type='button' onClick=\"edit('" . $row['idx'] . "','" . $row['ID'] . "','" . $row['NAME'] . "')\" value='Edit'></td>\n\t</tr>\n";
}
print "</table>\n";

mysql_free_result($result);

?>

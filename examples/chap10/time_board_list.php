<?php

$mysqli = new mysqli('localhost', 'root', 'root', 'northwind');

if (mysqli_connect_errno()) {
    printf("Connection failed: %s\n",mysqli_connect_error());
    exit;
}

$queryCheck="select 1 from board";
$result = $mysqli->query($queryCheck);

if($result == FALSE){
    $createQuery="CREATE TABLE board (" .
		 "idx int(11) AUTO_INCREMENT PRIMARY KEY," .
		 "writer VARCHAR(10) NOT NULL," .
		 "email VARCHAR(30)," .
		 "subject VARCHAR(50) NOT NULL," .
		 "passwd VARCHAR(12) NOT NULL," .
		 "reg_date DATETIME NOT NULL," .
		 "readcount INT DEFAULT 0," .
		 "content TEXT NOT NULL," .
		 "ip VARCHAR(20) NOT NULL);";
    $result = $mysqli->query($createQuery);
}

$_search = "";

if(isset($_GET['subject'])) $_search  = $_GET['subject'];

$sql    = 'select * from board where subject=\'' . $_search . '\'';

if ($_search!="") {
	if(strpos($_search,"union")==FALSE) $result = $mysqli->query($sql);
}

print "<form action=\"" . $_SERVER['PHP_SELF'] . "\">\n";
print "제목검색 : ";
print "<input type=\"text\" name=\"subject\" value=\"" . $_search . "\">&nbsp;";
print "<input type=\"submit\" value=\"검색\">";
print "</form>\n";

print "<table border=1 cellpadding=5 cellspacing=0>\n";
print "\t<tr>\n\t\t<td width=\"20\">num</td>". 
	"<td width=\"220\">subject</td>" . 
	"<td width=\"80\">writer</td>" . 
	"<td width=\"80\">date</td>" . 
	"<td width=\"20\">count</td>\n\t</tr>";

if ($result) {
	while ($row = $result->fetch_row()) {
		print "\t<tr>\n\t\t<td>" . $row['idx'] . "</td><td>" . 
		$row['subject'] . "</td><td>" . $row['writer'] . "</td><td>" .
		$row['reg_date'] . "</td><td>" . $row['readcount'] . "\n\t</tr>\n";
	}
	$mysqli->close();
}
print "</table>\n";
?>

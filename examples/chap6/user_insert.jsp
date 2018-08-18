<%@ page contentType="text/html; charset=euc-kr" %>
<%@ include file="dbcon.jsp" %>
<%@ page import="java.util.*,java.text.*"%>

<html>
<head>
<title>test</title>
</head>
<body>
Oracle 11g : SQL Injection in INSERT Query
<br><br>
<hr>
<form action='/user_insert.jsp' method='post'>
USER ID : <input type='text' length='3' name='id'>&nbsp;USER NAME : <input type='text' length='3' name='name'>&nbsp;<input type='submit' value='ADD'>
</form>
<hr>
<br>
<br>
<table border=1 cellpadding=5 cellspacing=0>
	<tr>
		<td width='50'>NUM</td>
		<td width='120'>ID</td>
		<td width='240'>NAME</td>
	<tr>
 <%
   try{
       sql = "select 1 from users";
       stmt = con.createStatement();
       stmt.executeQuery(sql);
   } catch(Exception e){
       sql = "CREATE TABLE users"
           + "(idx  number(5),"
	   + " id   varchar(10),"
	   + " name varchar(25),"
	   + " lvl  number(2))";
     stmt = con.createStatement();
     stmt.executeQuery(sql);
   }

   String _id = request.getParameter("id");
   String _name = request.getParameter("name");

   if (_id != null && _name != null) {
       sql = "INSERT INTO users (idx,id,name) values ((select count(*) from users),'" + _id + "','" + _name + "')";
       stmt = con.createStatement();
       stmt.executeQuery(sql);
   }

   sql = "select * from users";
   stmt = con.createStatement();
   rs=stmt.executeQuery(sql);

   while(rs.next()) {
	String idx = rs.getString("idx");
	String id = rs.getString("id");
	String name  = rs.getString("name");
%>
	<tr>
		<td><%=idx%></td>
		<td><%=id%></td>
		<td><%=name%></td>
	</td>
<%
   }

   if(rs != null) rs.close();
   if(stmt != null)stmt.close();
   if(con != null)con.close();
 %>
</table>
</body>

</html>

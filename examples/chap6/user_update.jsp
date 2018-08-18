<%@ page contentType="text/html; charset=euc-kr" %>
<%@ include file="dbcon.jsp" %>
<%@ page import="java.util.*,java.text.*"%>

<html>
<head>
<title>test</title>
</head>
<body>
<script language='javascript'>
    function edit(idx,id,name){
        document.webform.idx.value=idx;
        document.webform.id.value=id;
        document.webform.name.value=name;
        document.webform.btnSubmit.disabled=false;
    }
</script>

Oracle 11g : SQL Injection in UPDATE Query
<br><br>
<hr>
<form action='/user_update.jsp' method='post' name='webform'>
   <input type='hidden' name='idx'>
   USER ID : <input type='text' length='3' name='id'>&nbsp;USER NAME : <input type='text' length='3' name='name'>&nbsp;<input type='submit' value='Update' name='btnSubmit' disabled>
</form>
<hr>
<br>
<br>
<table border=1 cellpadding=5 cellspacing=0>
	<tr>
		<td width='50'>NUM</td>
		<td width='120'>ID</td>
		<td width='240'>NAME</td>
		<td width='50'>Edit</td>
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

   String _idx = request.getParameter("idx");
   String _id = request.getParameter("id");
   String _name = request.getParameter("name");

   if (_id != null && _name != null) {
       sql = "update users set id='" + _id + "',name='" + _name + "' where idx=" + _idx;
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
		<td><input type="button" onClick="edit('<%=idx%>','<%=id%>','<%=name%>')" value='Edit'></td>
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

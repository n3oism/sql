<%@ page contentType="text/html; charset=euc-kr" %>
<%@ include file="dbcon.jsp" %>
<%@ page import="java.util.*,java.text.*"%>

<html>
<head>
<title>opensecurelab</title>
</head>
<body>
<table border=1 cellpadding=5 cellspacing=0>
	<tr>
		<td>Employee ID</td>
		<td>FirstName</td>
		<td>JOB_ID</td>
		<td>HireDate</td>
	<tr>
 <%
   String _empid = request.getParameter("empid");
   sql = "select * from employees where employee_id=" + _empid;
   stmt = con.createStatement();
   rs = stmt.executeQuery(sql);

   while(rs.next()) {
	String empid = rs.getString("employee_id");
	String name  = rs.getString("first_name");
	String jobid = rs.getString("job_id");
	String hiredate= rs.getString("hire_date");
%>
	<tr>
		<td><%=empid%></td>
		<td><%=name%></td>
		<td><%=jobid%></td>
		<td><%=hiredate%></td>
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

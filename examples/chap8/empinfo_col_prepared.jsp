<%@ page contentType="text/html; charset=euc-kr"%> 
<%@ include file="dbcon_prepared.jsp"%>
<%@ page import="java.util.*,java.text.*"%>
<html>
<head>
<title>opensecurelab</title>
</head>
<body>
Employee information :<br><br>
<table border=1 cellpadding=5 cellspacing=0>
	<tr>
		<td>Employee ID</td>
		<td>FirstName</td>
		<td>JOB_ID</td>
		<td>HireDate</td>
	<tr>
 <%
   try{
      int _empid = Integer.parseInt(request.getParameter("empid"));
      String _cname = request.getParameter("cname");
      if (_cname==null) {
         _cname="employee_id";
      }
      sql = "select * from employees where " + _cname + "=?";
      pstmt = con.prepareStatement(sql);
      pstmt.setInt(1,_empid);
      rs = pstmt.executeQuery();

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
   } catch(Exception e) {
   }

   if(rs != null) rs.close();
   if(pstmt != null)pstmt.close();
   if(con != null)con.close();
 %>
</table>
</body>

</html>

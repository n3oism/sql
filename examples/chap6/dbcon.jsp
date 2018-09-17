<%@ page language="java" import="java.sql.*" %>
<%
String DB_URL = "jdbc:oracle:thin:@localhost:1521:XE";

String DB_USER    = "hr";
String DB_PASSWORD = "hr";

Connection con = null;
Statement  stmt   = null;
ResultSet rs = null;
String sql=null;

try
 {
    Class.forName("oracle.jdbc.driver.OracleDriver");
    con = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);    
  }catch(SQLException e){out.println(e);}
%>
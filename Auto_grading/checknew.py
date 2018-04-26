import os
import sys
import mysql.connector
import time
from multiprocessing.dummy import Pool as ThreadPool 

total = sys.argv[1]
asgn = sys.argv[2]
f = open("./log.txt","a+")
while(1):
#for i in range(0,4):
	try:
		select_query = ("SELECT sid, t, day,status FROM "+asgn)
		cnx = mysql.connector.connect(user='root',password = "shanghai", host="localhost", database='myDB')
		cursor = cnx.cursor(buffered = True)
		cursor.execute(select_query)
		count = 0
		#table_empty = True
		#print (here)
		count = os.system("sudo docker ps -q -f status=\"running\"")
		run_content=[]
		diff = int(total) - count
		#print (diff)
		rcount = 0
		for (sid, t, day,status) in cursor:
			sid = sid
			t = t
			day = day
			status = status
			
			if status == "2" and count == 0:
				run_content.append("sudo python do.py "+str(sid)+"_"+str(t)+" "+str(asgn))
				rcount = rcount + 1
				if rcount == int(total):
					break
			else:
				if status == "0" and count < int(total):
					cnx1 = mysql.connector.connect(user='root',password = "shanghai", host="localhost", database='myDB')
					cursor1 = cnx1.cursor(buffered = True)
					status1 = "2"
					cursor1.execute(
						"""UPDATE """+asgn+"""
						SET status=%s
						WHERE sid=%s AND
						t=%s
						""",(status1,sid,t))
					cnx1.commit()
					cursor1.close()
					cnx1.close()		
					run_content.append("sudo python do.py "+str(sid)+"_"+str(t)+" "+str(asgn))
					count = count + 1
				else:
					if status == 0 :
						break
		
		pool = ThreadPool(diff) 
		pool.map(os.system, run_content)

	except KeyboardInterrupt:
		exit(0)
cnx.commit()
cursor.close()
cnx.close()

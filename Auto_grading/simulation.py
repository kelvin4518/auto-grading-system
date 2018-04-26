import sys
import os
from multiprocessing.dummy import Pool
import mysql.connector


os.system("sudo rm ./inputcases/asg1/in_output.txt")
os.system("sudo cp ./example/strictly/in_output.txt ./inputcases/asg1")
cnx = mysql.connector.connect(user='root',password = "shanghai", host="localhost", database='myDB')
cursor = cnx.cursor()
for i in range(0,1000):
	query = ("INSERT INTO asg1(sid,score,t,file_path,day,status) VALUES ('1155061927','',%s,%s,NOW(),'0') ")
	fi = "1155061927_"+str(i)+"_asg1"
	cursor.execute(query,(str(i),fi))
	os.system("sudo mkdir ./student_set/"+fi)
	os.system("sudo cp ./example/strictly/* ./student_set/"+fi)
cnx.commit()
cursor.close()
cnx.close()

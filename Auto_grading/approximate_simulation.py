import sys
import os
from multiprocessing.dummy import Pool
import mysql.connector


os.system("sudo rm ./inputcases/asg1/in_output.txt")
os.system("sudo cp ./example/Approximate/in_output.txt ./inputcases/asg1")
cnx = mysql.connector.connect(user='root',password = "shanghai", host="localhost", database='myDB')
cursor = cnx.cursor()
#os.system("sudo rm -r /var/www/html/Project/Auto_grading/student_set/*")
query = ("INSERT INTO asg1(sid,score,t,file_path,day,status) VALUES ('1155061927','','1','',NOW(),'0') ")
fi = "1155061927_1_asg1"
cursor.execute(query,fi)
os.system("sudo mkdir ./student_set/"+fi)
os.system("sudo cp ./example/Approximate/0.01/* ./student_set/"+fi)

query = ("INSERT INTO asg1(sid,score,t,file_path,day,status) VALUES ('1155061927','','2','',NOW(),'0') ")
fi = "1155061927_2_asg1"
cursor.execute(query,fi)
os.system("sudo mkdir ./student_set/"+fi)
os.system("sudo cp ./example/Approximate/0.02/* ./student_set/"+fi)

cnx.commit()
cursor.close()
cnx.close()


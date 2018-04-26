import os
import shutil
from subprocess import Popen, PIPE
from os import kill
import signal
import sys
import mysql.connector

sid = sys.argv[1]
asgn = sys.argv[2]

cnx = mysql.connector.connect(user='root',password = "shanghai", host="localhost", database='myDB')
cursor = cnx.cursor()
select_query = ("SELECT language, filesize, timelimit, compile_name FROM " + asgn + "_requirement")
cursor.execute(select_query)

for (language, filesize, timelimit, compile_name) in cursor:
	language = language
	filesize = filesize
	timelimit = timelimit
	file_name_set = compile_name


tmp = []
file_name_set = file_name_set.split("\r\n")
#print(file_name_set)
for file_name in file_name_set:
	tmp.append(format(file_name))

tmp = ",".join(tmp)

os.system("mkdir ./student_set/"+sid+"_"+asgn+"_tmp")
#os.mkdir("./student_set/"+sid+"_"+asgn+"_tmp")
os.chdir("./student_set/"+sid+"_"+asgn+"_tmp")
os.system("mkdir ./hm")
os.system("mkdir ./hm/inputcase")
os.system("mkdir ./hm/inputcase/input")
os.system("mkdir ./hm/inputcase/output")
os.system("mkdir ./hm/marking_scheme/")
#os.mkdir("./hm")
#os.mkdir("./hm/inputcase")
os.chdir("/var/www/html/Project/Auto_grading/")
os.system("sudo cp ./student_set/"+sid+"_"+asgn+"/* "+"./student_set/"+sid+"_"+asgn+"_tmp/hm")
os.system("sudo cp compare.py ./student_set/"+sid+"_"+asgn+"_tmp")
os.system("sudo cp app.py ./student_set/"+sid+"_"+asgn+"_tmp")
os.system("sudo cp run_studentcode.py ./student_set/"+sid+"_"+asgn+"_tmp")
os.system("sudo cp ./inputcases/"+asgn+"/in_output.txt ./student_set/"+sid+"_"+asgn+"_tmp/hm/inputcase/")
os.system("sudo cp ./inputcases/"+asgn+"/input/* ./student_set/"+sid+"_"+asgn+"_tmp/hm/inputcase/input/")
os.system("sudo cp ./inputcases/"+asgn+"/output/* ./student_set/"+sid+"_"+asgn+"_tmp/hm/inputcase/output/")
os.system("sudo cp ./marking_scheme/"+asgn+"/* ./student_set/"+sid+"_"+asgn+"_tmp/hm/marking_scheme/")
os.system("sudo cp ./customized/"+asgn+"/* ./student_set/"+sid+"_"+asgn+"_tmp/")
os.chdir("./student_set/"+sid+"_"+asgn+"_tmp")
g = open("./customized.sh","r")
f = open("./Dockerfile","w")
f.write("FROM ubuntu\n\nRUN apt-get update\nRUN apt-get install python -y\nRUN apt-get install vim -y \nRUN apt-get install gcc -y \nRUN apt-get install g++ -y \nRUN apt-get install default-jre -y\nRUN apt-get install default-jdk -y \nRUN apt-get install perl -y \nRUN apt-get install python-pip -y\nRUN pip install --upgrade pip\nRUN pip install mysql-connector-python-rf\n")
for l in g.readlines():
	f.write(l)
f.write("\n\nRUN mkdir /app\nCOPY . /app\nWORKDIR /app\n\nCMD python app.py "+sid+" "+ language + " " + tmp+"\n#ENTRYPOINT /bin/bash")
f.close()
g.close()

os.system("docker build -t "+sid+" .")
talkpipe = Popen(['docker', 'run','--rm',sid], shell=False, stdout=PIPE)
line = talkpipe.stdout.readline()
kill(talkpipe.pid, signal.SIGTERM)
line = line.split(",")
sid_try = line[0].split("_")
sid = sid_try[0]
try_times = sid_try[1]
score = line[1]
score = score[0:len(line[1])-1]

#print (score)
status = '1'
cursor.execute("""UPDATE """+asgn+"""
	SET score=%s
	WHERE sid=%s AND
	t=%s
	""",(score,sid,try_times))

cursor.execute("""UPDATE """+asgn+"""
	SET status=%s
	WHERE sid=%s AND
	t=%s
	""",(status,sid,try_times))

#sid = sid.split("_")
#sid = sid[0]
#a = "waitlist"
#status = '1'
#cursor.execute("""UPDATE """+a+"""
#	SET status=%s
#	WHERE sid=%s AND
#	t=%s AND
#	asgn=%s
#	""",(status,sid,try_times,asgn))

cnx.commit()
cursor.close()
cnx.close()

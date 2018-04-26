from __future__ import print_function
import os
from subprocess import Popen, PIPE
from os import kill
import signal
import shutil
import sys

#to compare the content of the student's work
class compare:
	def __init__ (self,stu_output,sta_output):
		self.stu_output = stu_output #it's the object of file
		self.sta_output = sta_output
	def do (self):
		count = 0.00
		total = 0.00
		score = 1.0
		for sta_line in self.sta_output:
			len_sta = 0
			len_stu = 0
			stu_line = self.stu_output.readline()
			while stu_line == "\n":
				stu_line = self.stu_output.readline()
				score = score - 0.05
			for i in sta_line:
				if (i != "\n" and i != "\r"):
					len_sta = len_sta + 1
				else:
					break
			for i in stu_line:
				if (i != "\n" and i != "\r"):
					len_stu = len_stu + 1
				else:
					break
			sta_line = sta_line[0:len_sta]
			stu_line = stu_line[0:len_stu]
			
			if sta_line != stu_line:
				count = count + 1.00
			total = total + 1.00
		if count == 0:
			return score
		else:
			return (score-float(count)/float(total))

#main part
sid = sys.argv[1]

fi = "./"+sid+"_output.txt"
stu_output = open(fi,"r")
sta_output = open("./hm/standard_output.txt","r")

com = compare(stu_output,sta_output)
result = com.do()

stu_output.close()
sta_output.close()

print(sid+","+str(result*100))
os.system("rm -r ./hm/standard_output.txt")
os.system("rm -r "+fi)
from __future__ import print_function
import os
from subprocess import Popen, PIPE
from os import kill
import signal
import shutil
import sys
import re
#to compare the content of the student's work
class compare:
	def __init__ (self,stu_output,sta_output):
		self.stu_output = stu_output #it's the object of file
		self.sta_output = sta_output
	def do (self):
		score = 0.0
		sta_line = self.sta_output.readline()
		while sta_line != "":
			len_sta = 0
			len_stu = 0
			stu_line = self.stu_output.readline()
			while stu_line == "\n":
				stu_line = self.stu_output.readline()
				score = score - 5.0
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
			marking_scheme = self.sta_output.readline()
			len_marking = 0
			for i in marking_scheme:
				if (i != "\n" and i != "\r"):
					len_marking = len_marking + 1
				else:
					break
			marking_scheme = marking_scheme[0:len_marking]
			instruction = marking_scheme.split("_")[0][0]
			line_score = marking_scheme.split("_")[0][1:]
			marking_range_L = marking_scheme.split("_")[1].split(":")[0]
			marking_range_R = marking_scheme.split("_")[1].split(":")[1]
			if instruction == "S":
				if sta_line[int(marking_range_L):int(marking_range_R)] == stu_line[int(marking_range_L):int(marking_range_R)]:
					score = score + float(line_score)
			else:
				diff = float(sta_line[int(marking_range_L):int(marking_range_R)])-float(stu_line[int(marking_range_L):int(marking_range_R)])
				if diff < 0:
					diff = - diff
				#print("inthis")
				marking_s = open("./hm/marking_scheme/marking_scheme.txt","r")
				for approximate_scheme in marking_s.readlines():
					approximate_score = approximate_scheme.split("_")[0]
					approximate_range = approximate_scheme.split("_")[1]
					approximate_range = approximate_range[0:len(approximate_range)-1]
					#print (approximate_range)
					#<:le <=: leq >:la >=: laeq
					le = [m.start() for m in re.finditer('<', approximate_range)]
					leq = [m.start() for m in re.finditer('<=', approximate_range)]
					la = [m.start() for m in re.finditer('>', approximate_range)]
					laeq = [m.start() for m in re.finditer('>=', approximate_range)]
					range_string = []
					#print ("b "),
					#print (le)
					#print ("leq "),
					#print (leq)
					if le != [] and le != leq:
						range_string.append("le")
					if leq != []:
						range_string.append("leq")
					if la != [] and la != laeq:
						range_string.append("la")
					if laeq != []:
						range_string.append("laeq")
					#print (range_string)
					#print ("a "),
					#print (le)
					if len(le) != 0 and len(leq) != 0:
						if le[0] == leq[0]:
							le[0] = le[1]
					if len(la) != 0 and len(laeq) != 0:
						if la[0] == laeq[0]:
							la[0] = la[1]
					#print (range_string)
					#print(le)
					if len(range_string) == 1:
						if range_string[0] == "le":
							f = int(le[0])
							s = int(le[1])
							left_range = float(approximate_range[0:f])
							right_range = float(approximate_range[s+1:])
							if diff > left_range and diff < right_range:
								score = score + float(line_score) - float(approximate_score)
						if range_string[0] == "leq":
							f = int(leq[0])
							s = int(leq[1])
							left_range = float(approximate_range[0:f])
							right_range = float("0.0001")
							if diff >= left_range and diff <= right_range:
								score = score + float(line_score) - float(approximate_score)
						if range_string[0] == "la":
							f = int(la[0])
							s = int(la[1])
							left_range = float(approximate_range[0:f])
							right_range = float(approximate_range[s+1:])
							if diff < left_range and diff > right_range:
								score = score + float(line_score) - float(approximate_score)
						if range_string[0] == "laeq":
							f = int(laeq[0])
							s = int(laeq[1])
							left_range = float(approximate_range[0:f])
							right_range = float(approximate_range[s+1:])
							if diff <= left_range and diff >= right_range:
								score = score + float(line_score) - float(approximate_score)
					else:
						#print ("inthis")
						if range_string == ["le","leq"] or range_string == ["leq","le"]:
							#print ("inthis")
							if le[0] < leq[0]:
								#print ("inthis")
								f = int(le[0])
								s = int(leq[0])
								left_range = float(approximate_range[0:f])
								right_range = float(approximate_range[s+2:])
								if diff > left_range and diff <= right_range:
									score = score + float(line_score) - float(approximate_score)
							else:
								f = int(leq[0])
								s = int(le[0])
								left_range = float(approximate_range[0:f])
								right_range = float(approximate_range[s+1:])
								if diff >= left_range and diff < right_range:
									score = score + float(line_score) - float(approximate_score)


						#if range_string == ["<=","<"]:
							
						if range_string == ["la","laeq"] or range_string == ["laeq","la"]:
							if la[0] < laeq[0]:
								f = int(lae[0])
								s = int(laeq[0])
								left_range = float(approximate_range[0:f])
								right_range = float(approximate_range[s+2:])
								if diff < left_range and diff >= right_range:
									score = score + float(line_score) - float(approximate_score)
								else:
									f = int(laeq[0])
									s = int(la[0])
									left_range = float(approximate_range[0:f])
									right_range = float(approximate_range[s+1:])
									if diff <= left_range and diff > right_range:
										score = score + float(line_score) - float(approximate_score)
	
						#if range_string == [">=",">"]:
								
				marking_s.close()
			#total = total + 1.00
			sta_line = self.sta_output.readline()
		
		return float(score)

#main part
sid = sys.argv[1]

fi = "./"+sid+"_output.txt"
stu_output = open(fi,"r")
sta_output = open("./hm/standard_output.txt","r")

com = compare(stu_output,sta_output)
result = com.do()

stu_output.close()
sta_output.close()

print(sid+","+str(result))
#os.system("rm -r ./hm/standard_output.txt")
#os.system("rm -r "+fi)

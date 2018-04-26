import os
import sys
		
sid = sys.argv[1]
language = sys.argv[2]
compile_file = sys.argv[3]

compile_file_set = compile_file.split(",")

os.chdir("./hm")
f = open("./inputcase/in_output.txt","r")
tmp = f.readline()
i = tmp
input_content = ""
count = 0
g = open("./standard_output.txt","w")
while i != "":
	while i == "input\n":
		tmp = f.readline()
		tmp = tmp[0:len(tmp)-1]
		if tmp == "output":
			i = tmp
		else:
			if input_content == "":
				input_content = tmp
			else:
				input_content = input_content + "|" + tmp
			count = count + 1
	while i == "output":
		tmp = f.readline()
		if tmp == "":
			i = tmp
			break
		if tmp == "input\n":
			i = tmp
			break
		g.write(tmp)

g.close()
f.close()
filename = ""
for file in compile_file_set:
	filename = filename + file + " "

j = 0
if input_content != "":
	input_content = input_content.split("|")
	while j < count:
		if language == "python":
			os.system("python "+filename+" "+input_content[j])
		else :
			if language == "c":
				os.system("gcc -o "+sid+" "+filename)
				os.system("./"+sid+" "+input_content)
			else:
				if language == "c++":
					os.system("g++ -o "+sid+" "+filename)
					os.system("./"+sid+" "+input_content)
				else:
					if language == "perl":
						os.system("perl "+filename+" "+input_content)
					else:
						if language == "java":
							os.system("javac "+filename)
							os.system("java "+sid+" "+input_content)
						else:
							print("wrong file please check")
							exit(0)
		j = j + 1
else:
	if language == "python":
			os.system("python "+filename)
	else :
		if language == "c":
			os.system("gcc -o "+sid+" "+filename)
			os.system("./"+sid)
		else:
			if language == "c++":
				os.system("g++ -o "+sid+" "+filename)
				os.system("./"+sid)
			else:
				if language == "perl":
					os.system("perl "+filename)
				else:
					if language == "java":
						os.system("javac "+filename)
						os.system("java "+sid)
					else:
						print("wrong file please check")
						exit(0)

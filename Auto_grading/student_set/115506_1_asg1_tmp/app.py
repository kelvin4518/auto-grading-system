import sys
import os
from subprocess import Popen, PIPE
from os import kill
import signal

sid = sys.argv[1]
language = sys.argv[2]
tmp = sys.argv[3]

fi = "./"+sid+"_output.txt"
f = open(fi,"w")

talkpipe = Popen(['python', 'run_studentcode.py',sid,language,tmp], shell=False, stdout=PIPE)
line = talkpipe.stdout.readline()
while line != "":
	f.write(line)
	line = talkpipe.stdout.readline()
kill(talkpipe.pid, signal.SIGTERM)
f.close()

os.system("python compare.py "+sid)

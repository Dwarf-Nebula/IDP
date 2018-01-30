import sys

from ledring import *
from readrfid import *
binnen = 0
try:
    while True:
        card = readCard()
        if(card == "213.192.127.203" and binnen == 0):
            openin()
            binnen = 1
            time.sleep(2)
            
        elif(card == "213.192.127.203" and binnen == 1):
            openuit()
            time.sleep(2)
        else:
            weiger()
            time.sleep(2)
        read()
        
except KeyboardInterrupt:
    print("bye bye")
    sys.exit()
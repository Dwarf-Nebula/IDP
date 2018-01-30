import sys
import RPi.GPIO as GPIO
import requests

from ledring import *
from readrfid import *

bezig = 0
url = benno.using.ovh/request.php

try:
    while True:
        card = readCard()
        uid = int(card)
        payload = {"action":"activitystart", 'customerid':uid, "equipmentid":1}
        url = "benno.using.ovh/request.php"
        r = requests.post(url, data=payload)
        print(r.text)
        
except KeyboardInterrupt:
    print("bye bye")
    GPIO.cleanup()
    sys.exit()
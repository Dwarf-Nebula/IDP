import sys
import RPi.GPIO as GPIO
import requests
import time

from ledring import *
from readrfid import *
from motor import *

filiaal = 1
url = "http://benno.using.ovh/request.php"
# setup
GPIO.setmode(GPIO.BOARD)
weiger(ring_small)
setHome(endstop_pin)
delay = 1 / 1000.0

while True:
    read(ring_small)
    card = readCard()
    print("reader  = ", card)
    if card != None:
        uid = int(card)
        payload = {"action":"checkin", "customerid":uid, "locationid":filiaal}
        r = requests.post(url, data=payload)
        if r.text == 'out':
            print(r.text)
            openuit(ring_small)
            forward(delay, 118)
            time.sleep(5)
            backwards(delay, 118)
            
        elif r.text == 'in':
            openin(ring_small)
            print(r.text)
            backwards(delay, 118)
            time.sleep(5)
            forward(delay, 118)
        elif r.text == 'failure':
            print(r.text)
            weiger(ring_small)
            time.sleep(5)
        else:
            weiger(ring_small)
            print(r.text)
            print('kunt line')
            time.sleep(5)


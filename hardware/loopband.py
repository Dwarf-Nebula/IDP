import sys
import RPi.GPIO as GPIO
import requests

from ledring import *
from readrfid import *

bezig = 0
url = "http://benno.using.ovh/request.php"

GPIO.setmode(GPIO.BCM)
GPIO.setup(13, GPIO.OUT)    # set GPIO 25 as output for the PWM signal
motor = GPIO.PWM(13, 1000)    # create object D2A for PWM on port 25 at 1KHz
motor.start(0) #start the pwm, but off

try:
    while True:
        card = readCard()
        """uid = int(card)
        payload = {"action":"activitystart", "customerid":uid, "equipmentid":1}
        r = requests.post(url, data=payload)
        print(r.text)"""
        openin(ring_big)
        motor.ChangeDutyCycle(20)
        card2 = readCard()
        while (card2 != card):
            card2 = readCard()
        motor.ChangeDutyCycle(0)
        openuit(ring_big)
        
except KeyboardInterrupt:
    print("bye bye")
    GPIO.cleanup()
    sys.exit()
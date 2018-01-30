import sys
import RPi.GPIO as GPIO
import requests
import time

from ledring import *
from readrfid import *

bezig = 0
url = "http://benno.using.ovh/request.php"

GPIO.setmode(GPIO.BOARD)
GPIO.setup(33, GPIO.OUT)    # set GPIO 33 as output for the PWM signal
motor = GPIO.PWM(33, 500)    # create object motor for PWM on port 33 at 1KHz
motor.start(0) #start the pwm, but off

try:
    while True:
        card = readCard()
        uid = int(card)
        payload = {"action":"activitystart", "customerid":uid, "equipmentid":1}
        r = requests.post(url, data=payload)
        print(r.text)
        openin(ring_big)
        #GPIO.output(33, GPIO.HIGH)
        motor.ChangeDutyCycle(10)
        time.sleep(5)
        """while True:
            card2 = readCard(continues=False)
            if (card2 == card):
                break"""
        #GPIO.output(33, GPIO.LOW)
        motor.ChangeDutyCycle(0)
        openuit(ring_big)
        
except KeyboardInterrupt:
    print("bye bye")
    clean(ring_big)
    GPIO.cleanup()
    sys.exit()
import sys
import RPi.GPIO as GPIO
import requests
import time

from ledring import *
from readrfid import *

bezig = 0
url = "http://benno.using.ovh/request.php"

GPIO.setmode(GPIO.BOARD)
GPIO.setup(29, GPIO.IN) # set pin 29 as an input
GPIO.setup(31, GPIO.IN) # set pin 31 as an input
GPIO.setup(37, GPIO.IN) # set pin 37 as an input
GPIO.setup(33, GPIO.OUT)    # set GPIO 33 as output for the PWM signal
motor = GPIO.PWM(33, 500)    # create object motor for PWM on port 33 at 1KHz
motor.start(0) # start the pwm, but off

try:
    while True:
        card = readCard() #Check for a card
        """uid = int(card)
        payload = {"action":"activitystart", "customerid":uid, "equipmentid":1}
        r = requests.post(url, data=payload)
        print(r.text)"""
        openin(ring_big)
        #GPIO.output(33, GPIO.HIGH)
        motor.ChangeDutyCycle(25)
        #time.sleep(5)
        while True:
            hoger_state = GPIO.input(29)
            print(hoger_state)
            if (hoger_state == False):
                print("omhoog")
                time.sleep(0.1)
            lager_state = GPIO.input(31)
            print(lager_state)
            if (lager_state == False):
                print("omlaag")
                time.sleep(0.1)
            card_state = GPIO.input(29)
            print(card_state)
            if (card_state == False):
                print(card)
                time.sleep(0.1)
                card2 = readCard()
                if (card2 == card):
                    break
                else:
                    continue
        #GPIO.output(33, GPIO.LOW)
        motor.ChangeDutyCycle(0)
        openuit(ring_big)
        
except KeyboardInterrupt:
    print("bye bye")
    clean(ring_big)
    GPIO.cleanup()
    sys.exit()
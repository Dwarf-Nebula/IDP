import sys
import RPi.GPIO
import Adafruit_GPIO as GPIO
import requests
import time

from ledring import *
from readrfid import *
#from display import *

bezig = 0
snelheid = 0
url = "http://benno.using.ovh/request.php"

gpio = GPIO.get_platform_gpio(mode=RPi.GPIO.BOARD)
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
        
        snelheid = 25
        motor.ChangeDutyCycle(snelheid)
        #drawspeed(snelheid)
        
        while True:
            hoger_state = GPIO.input(29)
            time.sleep(0.01)
            
            if (hoger_state == True and snelheid < 100):
                time.sleep(0.1)
                print("omhoog")
                print(snelheid)
                snelheid += 1
                motor.ChangeDutyCycle(snelheid)
                #drawspeed(snelheid)
            
            lager_state = GPIO.input(31)
            time.sleep(0.01)
            
            if (lager_state == True and snelheid > 0):
                time.sleep(0.1)
                print("omlaag")
                print(snelheid)
                snelheid -= 1
                motor.ChangeDutyCycle(snelheid)
                #drawspeed(snelheid)
            
            card_state = GPIO.input(37)
            time.sleep(0.01)
            
            if (card_state == True):
                time.sleep(0.1)
                print("card")
                card2 = readCard()
                if (card2 == card):
                    """payload = {"action":"activitystop", "customerid":uid, "equipmentid":1}
                    r = requests.post(url, data=payload)"""
                    break
                else:
                    continue
        
        snelheid = 0
        motor.ChangeDutyCycle(snelheid)
        #drawspeed(snelheid)
        openuit(ring_big)
        
except KeyboardInterrupt:
    print("bye bye")
    clean(ring_big)
    GPIO.cleanup()
    sys.exit()
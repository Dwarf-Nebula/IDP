import RPi.GPIO as GPIO

out = GPIO.OUT
HIGH = 1
LOW = 0

bin1 = 11
bin2 = 13
bin4 = 15
bin8 = 16

GPIO.setup(bin1, out) # set pin 29 as an input
GPIO.setup(bin2, out) # set pin 31 as an input
GPIO.setup(bin4, out) # set pin 37 as an input
GPIO.setup(bin8, out) # set pin 33 as an output

def drawspeed(speed):
    if(speed == 0):
        GPIO.output(bin8, LOW)
        GPIO.output(bin4, LOW)
        GPIO.output(bin2, LOW)
        GPIO.output(bin1, LOW)
        return
    else:
        speed -= 14
        if(speed >= 8):
            GPIO.output(bin8, HIGH)
            speed -= 8
        else:
            GPIO.output(bin8, LOW)
        if(speed >= 4):
            GPIO.output(bin4, HIGH)
            speed -=4
        else:
            GPIO.output(bin4, LOW)
        if(speed >= 2):
            GPIO.output(bin2, HIGH)
            speed -= 2
        else:
            GPIO.output(bin2, LOW)
        if(speed >= 1):
            GPIO.output(bin1, HIGH)
        else:
            GPIO.output(bin1, LOW)
    return
import RPi.GPIO as GPIO

out = GPIO.OUT

GPIO.setup(29, out) # set pin 29 as an input
GPIO.setup(31, out) # set pin 31 as an input
GPIO.setup(37, out) # set pin 37 as an input
GPIO.setup(33, out) # set GPIO 33 as output for the PWM signal
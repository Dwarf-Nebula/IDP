import RPi.GPIO as GPIO
import time



endstop_pin = 40
enable_pin = 13
coil_A_1_pin = 7
coil_A_2_pin = 11
coil_B_1_pin = 13
coil_B_2_pin = 15

GPIO.setup(enable_pin, GPIO.OUT)
GPIO.setup(coil_A_1_pin, GPIO.OUT)
GPIO.setup(coil_A_2_pin, GPIO.OUT)
GPIO.setup(coil_B_1_pin, GPIO.OUT)
GPIO.setup(coil_B_2_pin, GPIO.OUT)
GPIO.setup(endstop_pin, GPIO.IN, pull_up_down=GPIO.PUD_UP)
GPIO.output(enable_pin, 1)


def forward(delay, steps):
    for i in range(0, steps):
        setStep(1, 0, 0, 0)
        time.sleep(delay)
        setStep(1,1,0,0)
        time.sleep(delay)
        setStep(0, 1, 0, 0)
        time.sleep(delay)
        setStep(0,1,1,0)
        time.sleep(delay)
        setStep(0, 0, 1, 0)
        time.sleep(delay)
        setStep(0,0,1,1)
        time.sleep(delay)
        setStep(0, 0, 0, 1)
        time.sleep(delay)
        setStep(1,0,0,1)
        time.sleep(delay)


def backwards(delay, steps):
    for i in range(0, steps):
        setStep(1, 0, 0, 1)
        time.sleep(delay)
        setStep(0, 0, 0, 1)
        time.sleep(delay)
        setStep(0, 0, 1, 1)
        time.sleep(delay)
        setStep(0, 0, 1, 0)
        time.sleep(delay)
        setStep(0, 1, 1, 0)
        time.sleep(delay)
        setStep(0, 1, 0, 0)
        time.sleep(delay)
        setStep(1, 1, 0, 0)
        time.sleep(delay)
        setStep(1, 0, 0, 0)
        time.sleep(delay)

def setStep(w1, w2, w3, w4):
    GPIO.output(coil_A_1_pin, w1)
    GPIO.output(coil_A_2_pin, w2)
    GPIO.output(coil_B_1_pin, w3)
    GPIO.output(coil_B_2_pin, w4)

def setHome(endstop_pin):

    delay = 5 / 1000.0
    while True:
        endstop = GPIO.input(endstop_pin)
        print(endstop)
        setStep(1, 0, 0, 0)
        if not endstop:
            break
        time.sleep(delay)
        setStep(1, 1, 0, 0)
        if not endstop:
            break
        time.sleep(delay)
        setStep(0, 1, 0, 0)
        if not endstop:
            break
        time.sleep(delay)
        setStep(0, 1, 1, 0)
        if not endstop:
            break
        time.sleep(delay)
        setStep(0, 0, 1, 0)
        if not endstop:
            break
        time.sleep(delay)
        setStep(0, 0, 1, 1)
        if not endstop:
            break
        time.sleep(delay)
        setStep(0, 0, 0, 1)
        if not endstop:
            break
        time.sleep(delay)
        setStep(1, 0, 0, 1)
        if not endstop:
            break
        time.sleep(delay)



    print("end found")
    backwards(5/1000.0, 130)

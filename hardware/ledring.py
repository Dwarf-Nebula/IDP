import time
from neopixel import *

# LED configuration:
LED_COUNT_SMALL = 24      # Number of LED pixels.
LED_COUNT_BIG   = 22      # Number of LED pixels.
LED_PIN         = 18      # GPIO pin connected to the pixels (18 uses PWM!).
LED_FREQ_HZ     = 800000  # LED signal frequency in hertz (usually 800khz)
LED_DMA         = 10      # DMA channel to use for generating signal (try 10)
LED_BRIGHTNESS  = 255     # Set to 0 for darkest and 255 for brightest
LED_INVERT      = False   # True to invert the signal (when using NPN transistor level shift)
LED_CHANNEL     = 0       # set to '1' for GPIOs 13, 19, 41, 45 or 53
LED_STRIP       = ws.WS2811_STRIP_GRB   # Strip type and colour ordering

# Create NeoPixel object with appropriate configuration.
ring_small = Adafruit_NeoPixel(LED_COUNT_SMALL, LED_PIN, LED_FREQ_HZ, LED_DMA, LED_INVERT, LED_BRIGHTNESS, LED_CHANNEL, LED_STRIP)
ring_big = Adafruit_NeoPixel(LED_COUNT_BIG, LED_PIN, LED_FREQ_HZ, LED_DMA, LED_INVERT, LED_BRIGHTNESS, LED_CHANNEL, LED_STRIP)
# Intialize the library (must be called once before other functions).
ring_small.begin()
ring_big.begin()

def wait(ms):
    time.sleep(ms/1000)
    return

# Define functions which animate LEDs in various ways.
def openin(strip, wait_ms=50, color=Color(0, 255, 0)):
    if(strip == ring_small):
        for x in range(12):
            strip.setPixelColor(x, color)
            strip.setPixelColor(x+12, Color(255, 0, 0))
            strip.show()
            wait(wait_ms)
    elif(strip == ring_big):
        strip.setPixelColor(20, color)
        for x in range(12):
            if(x < 8):
                strip.setPixelColor(x, color)
                strip.setPixelColor(x+12, color)
            else:
                strip.setPixelColor(x, color)
            strip.show()
            wait(wait_ms)

# Define functions which animate LEDs in various ways.
def openuit(strip, wait_ms=50, color=Color(255, 0, 0)):
    if(strip == ring_small):
        for x in range(12):
            strip.setPixelColor(x, color)
            strip.setPixelColor(x+12, Color(0, 255, 0))
            strip.show()
            wait(wait_ms)
    elif(strip == ring_big):
        strip.setPixelColor(20, color)
        for x in range(12):
            if(x < 8):
                strip.setPixelColor(x, color)
                strip.setPixelColor(x+12, color)
            else:
                strip.setPixelColor(x, color)
            strip.show()
            wait(wait_ms)

def weiger(strip, wait_ms=50):
    for x in range(12):
        strip.setPixelColor(x, Color(255, 0, 0))
        strip.setPixelColor(x+12, Color(255, 0, 0))
        strip.show()
        wait(wait_ms)
        
def read(strip):
    for x in range(24):
        strip.setPixelColor(x, Color(255, 255, 0))
    strip.show()

def clean(strip):
    for x in range(24):
        strip.setPixelColor(x, Color(0, 0, 0))
    strip.show()
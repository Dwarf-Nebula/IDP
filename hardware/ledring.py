import time
from neopixel import *

# LED configuration:
LED_COUNT      = 24      # Number of LED pixels.
LED_PIN        = 18      # GPIO pin connected to the pixels (18 uses PWM!).
#LED_PIN        = 10      # GPIO pin connected to the pixels (10 uses SPI /dev/spidev0.0).
LED_FREQ_HZ    = 800000  # LED signal frequency in hertz (usually 800khz)
LED_DMA        = 10      # DMA channel to use for generating signal (try 10)
LED_BRIGHTNESS = 255     # Set to 0 for darkest and 255 for brightest
LED_INVERT     = False   # True to invert the signal (when using NPN transistor level shift)
LED_CHANNEL    = 0       # set to '1' for GPIOs 13, 19, 41, 45 or 53
LED_STRIP      = ws.WS2811_STRIP_GRB   # Strip type and colour ordering

# Create NeoPixel object with appropriate configuration.
ring = Adafruit_NeoPixel(LED_COUNT, LED_PIN, LED_FREQ_HZ, LED_DMA, LED_INVERT, LED_BRIGHTNESS, LED_CHANNEL, LED_STRIP)
# Intialize the library (must be called once before other functions).
ring.begin()

def wait(ms):
    time.sleep(ms/1000)
    return

# Define functions which animate LEDs in various ways.
def openin(strip=ring, wait_ms=100):
    for x in range(12):
        strip.setPixelColor(x, Color(0, 255, 0))
        strip.setPixelColor(x+12, Color(255, 0, 0))
        strip.show()
        wait(wait_ms)
        
def openuit(strip=ring, wait_ms=100):
    for x in range(12):
        strip.setPixelColor(x+12, Color(0, 255, 0))
        strip.setPixelColor(x, Color(255, 0, 0))
        strip.show()
        wait(wait_ms)

def weiger(strip=ring, wait_ms=100):
    for x in range(12):
        strip.setPixelColor(x, Color(255, 0, 0))
        strip.setPixelColor(x+12, Color(255, 0, 0))
        strip.show()
        wait(wait_ms)
        
def read(strip=ring):
    for x in range(24):
        strip.setPixelColor(x, Color(255, 255, 0))
    strip.show()
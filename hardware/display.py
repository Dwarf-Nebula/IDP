"""import RPi.GPIO as GPIO

out = GPIO.OUT

GPIO.setup(29, out) # set pin 29 as an input
GPIO.setup(31, out) # set pin 31 as an input
GPIO.setup(37, out) # set pin 37 as an input
GPIO.setup(33, out) # set GPIO 33 as output for the PWM signal"""

import Adafruit_GPIO.SPI as SPI
import Adafruit_SSD1306
from PIL import Image
from PIL import ImageDraw
from PIL import ImageFont
disp = Adafruit_SSD1306.SSD1306_128_64(rst=24)
disp.begin()
disp.clear()
disp.display()
image = Image.new('1', (disp.width, disp.height))
draw = ImageDraw.Draw(image)
draw.rectangle((0,0,disp.width-1,disp.height-1), outline=1, fill=0)
font = ImageFont.load_default()
disp.image(image)
def drawspeed(speed):
    draw.text((16, 8), str(speed),  font=font, fill=255)
    disp.display()
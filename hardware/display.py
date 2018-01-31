import Adafruit_GPIO.SPI as SPI
import Adafruit_SSD1306

from PIL import Image
from PIL import ImageDraw
from PIL import ImageFont

disp = Adafruit_SSD1306.SSD1306_128_64(rst=24)

disp.begin()
disp.clear()
disp.display()

# Get display width and height.
width = disp.width
height = disp.height

image = Image.new('1', (width, height))

draw = ImageDraw.Draw(image)
draw.rectangle((0,0,width-1,height-1), outline=1, fill=0)

def drawspeed(snelheid):
    font = ImageFont.load_default()
    draw.text((16, 8), snelheid,  font=font, fill=255)

    disp.image(image)
    disp.display()

while True:
    for i in range(30):
        drawspeed(i)
    for i in range(0, 30, -1):
        drawspeed(i)
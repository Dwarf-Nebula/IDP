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
while True:
    for i in range(10):
        draw.text((16, 8), "i",  font=font, fill=255)
    break
disp.image(image)
disp.display()
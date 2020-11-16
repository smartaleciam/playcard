#!/usr/bin/env python
import time
import Adafruit_CharLCD as LCD

lcd = LCD.Adafruit_CharLCD(4, 24, 23, 17, 18, 22, 16, 2, 5)
lcd.set_backlight(0)
lcd.clear()
lcd.message('RFID TokenSystem\n   Loading...')

time.sleep(120)
lcd.set_backlight(1)

#lcd.clear()
#lcd.message(sys.argv[1])


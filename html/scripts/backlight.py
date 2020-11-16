#!/usr/bin/env python

import sys
import Adafruit_CharLCD as LCD

lcd = LCD.Adafruit_CharLCD(4, 24, 23, 17, 18, 22, 16, 2, 5)
if sys.argv[1] == "0":
  lcd.set_backlight(0)
  print("on")
else:
  lcd.set_backlight(1)
  print("off")

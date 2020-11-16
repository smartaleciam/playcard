#!/usr/bin/env python

import Adafruit_CharLCD as LCD

lcd = LCD.Adafruit_CharLCD(4, 24, 23, 17, 18, 22, 16, 2, 5)
lcd.clear()
lcd.set_backlight(0)
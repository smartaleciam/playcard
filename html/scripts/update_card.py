#!/usr/bin/env python

import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import Adafruit_CharLCD as LCD

reader = SimpleMFRC522()
lcd = LCD.Adafruit_CharLCD(4, 24, 23, 17, 18, 22, 16, 2, 5)
lcd.set_backlight(0)

q = True
try:
  while q:
    lcd.clear()
    lcd.message('  Scan Card to\n  Update Credit')
    id, text = reader.read()
    lcd.clear()
    lcd.message('  Card Scanned  ')
    print(hex(id)[2:10])
    q = False
finally:
  GPIO.cleanup()

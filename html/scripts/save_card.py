#!/usr/bin/env python

import time
import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
import mysql.connector
import Adafruit_CharLCD as LCD

db = mysql.connector.connect( host="localhost", user="pi", passwd="smartalec", database="playcard" )

cursor = db.cursor()
reader = SimpleMFRC522()
lcd = LCD.Adafruit_CharLCD(4, 24, 23, 17, 18, 22, 16, 2, 5)
lcd.set_backlight(0)
q = True
try:
  while q:
    lcd.clear()
    lcd.message(' Scan Card to\n  Register it')
    id, text = reader.read()
    ied="SELECT id FROM users WHERE rfid_uid = '"+str((hex(id)[2:10]))+"'"
#    print(ied)
    cursor.execute(ied)
    cursor.fetchone()

#    print(cursor.rowcount)
    if cursor.rowcount == -1:
      lcd.clear()
      lcd.message('  Card Scanned  ')
      print(hex(id)[2:10])
      q = False
    else:
      lcd.clear()
      lcd.message(" Card in System\n  Scan New Card")

#    time.sleep(2)
finally:
  GPIO.cleanup()

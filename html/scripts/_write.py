#!/usr/bin/env python

import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522

reader = SimpleMFRC522()

try:
        print("Now Place your tag to write")
        reader.write("Pinball")
        print("Written")
finally:
        GPIO.cleanup()

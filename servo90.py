import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BOARD)

GPIO.setup(7,GPIO.OUT)

p = GPIO.PWM(7,50)
p.start(7.5)

count=0

while (count<4):
	p.ChangeDutyCycle(2.5)
	time.sleep(0.25)
	p.ChangeDutyCycle(7.5)
	time.sleep(0.25)
	count=count+1

p.stop()

GPIO.cleanup()

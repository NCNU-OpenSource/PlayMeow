# PlayMeow

by 1032 Practical Linux System Administration Final Report Group 8 - 吳 芷 恩 <100212067>

For the Graphic Version, pls go to the following link:[Slide](http://www.slideshare.net/NoelNg2/1032-practical-linux-system-administration-49811992)

![PlayMeow](https://raw.githubusercontent.com/NCNU-OpenSource/PlayMeow/master/playmeow.png)


##題目發想緣起
[參考影片](https://www.youtube.com/watch?v=Xa6ajRZU1ss)

##實作所需材料
 材料 | 取得來源 | 價格 
------------ | ------------- | -------------
Raspberry Pi|			BlueT|			$－－
Logitech Webcam C310|		PChome|			$699
Servo motor SG90|		Ruten|			$48
Stepper motor 28BYJ-48-5V|	Ruten|			$50
ULN2003 Driver Board|		Ruten|			$27
Dupont Line|			Ruten|			$20
Steel wire|			Hardware store|		$5
Mouse toy|			DAISO|			$39

##運用與課程內容中相關的技巧
- Web server - LAMP

- Automatically send ip to Email - Postfix

##使用的現有軟體與來源
1.Stepper motor
-software: [Pi4J] (http://pi4j.com/)
-[code](https://github.com/Pi4J/pi4j/blob/master/pi4j-example/src/main/java/StepperMotorGpioExample.java)

2.Servo motor
-software: Python
-[code](https://www.youtube.com/watch?v=ddlDgUymbxc)

3.Webcam
-software: [MJPG-streamer](http://sourceforge.net/projects/mjpg-streamer/)

4.Webpage
-software: LAMP
-code: HTML, [PHP](http://php.net/manual/en/function.shell-exec.php), JavaScript [AJAX](http://www.w3schools.com/ajax/ajax_example.asp)

##實作過程 - GPIO 配置
1.ULN2003 Driver Board (Stepper motor)
-pin 2,6,11,12,13,15
![step](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration.png)

2.Servo motor
-pin 4,7,20
![servo](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(1).png)

##實作過程 - webcam
![webcam](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(2).png)

##實作過程 － MJPG-streamer
1.Builds MJPG-streamer
```
sudo apt-get update
sudo apt-get install subversion libjpeg8-dev imagemagick
sudo svn checkout svn://svn.code.sf.net/p/mjpg-streamer/code
cd code/mjpg-streamer
sudo make clean all
export LD_LIBRARY_PATH=.
./mjpg_streamer -i "./input_uvc.so" -o "./output_http.so -w ./www"
```
2.Auto run MJPG-streamer when pi boots up
```
sudo vim /etc/rc.local
add codes before exit 0 :
export STREAMER_PATH=/home/pi/code/mjpg-streamer
export LD_LIBRARY_PATH=$ STREAMER_PATH
$STREAMER_PATH/mjpg_streamer -i “input_uvc.so -y = YUYV” -o “output_http.so -w $STREAMER_PATH/www”  &s
```

##實作過程 － Coding (servo90.php & servo90.py)
1.servo90.php
```php
<?php
echo shell_exec("sudo python servo90.py")
?>
```
2.servo90.py
```python
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
```

##實作過程 － Coding (servo180.php & servo180.py)
1.servo180.php
```php
<?php
echo shell_exec("sudo python servo180.py")
?>
```
2.servo180.py
```python
import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BOARD)

GPIO.setup(7,GPIO.OUT)

p = GPIO.PWM(7,50)
p.start(7.5)

count=0

while (count<4):
        p.ChangeDutyCycle(12.5)
        time.sleep(0.5)
        p.ChangeDutyCycle(2.5)
        time.sleep(0.5)
        count=count+1

p.stop()

GPIO.cleanup()
```

##實作過程 － Coding (step45/-45/90/-90/180/-180.php)
1.step45.php
```php
<?php
echo shell_exec("sudo java -classpath .:classes:/opt/pi4j/lib/'*' step45")
?>
```
2.step-45.php
```php
<?php
echo shell_exec("sudo java -classpath .:classes:/opt/pi4j/lib/'*' stepm45")
?>
```
3.step90.php
```php
<?php
echo shell_exec("sudo java -classpath .:classes:/opt/pi4j/lib/'*' step90")
?>
```
4.step-90.php
```php
<?php
echo shell_exec("sudo java -classpath .:classes:/opt/pi4j/lib/'*' stepm90")
?>
```
5.step180.php
```php
<?php
echo shell_exec("sudo java -classpath .:classes:/opt/pi4j/lib/'*' step180")
?>
```
6.step-180.php
```php
<?php
echo shell_exec("sudo java -classpath .:classes:/opt/pi4j/lib/'*' stepm180")
?>
```

##實作過程 － Coding (step45.java)
-step45.java
```java
import com.pi4j.component.motor.impl.GpioStepperMotorComponent;
import com.pi4j.io.gpio.GpioController;
import com.pi4j.io.gpio.GpioFactory;
import com.pi4j.io.gpio.GpioPinDigitalOutput;
import com.pi4j.io.gpio.PinState;
import com.pi4j.io.gpio.RaspiPin;

/**
 * This example code demonstrates how to control a stepper motor
 * using the GPIO pins on the Raspberry Pi.  
 * 
 * @author Robert Savage
 */
public class step45 {
    
    public static void main(String[] args) throws InterruptedException {
        
        System.out.println("<--Pi4J--> GPIO Stepper Motor Example ... started.");
        
        // create gpio controller
        final GpioController gpio = GpioFactory.getInstance();
        
        // provision gpio pins #00 to #03 as output pins and ensure in LOW state
        final GpioPinDigitalOutput[] pins = {
                gpio.provisionDigitalOutputPin(RaspiPin.GPIO_00, PinState.LOW),
                gpio.provisionDigitalOutputPin(RaspiPin.GPIO_01, PinState.LOW),
                gpio.provisionDigitalOutputPin(RaspiPin.GPIO_02, PinState.LOW),
                gpio.provisionDigitalOutputPin(RaspiPin.GPIO_03, PinState.LOW)};

        // this will ensure that the motor is stopped when the program terminates
        gpio.setShutdownOptions(true, PinState.LOW, pins);
        
        // create motor component
        GpioStepperMotorComponent motor = new GpioStepperMotorComponent(pins);

        // @see http://www.lirtex.com/robotics/stepper-motor-controller-circuit/
        //      for additional details on stepping techniques

        // create byte array to demonstrate a single-step sequencing
        // (This is the most basic method, turning on a single electromagnet every time.
        //  This sequence requires the least amount of energy and generates the smoothest movement.)
        byte[] single_step_sequence = new byte[4];
        single_step_sequence[0] = (byte) 0b0001;  
        single_step_sequence[1] = (byte) 0b0010;
        single_step_sequence[2] = (byte) 0b0100;
        single_step_sequence[3] = (byte) 0b1000;

        // create byte array to demonstrate a double-step sequencing
        // (In this method two coils are turned on simultaneously.  This method does not generate 
        //  a smooth movement as the previous method, and it requires double the current, but as 
        //  return it generates double the torque.)
        byte[] double_step_sequence = new byte[4];
        double_step_sequence[0] = (byte) 0b0011;  
        double_step_sequence[1] = (byte) 0b0110;
        double_step_sequence[2] = (byte) 0b1100;
        double_step_sequence[3] = (byte) 0b1001;
        
        // create byte array to demonstrate a half-step sequencing
        // (In this method two coils are turned on simultaneously.  This method does not generate 
        //  a smooth movement as the previous method, and it requires double the current, but as 
        //  return it generates double the torque.)
        byte[] half_step_sequence = new byte[8];
        half_step_sequence[0] = (byte) 0b0001;  
        half_step_sequence[1] = (byte) 0b0011;
        half_step_sequence[2] = (byte) 0b0010;
        half_step_sequence[3] = (byte) 0b0110;
        half_step_sequence[4] = (byte) 0b0100;
        half_step_sequence[5] = (byte) 0b1100;
        half_step_sequence[6] = (byte) 0b1000;
        half_step_sequence[7] = (byte) 0b1001;

        // define stepper parameters before attempting to control motor
        // anything lower than 2 ms does not work for my sample motor using single step sequence
        motor.setStepInterval(1);  
        motor.setStepSequence(double_step_sequence);

        // There are 32 steps per revolution on my sample motor, and inside is a ~1/64 reduction gear set.
        // Gear reduction is actually: (32/9)/(22/11)x(26/9)x(31/10)=63.683950617
        // This means is that there are really 32*63.683950617 steps per revolution =  2037.88641975 ~ 2038 steps! 
        motor.setStepsPerRevolution(2038);
       
	motor.rotate(0.125); 

        System.out.println("   Motor STOPPED.");
        // final stop to ensure no motor activity
        motor.stop();

        // stop all GPIO activity/threads by shutting down the GPIO controller
        // (this method will forcefully shutdown all GPIO monitoring threads and scheduled tasks)
        gpio.shutdown();        
    }
}
```

##實作過程 － Coding(stepm45/90/m90/180/m180.java)
change some code...
1.stepm45.java
```java
public class stepm45 {
……………….
        motor.rotate(-0.125);
```
2.step90.java
```
public class step90 {
……………….
        motor.rotate(0.25);
```
3.stepm90.java
```
public class stepm90 {
……………….
        motor.rotate(-0.25);
```
4.step180.java
```
public class step180 {
……………….
        motor.rotate(0.5);
```
5.stepm180.java
```
public class step180 {
……………….
        motor.rotate(0.5);
```
編譯每一個.java
```
sudo javac -classpath .:classes:/opt/pi4j/lib/'*' -d . step45.java
```

##實作過程 － Coding(index.php)
-index.php
```php
<html>
<Iframe src="http://192.168.0.106:8080/javascript_simple.html" width="660" height="500"></Iframe>
<p>toy control:
<button type="button" name="button" onclick="servo90()">90 degrees</button>
<button type="button" name="button2" onclick="servo180()">180 degrees</button></p>
<p>Webcam control:
<img src="playmeow.png" align="right" height="100">
<button type="button" name="button3" onclick="step45()">L 45 degrees</button>
<button type="button" name="button4" onclick="stepm45()">R 45 degrees</button></p>
<p><font color="#ffffff">Webcam control: </font>
<button type="button" name="button5" onclick="step90()">L 90 degrees</button>
<button type="button" name="button6" onclick="stepm90()">R 90 degrees</button></p>
<p><font color="#ffffff">Webcam control: </font>
<button type="button" name="button7" onclick="step180()">L 180 degrees</button>
<button type="button" name="button8" onclick="stepm180()">R 180 degrees</button></p>
<script>
function servo90(){
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","servo90.php",true);
xmlhttp.send();
}
function servo180(){
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","servo180.php",true);
xmlhttp.send();
}
function step45(){
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step45.php",true);
xmlhttp.send();
}
function stepm45(){
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step-45.php",true);
xmlhttp.send();
}
function step90(){
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step90.php",true);
xmlhttp.send();
}
function stepm90(){
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step-90.php",true);
xmlhttp.send();
}
function step180(){
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step180.php",true);
xmlhttp.send();
}
function stepm180(){
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step-180.php",true);
xmlhttp.send();
}
</script>
</html>
```

##實作過程 
![1](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(3).png)
![2](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(4).png)

##實作過程 - 困難與解決
1.！在網頁上控制 伺服馬達＆步進馬達 ！

-以超連結控制會跳出新視窗      Noooooo~!!!

-Helper - RichEGG

-RichEGG : 改用AJAX ~

2.！在沒有Public ip、路由器不是自己的情況下，從外部開啟控制網頁！

-DDNS 無法設定      Noooooo~!!!

-以3G行動網卡代替      ＄_＄不是長遠之計

-Helper - BlueT

-BlueT : 可以用ssh 或vpn解決， 到 ipv6 普及就沒有這個問題了～

-ssh reverse tunnel       需要額外一台有Public ip的機器=.=

-VPN     綁定裝置以外的裝置會無法使用 T_T

-無解 >_<....

##實際產出 - 外觀
![s1](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(5).png)
![s2}(https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(6).png)

##實際產出 - 試玩（改良前）
[影片](https://www.youtube.com/watch?v=e_P9ZEpGHZU)

##實際產出 - 試玩 （改良後）
[影片]https://www.youtube.com/watch?v=sksyBGeRKPU

##實際產出 - Firefox
![firefox](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(7).png)

##實際產出 - Safari
![safari](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(8).png)

##實際產出 - Chrome
![chrome](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(9).png)

##實際產出 - ipad safari
![ipad](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(10).png)

##實際產出 - smartphone chrome
![smartphone](https://github.com/NCNU-OpenSource/PlayMeow/raw/master/img/1032%20Practical%20Linux%20System%20Administration%20(11).png)


##參考資料
1.網頁：
http://www.w3schools.com
https://www.youtube.com/watch?v=ddlDgUymbxc
http://www.codedata.com.tw/java/java-embedded-10-gpio-motor
http://www.ntex.tw/wordpress/545.html
https://sites.google.com/site/raspberypishare0918/
http://www.powenko.com/wordpress/?p=4324

2.書籍：

- Raspberry Pi最佳入門與實戰應用 ， 柯博文 ， 碁峰 ，2015-01-08

- Raspberry Pi超炫專案與完全實戰 ， 柯博文 ， 碁峰 ，2014-09-26

##END
THANK YOU !

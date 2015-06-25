<html>
<Iframe src="http://10.40.21.30:8080/javascript_simple.html" width="660" height="500"></Iframe>
<p>Toy control: 
<button type="button" name="button" onclick="servo90()">90 degrees</button>
<button type="button" name="button2" onclick="servo180()">180 degrees</button>
</p>

<p>Webcam control: 
<img src="playmeow.png" align="right" height="100">
<button type="button" name="button3" onclick="step45()">L 45 degrees</button>
<button type="button" name="button4" onclick="stepm45()">R 45 degrees</button>
</p>

<p><font color="#ffffff">Webcam control: </font>
<button type="button" name="button5" onclick="step90()">L 90 degrees</button>
<button type="button" name="button6" onclick="stepm90()">R 90 degrees</button>
</p>

<p><font color="#ffffff">Webcam control: </font>
<button type="button" name="button7" onclick="step180()">L 180 degrees</button>
<button type="button" name="button8" onclick="stepm180()">R 180 degrees</button>
</p>
<script>
function servo90()
{
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","servo90.php",true);
xmlhttp.send();
}
function servo180()
{
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","servo180.php",true);
xmlhttp.send();
}
function step45()
{
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step45.php",true);
xmlhttp.send();
}
function stepm45()
{
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step-45.php",true);
xmlhttp.send();
}
function step90()
{
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step90.php",true);
xmlhttp.send();
}
function stepm90()
{
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step-90.php",true);
xmlhttp.send();
}
function step180()
{
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step180.php",true);
xmlhttp.send();
}
function stepm180()
{
var xmlhttp=new XMLHttpRequest();
xmlhttp.open("POST","step-180.php",true);
xmlhttp.send();
}
</script>
</html>

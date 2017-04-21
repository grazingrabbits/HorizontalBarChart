<!DOCTYPE html>
<html>
<head>
	<title>
		Bar Chart
	</title>
	<style type="text/css">
      
      #barinfo { width: auto; height: auto; border: 5px solid #000; position: absolute; padding: 10px;  display: none; background-color: #fff; -moz-border-radius: 10px; border-radius: 10px; -webkit-border-radius: 10px; z-index: 11; }
		 #overlayCanvas { position: absolute; top: 0px; left: 0px; z-index: 10;}
	</style>


      <script
  src="https://code.jquery.com/jquery-3.1.1.js"
  integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
  crossorigin="anonymous"></script>
 


</head>
<body>
<div style="position: relative;">
	<div id="barinfo"></div>
	<canvas id="myCanvas"   style="background-color: #fff;" ></canvas>
	<canvas id="overlayCanvas"   style="background: transparent;" ></canvas>
</div>
<script type="text/javascript">
	
var noOfelements = 0;
var barHeight = 19; 
var spacing = 5;

var canvasWidth = 1100; // can use dynamic width here with jquery
var titleBlockWidth = 300;
var fontSize = "12px";
var fontHeight = '27';

// define the data here
var arrObjects = [ 
 { 'title' : 'Band', 'value' : 264, 'color' : '#27aae1'  }, 
{ 'title' : ' Chorus/choir/vocal ensemble', 'value' : 105, 'color' : '#27aae1'  },
{ 'title' : 'Computers and electronics/digital music', 'value' : 557, 'color' : '#27aae1'  },
{ 'title' : ' Instrumental music lessons (All)', 'value' : 20, 'color' : '#27aae1'  },

{ 'title' : 'MYP Drama', 'value' : 65, 'color' : '#7f3f98'  } ,
{ 'title' : 'Ceramics (Beginning and Advanced', 'value' : 344, 'color' : '#f7941e'  } 
	,
{ 'title' : 'Design', 'value' : 344, 'color' : '#f7941e'  } ,

{ 'title' : 'Drawing', 'value' : 344, 'color' : '#f7941e'  } ,

{ 'title' : 'Fashion design', 'value' : 200, 'color' : '#f7941e'  } ,
{ 'title' : 'Lettering/calligraphy', 'value' : 200, 'color' : '#f7941e'  } ,
{ 'title' : 'Painting', 'value' : 344, 'color' : '#f7941e'  } ,
{ 'title' : 'Printmaking', 'value' : 344, 'color' : '#f7941e'  } ,

];

 
noOfelements = arrObjects.length;
var canvasHeight = (barHeight + spacing) *  noOfelements;

if( canvasHeight < 400 )
{
	canvasHeight = 400;
}

//alert(noOfelements);
if ( noOfelements > 0 ) {

console.log(canvasHeight);
var c = document.getElementById("myCanvas");

$("#myCanvas").prop('height', canvasHeight);
$("#myCanvas").prop('width', canvasWidth);
$("#overlayCanvas").prop('height', canvasHeight);
$("#overlayCanvas").prop('width', canvasWidth);

var ctx = c.getContext("2d");

// draw left line
ctx.beginPath();
ctx.moveTo(titleBlockWidth,0);
ctx.lineTo(titleBlockWidth, canvasHeight - 65);

ctx.lineTo(canvasWidth , canvasHeight - 65);
ctx.stroke();


// draw right line

//ctx.moveTo(titleBlockWidth, canvasHeight - 65 );
//ctx.lineTo(titleBlockWidth, canvasWidth - titleBlockWidth);
//ctx.stroke();
	var maxWidth = 0;
	for( var x = 0; x < arrObjects.length; x++ )
	{

		 if( arrObjects[x]['value'] > maxWidth )
		 {
		 	maxWidth = arrObjects[x]['value'];
		 }
	}
	
	var ratio = 1;
	
		ratio = (canvasWidth -150  - titleBlockWidth) / maxWidth ;
	
	// draw lines
	var actualMaxValues = maxWidth  ;
	// we will draw total 10 lines
	var drawLines = 10;
	if ( (canvasWidth -150  - titleBlockWidth) < 300 )
	{
		drawLines = 5;
	}

	//check max Value and then set the values accordingly
	var dividedValue =  maxWidth / drawLines;
	
	console.log('divided value '+  parseInt(dividedValue).toString().length );

	//var valueLength = parseInt(dividedValue).toString().length;
	 	var k = 1
	 	var lineValue = 0;
		while(1)
		{
			if( (drawLines * k * 5) >=  maxWidth  )
			{
				lineValue = k * 5;
				break;
			}
			else if( (drawLines * k * 10 ) >=  maxWidth  )
			{
				lineValue = k * 10;
				break;
			}	
			k++;
		}
	
   console.log("line value "+drawLines);
console.log(" ratio  "+ratio);
var lineDistance = lineValue *  ratio; 

console.log("line distance "+lineDistance); 

   for( var z = 1; z <= drawLines; z++ )
	{
		
		ctx.beginPath();
		ctx.moveTo( titleBlockWidth + (lineDistance * z ) ,0);
		ctx.lineTo( titleBlockWidth + (lineDistance * z ), canvasHeight - 45 );
		ctx.strokeStyle = "#999";
		//ctx.lineTo(canvasWidth , canvasHeight - 65);
		ctx.stroke();

		ctx.font="14px Arial";
		var txt =  lineValue * z;
		//ctx.fillText("width:" + ctx.measureText(txt).width,10,50)
		ctx.fillText(txt, titleBlockWidth + (lineDistance * z ) - (ctx.measureText(txt).width / 2) , canvasHeight - 20 );
		
		//ctx.fill();
	}

	for( var x = 0; x < arrObjects.length; x++ )
	{
		ctx.shadowBlur=0;
		ctx.shadowColor="none";
		ctx.shadowOffsetX = 0;
      	ctx.shadowOffsetY = 0;

		ctx.font=fontSize+" Arial";
		ctx.fillStyle = arrObjects[x]['color'];
		var txt =  arrObjects[x]['title'];
		
		ctx.fillText(txt, titleBlockWidth -  ctx.measureText(txt).width - 10 , (x * (barHeight + 7) ) + 5 + fontHeight / 2    );

		
		console.log("bar height "+barHeight);
		console.log((x * barHeight)  + 5);
		
		ctx.shadowBlur=5;
		ctx.shadowColor="#999";
		ctx.shadowOffsetX = 3;
      	ctx.shadowOffsetY = 2;

		ctx.fillRect( titleBlockWidth+2, (x * (barHeight + 7) ) + 5  , arrObjects[x]['value'] * ratio, barHeight );
		//ctx.fill();
	}
	

}

function writeMessage(canvas, message) {
        var context = canvas.getContext('2d');
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.font = '18pt Calibri';
        context.fillStyle = 'black';
        context.fillText(message, 10, 25);
      }

 function getMousePos(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
          x: evt.clientX - rect.left,
          y: evt.clientY - rect.top
        };
      }
      
var overlayCanvas = document.getElementById("overlayCanvas");

 

	var overlayCanvasCtx = overlayCanvas.getContext("2d"); 
	overlayCanvas.addEventListener('mousemove', function(evt) {
        var mousePos = getMousePos(c, evt);
        var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;
        //writeMessage(c, message);
        highlightBar(mousePos.x , mousePos.y )

      }, false);

      function highlightBar(z, i)
      {
      	var isFound = false;
      	overlayCanvasCtx.clearRect(0, 0, overlayCanvas.width, overlayCanvas.height);
      	for( var x = 0; x < arrObjects.length; x++ )
		{
			 
			if(  z >= titleBlockWidth + 2  && 
				z <= titleBlockWidth+2  + arrObjects[x]['value'] * ratio  && i >= ((x * (barHeight + 7) ) + 5)  && i <= ((x * (barHeight + 7) ) + 5 +  barHeight) )
			{

				console.log(arrObjects[x]['title']);
				$("#barinfo").css({'display':'block','left': (20+z)+"px", 'top': i+'px', 'border-color' : arrObjects[x]['color'] });
				$("#barinfo").html(arrObjects[x]['title']+"<br />"+arrObjects[x]['value']);

				overlayCanvasCtx.fillStyle = 'rgba(0, 0, 0, 0.3)';
				overlayCanvasCtx.fillRect( titleBlockWidth+2, (x * (barHeight + 7) ) + 5  , arrObjects[x]['value'] * ratio, barHeight );
				//ctx.fill();

				isFound = true;
			}
		//ctx.font=fontSize+" Arial";
		//ctx.fillStyle = arrObjects[x]['color'];
		//var txt =  arrObjects[x]['title'];
		
		//ctx.fillText(txt, titleBlockWidth -  ctx.measureText(txt).width - 10 , (x * (barHeight + 7) ) + 5 + fontHeight / 2    );

		
		//console.log("bar height "+barHeight);
		//console.log((x * barHeight)  + 5);
		
		//ctx.fillRect( titleBlockWidth+2, (x * (barHeight + 7) ) + 5  , arrObjects[x]['value'] * ratio, barHeight );
		//ctx.fill();
		}

		if( isFound == false )
		{
			$("#barinfo").css('display','none');
		}
      }

</script>
</body>
</html>
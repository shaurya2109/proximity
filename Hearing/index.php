<!--
	nwHacks 2019
	Shaurya Jain & Akshay Khandelwal
-->
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<script src = "js/array.js"></script>
		<script src = "js/script.js"></script>	
		<link rel="stylesheet" href="css/main.css">
		#f73859
	</head>
	<script>
		var name = localStorage.getItem("name");
		console.log(name);
		
		var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
		
		var recognition = new SpeechRecognition(); // Rec
		var recognizing = false; // Set value of recognizing as true or false
		var final_transcript = ''; // Final text
		recognition.continuous = true; // Continuous Speech Examples
		recognition.interimResults = false; // No in between results
		
		var words = []; // Save words individually
		
		var functions = [{
			id: 0,
			token: 'scan',
			msg: 'Opening camera for scanning',
			task: 'open_ocr',
			target: 'scan.php'
		}, 
		{
			id: 1,
			token: 'list',
			msg: 'Opening your to do list',
			task: 'open_todo',
			target: 'todo/todo.php'
		}];
		
		
		var hotwords = ['do','please','can', 'you', 'have', 'has'];
		
		
		/* Speech Settings for Playback */
		  	
		  	var tasks = [];
		
		// There are 4 events we can control for the speech
		
		recognition.onstart = function() {
			recognizing = true; // Set true if started
		}
		
		recognition.onend = function() {
			recognizing = false; // Set false if ended
		
			var first = words[0].toLowerCase();
			console.log(first);
		
			if(first == "akshay") {
				for(var i = 0; i < words.length; i++) {
					for(var j = 0; j < hotwords.length; j++) {
						if(words[i] == hotwords[j]) {
							var deadline = words[words.indexOf("by") + 1];
							
							var task = '';
		
							for(var k  = words.indexOf(hotwords[j])+1; k < words.indexOf("by"); k++) {
								task += words[k] + ' ';
							}
		
							console.log(task + ': ' + deadline);
		
							var obj = {'time': new Date().toLocaleTimeString().replace("/.*(\d{2}:\d{2}:\d{2}).*/", "$1"), 'task': task, 'deadline': deadline};
		
							tasks.push(obj);
		
							console.log(tasks);
						}
					}
				}
			} else {
				for(var i = 0; i < words.length; i++) {
					for(var j = 0; j < functions.length; j++) {
		
						if(words[i] == functions[j].token) {
							var msg = new SpeechSynthesisUtterance(functions[j].msg);
							window.speechSynthesis.speak(msg);
		
							window.location.href = functions[j].target;
		
		
						}
					}
				}
			}
		
			final_transcript = ''; // Clear final transcript
		
		}
		
		recognition.onresult = function(event) {
		    for (var i = event.resultIndex; i < event.results.length; ++i) {
		      if (event.results[i].isFinal) {
		        final_transcript += event.results[i][0].transcript;
		      } else {
		        interim_transcript += event.results[i][0].transcript;
		      }
		  	}
		
		  	console.log(final_transcript);
		  	words = final_transcript.split(" ");	
		}
		
		recognition.onerror = function(event) {
			console.log('Error: ' + event.error); // Display if any errors
		}
		
		function start(event) {
			if (recognizing) {
				recognition.stop();
			}
				recognition.start();
		}	
		
			
		
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#enter").focus();
			$(window).keypress(function(e) {
				var keycode = e.keyCode;
				if (keycode == 49) {
					window.location.href = '/4.php';
			    } else if (keycode == 50) {
			    	window.location.href = '/4.php';
			    } else if (keycode == 51) {
			    	window.location.href = '/4.php';
			    } else if (keycode == 52) {
			        window.location.href = '/4.php';
			    } else {
			    	return false;
			    }
			});
		});
	</script>
	<body>
		<a href="4.php">
			<button id = "trigger" onclick="start(event)">Start!</button>
			<div class="frame">
				<div id="screen">
					<img src="connectwithpeople.png" alt="connectwithpeople">
				</div>
			</div>
		</a>
	</body>
</html>
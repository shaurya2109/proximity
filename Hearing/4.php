<!--
	nwHacks 2019
	Shaurya Jain & Akshay Khandelwal
-->
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<script src = "js/script.js"></script>	
		<link rel="stylesheet" href="css/main.css">
	</head>
	<body>
		<script>	
			var name = localStorage.getItem("name");
			console.log(name);
			
			
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
				target: 'todo/'
				},
				{
				id: 2,
				token: name,
				msg: 'Someone is calling you',
				task: 'open_detect',
				target: 'detection.php'
				}];
			
				// new instance of speech recognition
				var recognition = new webkitSpeechRecognition();
				// set params
				recognition.continuous = true;
				recognition.interimResults = false;
				recognition.start();
			
				recognition.onresult = function(event){
				  
				  // delve into words detected results & get the latest
				  // total results detected
				  var resultsLength = event.results.length -1 ;
				  // get length of latest results
				  var ArrayLength = event.results[resultsLength].length -1;
				  // get last word detected
				  var saidWord = event.results[resultsLength][ArrayLength].transcript;
				  
				  // loop through links and match to word spoken
				 console.log(saidWord);
			
					var words = saidWord.split(" ");
			
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
			
				// speech error handling
				recognition.onerror = function(event){
				  console.log('error?');
				  console.log(event);
				}
			
		</script>
		<button id = "trigger" onclick="start(event)">Start!</button>
		<div class="frame">
			<div id="screen">
				<img src="homescreen.png" alt="homescreen">
			</div>
		</div>
	</body>
</html>
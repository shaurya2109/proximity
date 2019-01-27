	
	var name = 'Shaurya';

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
		target: 'scan.html'
	}, 
	{
		id: 1,
		token: 'list',
		msg: 'Opening your to do list',
		task: 'open_todo',
		target: 'todo.html'
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

		if(first == "shaurya") {
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

		

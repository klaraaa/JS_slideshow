/* DEBUG: */
"use strict";
var debugging = false; function trace(msg) {if (debugging) {console.log(msg);}}

// Setting global variables:
var currentID = 0;
var xml;
var images;
var ajax = new XMLHttpRequest();
var timer;

// Testing variables:
trace("currentID är inledningsvis: " + currentID);


ajax.onreadystatechange = function() {
	if (ajax.readyState == 4 && ajax.status == 200) {
		
		// eventlistener calling previmg
		document.getElementById("prevBTN").addEventListener("click", function(){
			event.preventDefault();
			prevImg();
		}, false);

		// eventlistener calling nextimg
		document.getElementById("nextBTN").addEventListener("click", function(){
			event.preventDefault();
			nextImg();
		}, false);
				
		// eventlistener calls previmg/ nextimg depending on keycode
		document.addEventListener("keydown", function(){
			if (event.keyCode === 37) {
				prevImg();
			}
			if (event.keyCode === 39) {
				nextImg();
			}
		}, false);

		// eventlistener calling play
		document.getElementById("playBTN").addEventListener("click", function(){
			event.preventDefault();
			play();
		}, false);

		// eventlistener calling pause
		document.getElementById("pauseBTN").addEventListener("click", function(){
			event.preventDefault();
			pause();
		}, false);

		// eventlistener calling slide
		document.getElementById("slideshowimg").addEventListener("click", function(){
			event.preventDefault();
			slide();
		}, false);

		/*
		DEBUG:
		try{parseXML();} catch(err){console.log("parseXML() gick fel! " + err);}
		*/
		
		parseXML();
		trace("OK, fil inladdad");
		displayCurrentID();
	}
}


ajax.open("GET", "images.xml", true);
ajax.send();


// Collects XML-content
function parseXML() {
	xml = ajax.responseXML;
	images = xml.getElementsByTagName("image");	
	trace("images är: " + images);
	thumbs();
	
	/*
	DEBUG:
	try {thumbs(images);}
	catch(err)
	{console.log("Fel från thumbnail-loopen. Felet är " + err);}
	*/
}
	

function thumbs() {
	var imageLiHTMLResult = "";
	for (var i = images.length - 1; i >= 0; i--) {
		var path = images[i].children[0].innerHTML;
		var caption = images[i].children[1].innerHTML;
		var date = images[i].children[2].innerHTML;
		trace("Loopad image path: " + path + " i är nu: " + i);
		imageLiHTMLResult += "<img id='" + i + "' class='XMLthumb' src='" + path + "'><p>" + caption + ", " + date + "</p>";
		document.getElementById("bildlista").innerHTML = imageLiHTMLResult;
	}

	trace("imageLiHTMLResult är: " + imageLiHTMLResult);
	thumbListeners();
	
	/*
	DEBUG:
	try {thumbListeners();}
	catch(err)
	{console.log("Fel från thumbnail-loopen. Felet är " + err);}
	*/
}


function thumbListeners(){
	var thumbs = document.getElementsByClassName('XMLthumb');
	
	// Add listener to thumbs onclick, update currentID to clicked image's ID.
	for (var i = thumbs.length-1; i >= 0; i--) {
		thumbs[i].addEventListener("click", function(){
			currentID = event.srcElement.id;
			displayCurrentID();
		});
	}
}


function displayCurrentID() {
	trace("displayCurrent har nu currentID: " + currentID);
	
	//update slideshow images src based on currentID:s value
	document.getElementById('slideshowimg').src = images[currentID].children[0].innerHTML;
	document.getElementById('deleteForm').innerHTML = "<input type='hidden' name='path' value='" + images[currentID].children[0].innerHTML + "'</input><button id='delete' type='submit' name='deleteID' value='" + images[currentID].getAttribute('id')  + "'><i class='fa fa-times fa-5x'></i></button>";
	document.getElementById('delete').addEventListener("click", parseXML());
}


function nextImg() {
	trace("nextIMG started.");
	
	// Update current img id value if you clicked next, if pics left in array
	if (++currentID >= images.length) {
		currentID = 0;
	} // alternative code: if (currentID < images.length-2) { currentID++; } else { currentID = 0; }
	displayCurrentID();
}


function prevImg() {
	trace("prevImg started.");
	
	// Update current img id value if you clicked prev, if pics left in array
	if (--currentID < 0) {
		currentID = images.length-1;
	}
	displayCurrentID();
}


// When pressed play btn - start timer/play slideshow
function play() {
	trace("playfunction started.");
	timer = setInterval("nextImg()",1500);
}


// When pressed pause, stop timer/slideshow
function pause() {
	trace("pausefunction started.");
 	if (timer) {
       // stop 
       clearInterval( timer );
       timer=null;
    }
}


// If slideshow img is pressed, start timer to play slideshow. if it is already playing while clicked, stop timer/slideshow
function slide(){
    if (timer) {
       // stop 
       clearInterval( timer );
       timer=null;
    }
    else {
       timer = setInterval("nextImg()",1500);
    }
}


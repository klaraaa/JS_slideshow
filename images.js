/* FELSÖKNING */
"use strict";
var debugging = true; function trace(msg) {if (debugging) {console.log(msg);}}


// AJAX
var ajax = new XMLHttpRequest();
ajax.onreadystatechange = function() {
	if (ajax.readyState == 4 && ajax.status == 200) {
		//generera XML-svar:
		parseXML();
		//trace("OK, fil inladdad"); try{parseXML();} catch(err){console.log("parseXML() gick fel! " + err);}
	}
}
ajax.open("GET", "images.xml", true);
ajax.send();


//XML-content
function parseXML() {
	var xml = ajax.responseXML;
	var images = xml.getElementsByTagName("image");	
	var imglista = document.getElementById("bildlista");
	trace("images är: " + images); trace("imglista: " + imglista);
	thumbs(images, imglista);	/* FELSÖK try {thumbs(images);}catch(err) {console.log("Fel i for-loopen där thumbnail-bilder hämtas från xml till JS. Felet är " + err);}*/
} //close parseXML function
	

function thumbs(images, imglista) {
	var imageLiHTMLResult = "";
	for (var i = images.length - 1; i >= 0; i--) {
		//trace("images[i] loopen är nu på: "); trace(images[i]);
		var path = images[i].children[0].innerHTML;
		var caption = images[i].children[1].innerHTML;
		var date = images[i].children[2].innerHTML;
		//trace("Loopad image child html path: " + path + " i är nu: " + i);
		imageLiHTMLResult += "<img id='" + i + "' class='XMLthumb' src='" + path + "'><p>" + caption + ", " + date + "</p>";
		imglista.innerHTML = imageLiHTMLResult;
	}
	//trace("Image child html i global var path: " + path); trace("Detta är den nya imageLiHTMLResult: " + imageLiHTMLResult);
	thumbListeners(imglista); /* FELSÖK try {thumbListeners(imglista);}catch(err) {console.log("Fel i for-loopen där event listeners lades till. Felet är " + err);}*/
}//close thumbs function


function thumbListeners(){
	var thumbs = document.getElementsByClassName('XMLthumb');
	for (var i = thumbs.length - 1; i >= 0; i--) {
		thumbs[i].addEventListener("click", show);
	}
}//close thumbListeners


function show(event){
	trace("Du klickade på ElementsByClassName('XMLthumb') som startade show-funktionen: " + event);
	var imgId = event.srcElement.attributes[0].value;
	var path = event.srcElement.attributes[2].value;
	// trace(event); trace("event.sourceElement attribute0, ID: " + imgId); trace("event.sourceElement attribute2, PATH: " + path);
 	document.getElementById("slideshow").innerHTML = "<div class='item'><h1>SNYGGT!</h1><input type='submit' id='prevBTN' name='pic_id' value='" + imgId + "'>Previous</button><img id='slideshowimg " + imgId + "' src='" + path + "'><input type='submit' id='nextBTN' name='pic_id' value='" + imgId + "'>Next</button></div>";
 	// addeventlistener prevBTN
	var prev = document.getElementById("prevBTN");
	prev.addEventListener("click", function(){prevImg(event);}, false);
 	// addeventlistener nextBTN
 	var next = document.getElementById("nextBTN");
 	next.addEventListener("click", function(){nextImg(event);}, false);
 	// trace("Previous is: " + prev); trace(prev); trace("Next is: " + next); trace(next);
}//close show function


function nextImg(event) {
	event.preventDefault();
	trace("Nu har du startat nextIMG-funktionen.");
	//var lastIdNumber = Number(imgId);
	//var imgId = lastIdNumber + 1;
	//document.getElementById("slideshow").innerHTML = "<div class='item'><h1>Bytt till nästa!</h1><form id='next'><button type='submit' value='hej'>Next</button></form><p>Next pic not loaded yet, but the id for it should be: " + imgId + "</p></div>";
}//close nextImg function


function prevImg(event) {
 	event.preventDefault();
	trace("Nu har du startat prevIMG-funktionen.");
	//var lastIdNumber = Number(imgId);
	//var imgId = lastIdNumber - 1;
	//document.getElementById("slideshow").innerHTML = "<div class='item'><h1>Bytt till förra!</h1><form id='last'><button type='submit' value='hej'>Last</button></form><p>Previous pic not loaded yet, but the id for it should be: " + imgId + "</p></div>";
}//close prevImg function


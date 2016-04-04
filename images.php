<?php
//var_dump(XML::getItems());
// If delete img id, remove node in xml
function deleteImg() {
	//var_dump($_POST);
	$xml = XML::getXML();
	$sxe = XML::getSxe();

	// deleteID comes from javascripts xml-connection and is collected when the deleteform is printed.
	// delete button works on the current picture in the slideshow
	$delete = $_POST["deleteID"];
	$path = $_POST["path"];
	
	// unset node in xml based on the id from js xml connections nodId for current pic in slideshow
	unset($sxe->xpath("image[@id='".$delete."']")[0]->{0});
	$sxe->asXML("images.xml");

	// remove existing file connection
	if (file_exists($path)) {
		unlink($path);
	}
}


// Debug function for tests
function tester($test, $debug = false){
	if ($debug === true) {
		echo $test;
	}
}


// This class gets an XML db instance, this can be separated to single document later
class XML{
	private static $xml;
	private static $sxe;
	private static $items;

	private function __construct(){}
	private function __clone(){}

	public static function getXML(){
		if(!self::$xml){
			self::$xml = simplexml_load_file("images.xml");
			return self::$xml;
		}else{
			return self::$xml;
		}
	}

	public static function getSxe(){
		if(!self::$sxe){
			$xml = self::getXML();
			self::$sxe = new SimpleXMLElement ($xml->asXML());
			return self::$sxe;
		}else{
			return self::$sxe;
		}
	}

	public static function getItems(){
		if(!self::$items){
			$sxe = self::getSxe();
			self::$items = $sxe->count();
			return self::$items;
		}else{
			return self::$items;
		}
	}
}//close XML class


function addImg(){
	$xml = XML::getXML();
	$sxe = XML::getSxe();
	$items = XML::getItems();

	// If we have filled out an add_image form - try uploading image
	if (isset($_POST['add_image'])) {
		//var_dump($_FILES);
		$target_folder = "uploads/";
		$target_name = $target_folder.basename($_FILES["min_bild"]["name"]);
		$type = pathinfo($target_name, PATHINFO_EXTENSION);
		
		// Check if the current filename alreade exists in uploads
		if (file_exists($target_name)) {
			echo "Use another filename";
			exit;
		}
		// Please check that your server allows this size, this won't work otherwise
		if ($_FILES["min_bild"]["size"] > 10000000) {
			echo "För stor fil.";
			exit;
		}
		if ($type != "jpg") {
			echo "Du får bara lägga upp jpg";
			exit;
		}

		// Feedback depending on result
		if (move_uploaded_file($_FILES["min_bild"]["tmp_name"], $target_name)) {
			echo "Upload done!";
		}else{
			echo "Upload went wrong!";
		}
		
		$path = $target_name;
		tester("path är: ".$path);
	
		// Generate autoincremented id to use in new node when added:
		$newId = generateNewId();

		$new_item = $sxe->addChild("image"); //ny nod, child till images. <image></image>
		$new_item->addChild("path", $path);	//ny child till image  <path>VÄRDE</path>
		$new_item->addChild("caption", $_POST["caption"]); //ny child till image  <caption>VÄRDE</caption>
		$new_item->addChild("date", $_POST["date"]); //ny child till image  <date>VÄRDE</date>
		$new_item->addAttribute("id", $newId); //nytt attribut till image. id="int generatenewid function"
		$sxe->asXML("images.xml"); //lägg nya noden som xml i images.xml
	}
}//close addImg


// Generate id for new xml node by taking last nodes id value+1
function generateNewId(){
	$items = XML::getItems();
	$images = XML::getSxe();

	if ($items != 0) {
		$xmlIDs = array();
		foreach ($images as $image) {
			$nodeIdXML = (int)$image->attributes();
			$xmlIDs[] = $nodeIdXML;
		}
		$arrID = $items - 1;
		$lastUsedXMLiD = $xmlIDs[$arrID];
		$newId = $lastUsedXMLiD + 1;
	}else{
		$newId = 0;
	}

	return $newId;
}//close generateNewId


// Loop through all available images to create thumbnails from php
function printNodes(){
	$xml = XML::getXML();
	$sxe = XML::getSxe();
	$items = XML::getItems();

	if ($items >= 1){
		$string = "<div class='nodecontainer container'>";
		$imgID = 0;

		foreach ($sxe as $image) {
			$nodeIdXML = (string)$image->attributes();
			$xmlIDs[] = $nodeIdXML;
			$string .= "<div class='item divnode'><img id='"
			.$imgID."' class='XMLthumb' src='"
			.$image->path."'><p>".$image->caption.", "
			.$image->date."</p></div>";
			$imgID++;
		}

		$string .="</div>";
		echo $string;
	}else{
		$string = "<div class='nodecontainer container'><p>Hej! Lägg in lite bilder i bildspelet :)</p></div>";
		echo $string;
	}
}//close printNodes

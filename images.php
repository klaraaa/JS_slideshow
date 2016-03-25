<?php
function tester($test, $debug = false){
	if ($debug === true) {
		echo $test;
	}
}





// gets XML:
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

	if (isset($_POST['add_image'])) {
		//var_dump($_FILES);
		$target_folder = "uploads/";
		$target_name = $target_folder.basename($_FILES["min_bild"]["name"]);
		$type = pathinfo($target_name, PATHINFO_EXTENSION);
		
		if (file_exists($target_name)) {
			echo "Use another filename";
			exit;
		}

		if ($_FILES["min_bild"]["size"] > 10000000) {
			echo "För stor fil.";
			exit;
		}

		if ($type != "jpg") {
			echo "Du får bara lägga upp jpg";
			exit;
		}

		if (move_uploaded_file($_FILES["min_bild"]["tmp_name"], $target_name)) {
			echo "Upload done!";
		}else{
			echo "Upload went wrong!";
		}
		
		$path = $target_name;
		tester("path är: ".$path);
	}// Lägg till KONTROLL av det som laddats upp eventuellt

	if (isset($_POST["add_image"])) {
		$new_item = $sxe->addChild("image"); //ny nod, child till images. <image></image>
		$new_item->addChild("path", $path);	//ny child till image  <path>VÄRDE</path>
		$new_item->addChild("caption", $_POST["caption"]); //ny child till image  <caption>VÄRDE</caption>
		$new_item->addChild("date", $_POST["date"]); //ny child till image  <date>VÄRDE</date>
		$new_item->addAttribute("id", $items); //nytt attribut till image. id="int från items"
		$sxe->asXML("images.xml"); //lägg nya noden som xml i images.xml
	}
	/* FEL/tester
		$i = 1;
		while($i <= $items) {
			tester("The number is: $i <br>");
			$i++;
		}
		tester("Antal: ".$items); //inten som vi la som id på nya image-noden
		//för o lägga till
		$node = $xml->xpath("image[@id='123']");
		tester("Ny node: ".$node);
		var_dump($node);
		//för o ta bort
		unset($sxe->xpath("image[@id='123']")[0]->{0});
	*/

	}//close addImg

function printNodes(){
	$xml = XML::getXML();
	$sxe = XML::getSxe();
	$items = XML::getItems();
	if ($items >= 1){
		// OBS! nod-ID är statiskt nu, ändra sedan
		// $nodeId = $sxe->image[0]->attributes();
		// tester("<br>Node id, int från nods id: ".$nodeId);

		$string = "<div class='nodecontainer container'>";
		foreach ($sxe as $image) {
			$string .= "<div class='item divnode'><img id='"
			.$image->attributes()."' class='XMLthumb' src='"
			.$image->path."'><p>".$image->caption.", "
			.$image->date."</p></div>";
		}
		$string .="</div>";
		echo $string;
	}else{
		$string = "<div class='nodecontainer container'><p>Hej! Lägg in lite bilder i bildspelet :)</p></div>";
		echo $string;
	}
}

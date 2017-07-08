<?php
function getCard($targetArray){
    $tempSelection = $targetArray[$tempSelection];
   if(count($tempSelection['colors'])===1){
        return $tempSelection['multiverseid'];
    }
}

echo "\r\n"."What set do you wish to mine?"."\r\n";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);

$setName = trim($line);

echo "\r\n"."Train or validate? [train/val]"."\r\n";
$handle = fopen ("php://stdin","r");
$type = trim(fgets($handle));

echo "\r\n"."Name this dataset:"."\r\n";
$handle = fopen ("php://stdin","r");
$name = trim(fgets($handle));


echo "Mining ".$setName."..."."\r\n"."\r\n";
sleep(2);

$jsonAllCards = file_get_contents("http://mtgjson.com/json/".$setName.".json");
$jsonAllCardsDecoded = json_decode($jsonAllCards, true)['cards'];

echo "Card Count: ".count($jsonAllCardsDecoded)."\r\n"."\r\n";
sleep(2);

$source = fopen('../data/src-'.$type.'-'.$name.'.txt', 'a');
$target = fopen('../data/tgt-'.$type.'-'.$name.'.txt', 'a');

foreach ($jsonAllCardsDecoded as &$value) {
	if($value['rarity']!="Basic Land"){
		fwrite($source, $value['name']."\n");
		fwrite($target, str_replace("\n", " ",$value['text'])."\n");
	}
}
unset($value);
fclose($source);
fclose($target);

echo "\r\n"."Data mined and written!"."\r\n";
?>

<?php 


$curl = curl_init('http://axe-level-1.herokuapp.com/');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$ret = curl_exec($curl);

$doc = new DomDocument;
$doc->loadHTML($ret);

$ans = array();
$tr_doms = $doc->getElementsByTagName('tr');
foreach ($tr_doms as $tr_dom) {
	$person = new stdClass();
	if($tr_dom->getElementsByTagName('td')->item(0)->nodeValue=='姓名'){
		continue;
	}
	$td_doms = $tr_dom->getElementsByTagName('td');
	$name = $td_doms->item(0)->nodeValue;
	$person->name = $name;
	$person->grades = new stdClass();
	$person->grades->{"國語"} = $td_doms->item(1)->nodeValue;
	$person->grades->{"數學"} = $td_doms->item(2)->nodeValue;
	$person->grades->{"自然"} = $td_doms->item(3)->nodeValue;
	$person->grades->{"社會"} = $td_doms->item(4)->nodeValue;
	$person->grades->{"健康教育"} = $td_doms->item(5)->nodeValue;
	
	array_push($ans, $person);

}

echo json_encode($ans,JSON_UNESCAPED_UNICODE);






 ?>
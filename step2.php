<?php 

$url = 'http://axe-level-1.herokuapp.com/lv2/?page=';
$ans = array();

for ($i=1; $i <=12 ; $i++) {
	
	$curl = curl_init($url.$i);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$ret = curl_exec($curl);
	
	$doc = new DomDocument;
	$doc->loadHTML($ret);

	$tr_doms = $doc->getElementsByTagName('tr');
	
	foreach ($tr_doms as $tr_dom) {
		$list = new stdClass();
		if($tr_dom->getElementsByTagName('td')->item(0)->nodeValue=='鄉鎮'){
			continue;
		}
		$td_doms = $tr_dom->getElementsByTagName('td');
		$list->town = $td_doms->item(0)->nodeValue;
		$list->village = $td_doms->item(1)->nodeValue;
		$list->name = $td_doms->item(2)->nodeValue;

		array_push($ans, $list);
	}
}

echo json_encode($ans,JSON_UNESCAPED_UNICODE);


?>
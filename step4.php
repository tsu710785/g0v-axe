<?php 

$url = 'http://axe-level-1.herokuapp.com/lv4/';
$header=array(
  'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36',
  'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
  'Accept-Language: zh-TW,zh;q=0.8,en-US;q=0.6,en;q=0.4',
  'Accept-Encoding: gzip,deflate,sdch',
  'Connection: keep-alive',
  'Host: axe-level-4.herokuapp.com',
  'Referer:http://axe-level-4.herokuapp.com/lv4/?page=1'
);

$ans = array();

for ($i=1; $i <=24 ; $i++) {
	
	$curl = curl_init($url."?page=".$i);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
	$ret = curl_exec($curl);
	
	$doc = new DomDocument;
	$doc->loadHTML($ret);
	// var_dump($ret);

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
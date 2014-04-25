
<?php
echo "<script>if(location.href.indexOf('refresh=1') == -1 ) {
  location.href = location.href + '?refresh=1';
 }
</script>";
ini_set("max_execution_time", "300");
$url = 'http://axe-level-1.herokuapp.com/lv3';
$ans = array();
session_start();
$strCookie = 'PHPSESSID='.$_COOKIE['PHPSESSID'];
session_write_close();

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_COOKIE, $strCookie);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
$ret = curl_exec($curl);

	$doc = new DomDocument;
	@$doc->loadHTML($ret);

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


for ($i=0;$i<=74;$i++) {
	session_start();
	$strCookie = 'PHPSESSID='.$_COOKIE['PHPSESSID'];
	session_write_close();

	$curl = curl_init($url."/?page=next");

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_COOKIE, $strCookie);
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
	$ret = curl_exec($curl);

	$doc = new DomDocument;
	@$doc->loadHTML($ret);

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
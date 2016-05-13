<?php

function upload($data) {
    $client_id = "//Enter Your Client-ID Here. See readme for more information";

    $pvars = array('image' => base64_encode($data));
    $timeout = 30;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
    $out = curl_exec($curl);

    curl_close($curl);

    $pms = json_decode($out, true);
    $url = $pms['data']['link'];
    return $url;
}

function uploadGDImage($imageResource){
	ob_start();
    imagepng($imageResource);
    $content = ob_get_contents();
    ob_end_clean();
	
	return upload($content);
}

function uploadFile($path){
	$content = file_get_contents($path);
	return upload($content)
}

function batchUploadFiles($array){
	$data = array();
	foreach($array as $img){
		$data[$img] = uploadFile($img);
	}
	return $data;
}

?>
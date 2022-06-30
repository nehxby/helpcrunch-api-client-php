<?php

$data = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HELPCRUNCH_SIGNATURE'] ?? NULL;

if (!empty($data) && !empty($signature)) {

	$private_key = '<<< YOUR WEBHOOK KEY >>>';

	$data = checkSignatureAndDecodeData($data, $signature, $private_key);

	if (!empty($data)) {
		$event = $data['event'] ?? 'empty';
		switch ($event) {
			case 'chats.new';
				// put your code here
				break;
		}
	}
}

function checkSignatureAndDecodeData($data, $their_signature, $private_key)
{
	$our_signature = hash_hmac('sha1', $data, $private_key, FALSE);

	if (hash_equals($our_signature, $their_signature)) {
		return json_decode($data, TRUE);
	}

	return NULL;
}

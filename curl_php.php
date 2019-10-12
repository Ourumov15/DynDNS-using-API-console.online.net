<?php 

$ONLINE_API='VOTRE_TOKEN_API_ICI';
$DOMAIN='votre_domaine.bzh';
$SUB='votre_sous-domaine';

$TYPE="A";
$ADDRESS=$_SERVER['REMOTE_ADDR']; //Récupération de l'Ip du client appellant la page.

$ipyet = gethostbyname($SUB.".".$DOMAIN); //Récupération de l'Ip en service sur l'enregistrement DNS.

if ($ipyet !== $ADDRESS) { //Comparaison de la nouvelle Ip et de celle en service.


	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.online.net/api/v1/domain/".$DOMAIN."/version/active");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "[{\"name\": \"".$SUB."\",\"type\": \"".$TYPE."\",\"changeType\": \"REPLACE\",\"records\": [{\"name\": \"".$SUB."\",\"type\": \"".$TYPE."\",\"priority\": 0,\"ttl\": 3600,\"data\": \"".$ADDRESS."\"}]}]");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');


	$headers = array();
	$headers[] = 'Authorization: Bearer '.$ONLINE_API;
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);

	if (curl_errno($ch)) {
		echo 'Erreur ENVOI:' . curl_error($ch);
	}
	curl_close($ch);
}

else {
	
	echo "Ip stay the same !" }
	

?>


<?php
	$file = fopen("export.csv","r"); //Onesignal Segment export file with just the player ids.
	$counter = 0;
	while(! feof($file))
	  {
	  	if($counter>0){
		  $data = fgetcsv($file);
		  delete_users($data[0]);
		  echo "$counter lines processed\n";
		}
		$counter++;
	  }

	fclose($file);

	function delete_users($player_id){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/players/'.$player_id.'?app_id=YOUR_APP_ID');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

		$headers = array();
		$headers[] = 'Authorization: Basic YOUR_ONESIGNAL_API_KEY';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		print_r($result."\n");

		curl_close ($ch);
	}
?>
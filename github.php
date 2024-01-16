<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.github.com/repos/clinicarehn/devizzy/tags",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer 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"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $tags = json_decode($response, true);
  usort($tags, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
  });
  $latestTag = $tags[0]['name'];
  echo "The latest tag is: " . $latestTag;
}
?>
<?

$url = "www.myapi.local/jsonTest";
//$content_assoc = array(
//    'ID' => '123456789abcdefghijklmnopqrstuvwxyz',
//    'name' => 'mike',
//    'more' => 'Testing'
//);
//$content = json_encode($content_assoc);
//
//$curl = curl_init($url);
//curl_setopt($curl, CURLOPT_HEADER, false);
//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($curl, CURLOPT_HTTPHEADER,
//    array("Content-type: application/json"));
//curl_setopt($curl, CURLOPT_POST, true);
//curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
//
//$json_response = curl_exec($curl);
//
//$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//
//if ( $status != 201 ) {
//    die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
//}
//
//curl_close($curl);

$fields = array(
    'ID' => '123456789abcdefghijklmnopqrstuvwxyz',
    'name' => 'mike',
    'more' => 'Testing'
);


$fields_string = '';
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
$result = curl_exec($ch);

echo $result;

//close connection
curl_close($ch);
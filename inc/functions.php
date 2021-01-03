<?php
$APIKey = "FlB6XSNJBbIN59fQwkAA9SvandmbGVX3ljaVRWCx";
//use Wruczek\PhpFileCache\PhpFileCache;
//$cache = new PhpFileCache();

function GetActiveMessages() {
    global $masterConnection;

    $sql = "SELECT userid, message FROM messages WHERE deleted IS NULL ORDER BY id DESC LIMIT 5;";
    return $masterConnection->query($sql);
}

function GetUserData($id) {
    global $APIKey;
//    global $cache;

    try {
        //if ($cache->isExpired($id . "|Name")) {
            $agent = 'Loading Screen';
            $url = "http://api.thexyznetwork.xyz/xsuite/profile/" . $id;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'apikey: ' . $APIKey,
            ));

            if(!$response = curl_exec($ch))
                echo curl_error($ch);

            curl_close($ch);
            $response = json_decode($response);

            //print_r($response[0]['result']);

            //$cache->store($id . "|Name", $response->result->name, 60*60);
            //$cache->store($id . "|Avatar", $response->result->avatar, 60*60);
        //}

        // Return the cache data
        return array("name" => $response->result->name, "avatar" => $response->result->avatar);
    } catch (Exception $e) {
        return array("name" => "Unknown", "avatar" => "https://steamuserimages-a.akamaihd.net/ugc/868480752636433334/1D2881C5C9B3AD28A1D8852903A8F9E1FF45C2C8/");
    }
}

function GetName($id) {
    $data = GetUserData($id);

    return $data['name'];
}
function GetAvatar($id) {
    $data = GetUserData($id);

    return $data['avatar'];
}
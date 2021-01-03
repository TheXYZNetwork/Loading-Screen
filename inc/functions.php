<?php
$APIKey = "FlB6XSNJBbIN59fQwkAA9SvandmbGVX3ljaVRWCx";
require_once("lib/cache.class.php");
$cache = new Cache();

function GetActiveMessages() {
    global $masterConnection;

    $sql = "SELECT userid, message FROM messages WHERE deleted IS NULL ORDER BY id DESC LIMIT 5;";
    return $masterConnection->query($sql);
}

function GetUserData($id) {
    global $APIKey;
    global $cache;

    $cache->setCache($id);

    $result = $cache->retrieve('name');

    try {
        if (!$result) {
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

            $cache->store("name", $response->result->name, 60*60);
            $cache->store("avatar", $response->result->avatar, 60*60);

            $agentusergroup = 'Loading Screen';
            $urlusergroup = "http://api.thexyznetwork.xyz/policerp/xadmin/usergroup/" . $id;
            $chusergroup = curl_init();
            curl_setopt($chusergroup, CURLOPT_URL, $urlusergroup);
            curl_setopt($chusergroup, CURLOPT_USERAGENT, $agentusergroup);
            curl_setopt($chusergroup, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chusergroup, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($chusergroup, CURLOPT_HTTPHEADER, array(
                'apikey: ' . $APIKey,
            ));

            if(!$responsegroup = curl_exec($chusergroup))
                echo curl_error($chusergroup);

            curl_close($chusergroup);
            $responseusergroup = json_decode($responsegroup);

            if(isset($responseusergroup->result->usergroup)) {
                if($responseusergroup->result->usergroup == 'superadmin') {
                    $colour = '#a333c8';
                } else if($responseusergroup->result->usergroup == 'developer') {
                    $colour = '#f2711c';
                } else if($responseusergroup->result->usergroup == 'trial-mod' || $responseusergroup->result->usergroup == 'jr-mod' || $responseusergroup->result->usergroup == 'moderator' || $responseusergroup->result->usergroup == 'senior-moderator' || $responseusergroup->result->usergroup == 'jr-admin' || $responseusergroup->result->usergroup == 'admin' || $responseusergroup->result->usergroup == 'senior-admin' || $responseusergroup->result->usergroup == 'staff-supervisor' || $responseusergroup->result->usergroup == 'staff-manager') {
                    $colour = '#2185d0';
                } else if($responseusergroup->result->usergroup == 'elite') {
                    $colour = '#00ffff';
                } else if($responseusergroup->result->usergroup == 'vip') {
                    $colour = '#ffd700';
                } else if($responseusergroup->result->usergroup == 'user') {
                    $colour = 'grey';
                } else {
                    $colour = 'grey';
                };
            } else {
                $colour = 'grey';
            };

            $cache->store("colour", $colour, 60*60);
        };

        // Return the cache data
        return array("name" => $cache->retrieve('name'), "avatar" => $cache->retrieve('avatar'), "colour" => $cache->retrieve('colour'));
    } catch (Exception $e) {
        return array("name" => "Unknown", "avatar" => "https://steamuserimages-a.akamaihd.net/ugc/868480752636433334/1D2881C5C9B3AD28A1D8852903A8F9E1FF45C2C8/", "colour" => "grey");
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
function GetColour($id) {
    $data = GetUserData($id);

    return $data['colour'];
}
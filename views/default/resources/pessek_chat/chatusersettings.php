<?php
	
    //elgg_get_logged_in_user_guid();
    
    $chat_domain = trim(elgg_get_plugin_setting('userxmppdomain', 'pessek_chat'));
    $resources = "/resource";
    
    $guid = elgg_get_logged_in_user_entity()->guid;
    $user = get_user($guid);
    $chat_username = $user->username;
    $chat_password = base64_decode ($user->secretkey);
    
    $chat_resources = $chat_username.'@'.$chat_domain.$resources;
    
    $result = array(
                        'jid' => $chat_resources,
                        'password' =>$chat_password 
                    );
                    
    echo json_encode($result);
    return json_encode($result);

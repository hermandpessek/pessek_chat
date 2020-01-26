<?php


    /**
    * Comment here for explanation of the options.
    *
    * Create a new XMPP Object with the required params
    *
    * @param string $jabberHost Jabber Server Host
    * @param string $boshUri    Full URI to the http-bind
    * @param string $resource   Resource identifier
    * @param bool   $useSsl     Use SSL (not working yet, TODO)
    * @param bool   $debug      Enable debug
    * bosh port: https://ejabberd-esfam.auf.org:5280/http-bind/ 5280 and 5281 we have to enable bosh on both url (http and https and only http should be used for prebinding)
    */
    
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $rand_val = substr( str_shuffle( $chars ), 0, 3 );
    
    $guid = elgg_get_logged_in_user_entity()->guid;
    $user = get_user($guid);
    $chat_username = $user->username;
    $chat_password =  base64_decode ($user->secretkey); 
    $resources = "resource".$chat_username.$rand_val.mt_rand(100,1000);
    $usergroup = elgg_echo('pessek_chat:settings:usergroup');
    
    $ejabberdip = trim(elgg_get_plugin_setting('ejabberdip', 'pessek_chat'));
    $xmlrpcport = trim(elgg_get_plugin_setting('xmlrpcport', 'pessek_chat'));
    $adminxmppdomain = trim(elgg_get_plugin_setting('adminxmppdomain', 'pessek_chat'));
    $adminxmppusername = trim(elgg_get_plugin_setting('adminxmppusername', 'pessek_chat'));
    $adminxmpppassword = trim(elgg_get_plugin_setting('adminxmpppassword', 'pessek_chat'));
    $userxmppdomain = trim(elgg_get_plugin_setting('userxmppdomain', 'pessek_chat'));
    $boshurl = trim(elgg_get_plugin_setting('boshurlhttp', 'pessek_chat'));
    
    $params = [
            "user" => $chat_username,
            "password" => $chat_password,
            "tld" => $userxmppdomain,
            "boshUrl" => $boshurl 
            //For openfire it's something like http://<your-xmpp-fqdn>:7070/http-bind/
        ];
        $xmpp = new XmppPrebind($params);
        echo json_encode($xmpp->connect()); //will return JID, SID, RID as JSON
    

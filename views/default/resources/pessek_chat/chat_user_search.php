<?php

    //elgg_get_logged_in_user_guid();
    
    $servername = "127.0.0.1";
    $username = "esfamaufchatlast";
    $password = "esfamaufchatlast";
    $dbname = "esfamaufchatlast";
    
    if( isset($_GET['q']) &&  $_GET['q']!=''){
    
        $guid = elgg_get_logged_in_user_entity()->guid;
        $user = get_user($guid);
        $elgg_username = $user->username;
        
        $userxmppdomain = trim(elgg_get_plugin_setting('userxmppdomain', 'pessek_chat'));
        $user_jid = $elgg_username .'@'.trim(elgg_get_plugin_setting('userxmppdomain', 'pessek_chat'));
        
        $search_key = strtolower($_GET['q']);
    
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT lusername, lfn FROM  vcard_search WHERE (username!='$elgg_username' AND username NOT IN (SELECT username from rosterusers where jid='$user_jid')) AND (lusername LIKE '%$search_key%' OR lfn LIKE '%$search_key%') LIMIT 10"); 
            $stmt->execute();

            $res = $stmt->setFetchMode(PDO::FETCH_NUM); 
            
            while ($row = $stmt->fetch()) {
                
                $result[] = array(
                            'id' => $row[0].'@'.$userxmppdomain,
                            'fullname' =>$row[1] 
                        );
            }
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
                        
        echo json_encode($result);
        return json_encode($result);
        
        $conn = null;
   }

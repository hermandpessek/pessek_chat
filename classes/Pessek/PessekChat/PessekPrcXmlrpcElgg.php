<?php
namespace Pessek\PessekChat;
use Elgg\Hook;
use Elgg\Event;
use ElggMenuItem;
use Psr\Log\LogLevel;

use Elgg\Request;
use Elgg\Http\ResponseBuilder;


class PessekPrcXmlrpcElgg{//PessekPrcXmlrpcElgg //pessek_prc_xmlrpc_elgg

    public function send_accept_invitation(PessekPrcConnector $User1, PessekPrcConnector $User2, $NickName, $subs){
            
            if($User1->check_account() === true && $User2->check_account()=== true)
            {
                
                $fullname = $NickName;
                
                if(str_word_count($NickName)>3){
                
                    $Nick = array();
                    $Nick = str_word_count($NickName, 1);
                    $NickName = $Nick[0]." ".$Nick[1]." ".$Nick[2];
                    
                }
                
                $this->invitation($User1, $User2, $NickName, $subs); //$this->invitation($User2, $User1, $NickName);
                $this->chat_user_vcard($User1, $User2, "FN", $fullname);
                $this->chat_user_vcard($User1, $User2, "NICKNAME", $NickName);
            
            }else{
                echo "c'est pas bon";
            }
	
	}
	
        protected function invitation(PessekPrcConnector $User1, PessekPrcConnector $User2, $NickName, $subs){
        
                $param_auth=array("user"=>$User1->get("admin_username"), "server"=>$User1->get("admin_vhost"), "password"=>$User1->get("admin_password"));
                
               /* $param_comm = array("localuser"=>$User1->get("other_username"),"localserver"=>$User1->get("other_vhost"), "user"=>$User2->get("other_username"), "server"=>$User2->get("other_vhost"), "group"=>$User1->get("usergroup"), "subs"=>$subs);*/
                $param_comm = array("localuser"=>$User1->get("other_username"),"localserver"=>$User1->get("other_vhost"), "user"=>$User2->get("other_username"), "server"=>$User2->get("other_vhost"), "nick"=>$NickName, "group"=>$User1->get("usergroup"), "subs"=>$subs);
     
                $param=array($param_auth, $param_comm);
                
                $request = xmlrpc_encode_request('add_rosteritem', $param, (array('encoding' => 'utf-8')));

                $context = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                                "Content-Type: text/xml\r\n" .
                                "Content-Length: ".strlen($request),
                    'content' => $request
                )));
                $val = "http://".$User1->get("rpc_server").":".$User1->get("rpc_port")."/RPC2";
                $file = file_get_contents($val, false, $context);

                $response = xmlrpc_decode($file,"utf8");

                if (xmlrpc_is_fault($response)) {
                    //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
		    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
                } else {
                    return $response;
                }
            
        }

        public function migrateInvitation(PessekPrcConnector $User1, PessekPrcConnector $User2, $NickName, $subs){
        
                $param_auth=array("user"=>$User1->get("admin_username"), "server"=>$User1->get("admin_vhost"), "password"=>$User1->get("admin_password"));
                
                $param_comm = array("localuser"=>$User1->get("other_username"),"localserver"=>$User1->get("other_vhost"), "user"=>$User2->get("other_username"), "server"=>$User2->get("other_vhost"), "nick"=>$NickName, "group"=>$User1->get("usergroup"), "subs"=>$subs);
     
                $param=array($param_auth, $param_comm);
                
                $request = xmlrpc_encode_request('add_rosteritem', $param, (array('encoding' => 'utf-8')));

                $context = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                                "Content-Type: text/xml\r\n" .
                                "Content-Length: ".strlen($request),
                    'content' => $request
                )));
                $val = "http://".$User1->get("rpc_server").":".$User1->get("rpc_port")."/RPC2";
                $file = file_get_contents($val, false, $context);

                $response = xmlrpc_decode($file,"utf8");

                if (xmlrpc_is_fault($response)) {
                    //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
		    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
                } else {
                    return $response;
                }
            
        }
        
        
        public function invitation_v(PessekPrcConnector $User1, PessekPrcConnector $User2, $NickName){

                
                $param_auth=array("user"=>$User1->get("admin_username"), "server"=>$User1->get("admin_vhost"), "password"=>$User1->get("admin_password"));
                
                $stanza = "<presence from='".$User1->get("other_username")."@".$User1->get("admin_vhost")."' to='".$User2->get("other_username")."@".$User2->get("admin_vhost")."' type='subscribe'/>";
                
                $param_comm = array("from"=>$User1->get("other_username")."@".$User1->get("admin_vhost"), "to"=>$User2->get("other_username")."@".$User2->get("admin_vhost"), "stanza"=>$stanza);
     
                $param=array($param_auth, $param_comm);
                
                $request = xmlrpc_encode_request('send_stanza', $param, (array('encoding' => 'utf-8')));

                $context = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                                "Content-Type: text/xml\r\n" .
                                "Content-Length: ".strlen($request),
                    'content' => $request
                )));
                $val = "http://".$User1->get("rpc_server").":".$User1->get("rpc_port")."/RPC2";
                $file = file_get_contents($val, false, $context);

                $response = xmlrpc_decode($file,"utf8");

                if (xmlrpc_is_fault($response)) {
                    //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
		    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
                } else {
                    return $response;
                }
            
        }
        
       protected function chat_user_vcard(PessekPrcConnector $User1, PessekPrcConnector $User2, $valueName, $valueContent){ //$valueName "PHOTO" "FN"
    
        $param_auth=array("user"=>$User1->get("admin_username"), "server"=>$User1->get("admin_vhost"), "password"=>$User1->get("admin_password"));
        
        $param_comm = array("user"=>$User2->get("other_username"),"host"=>$User2->get("other_vhost"), "name"=>$valueName, "content"=>$valueContent);
        
        $param=array($param_auth, $param_comm);
        
        $request = xmlrpc_encode_request('set_vcard', $param, (array('encoding' => 'utf-8'))); 
        
        $context = stream_context_create(array('http' => array(
        'method' => "POST",
        'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                    "Content-Type: text/xml\r\n" .
                    "Content-Length: ".strlen($request),
        'content' => $request
        )));
        
        $val = "http://".$User1->get("rpc_server").":".$User1->get("rpc_port")."/RPC2";

        $file = file_get_contents($val, false, $context);

        $response = xmlrpc_decode($file,"utf8");

        if (xmlrpc_is_fault($response)) {
            //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
	    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
        } else {
            return $response;
        }
    
    }
    
    public function chat_user_vcard_public(PessekPrcConnector $User1, PessekPrcConnector $User2, $valueName, $valueContent){ //$valueName "PHOTO" "FN"
    
        $param_auth=array("user"=>$User1->get("admin_username"), "server"=>$User1->get("admin_vhost"), "password"=>$User1->get("admin_password"));
        
        $param_comm = array("user"=>$User2->get("other_username"),"host"=>$User2->get("other_vhost"), "name"=>$valueName, "content"=>$valueContent);
        
        $param=array($param_auth, $param_comm);
        
        $request = xmlrpc_encode_request('set_vcard', $param, (array('encoding' => 'utf-8'))); 
        
        $context = stream_context_create(array('http' => array(
        'method' => "POST",
        'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                    "Content-Type: text/xml\r\n" .
                    "Content-Length: ".strlen($request),
        'content' => $request
        )));
        
        $val = "http://".$User1->get("rpc_server").":".$User1->get("rpc_port")."/RPC2";

        $file = file_get_contents($val, false, $context);

        $response = xmlrpc_decode($file,"utf8");

        if (xmlrpc_is_fault($response)) {
            //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])"); 
	    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
        } else {
            return $response;
        }
    
    }
    
    public function chat_user_vcard_avatar(PessekPrcConnector $User1, PessekPrcConnector $User2, $name, $subname, $valueContent){ //$valueName "PHOTO" "FN"
    
        $param_auth=array("user"=>$User1->get("admin_username"), "server"=>$User1->get("admin_vhost"), "password"=>$User1->get("admin_password"));
        
        $param_comm = array("user"=>$User2->get("other_username"),"host"=>$User2->get("other_vhost"), "name"=>$name, "subname"=>$subname, "content"=>$valueContent);
        
        $param=array($param_auth, $param_comm);
        
        $request = xmlrpc_encode_request('set_vcard2', $param, (array('encoding' => 'utf-8')));
        
        $context = stream_context_create(array('http' => array(
        'method' => "POST",
        'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                    "Content-Type: text/xml\r\n" .
                    "Content-Length: ".strlen($request),
        'content' => $request
        )));
        
        $val = "http://".$User1->get("rpc_server").":".$User1->get("rpc_port")."/RPC2";

        $file = file_get_contents($val, false, $context);

        $response = xmlrpc_decode($file,"utf8");

        if (xmlrpc_is_fault($response)) {
            //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
	    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
        } else {
            return $response;
        }
    
    }
        
        public function MiseAjourPhotoProofile(PessekPrcConnector $User1, $pictureLink){
        
            $this->TofInsntantMessaging1($User1, $pictureLink);
            $this->TofInsntantMessaging2($User1, $pictureLink);
            
             
        }
        
    protected function TofInsntantMessaging1(PessekPrcConnector $User1, $pictureLink){
    
        $param_auth=array("user"=>$User1->get("admin_username"), "server"=>$User1->get("admin_vhost"), "password"=>$User1->get("admin_password"));
        
        $param_comm = array("user"=>$User1->get("other_username"),"host"=>$User1->get("other_vhost"), "name"=>"PHOTO", "content"=>$pictureLink);
        
        $param=array($param_auth, $param_comm);
        
        $request = xmlrpc_encode_request('set_vcard', $param, (array('encoding' => 'utf-8'))); 
        
        $context = stream_context_create(array('http' => array(
        'method' => "POST",
        'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                    "Content-Type: text/xml\r\n" .
                    "Content-Length: ".strlen($request),
        'content' => $request
        )));
        
        $val = "http://".$User1->get("rpc_server").":".$User1->get("rpc_port")."/RPC2";

        $file = file_get_contents($val, false, $context);

        $response = xmlrpc_decode($file,"utf8");

        if (xmlrpc_is_fault($response)) {
            //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
	    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
        } else {
            return $response;
        }
    
    }
    
    protected function TofInsntantMessaging2(PessekPrcConnector $User1, $pictureLink){
    
        $param_auth=array("user"=>$User1->get("admin_username"), "server"=>$User1->get("admin_vhost"), "password"=>$User1->get("admin_password"));
        
        $param_comm = array("user"=>$User1->get("other_username"),"host"=>$User1->get("other_vhost"), "name"=>"PHOTO", "subname"=>"EXTVAL", "content"=>$pictureLink);
           
        $param=array($param_auth, $param_comm);
        
        $request = xmlrpc_encode_request('set_vcard2', $param, (array('encoding' => 'utf-8')));
        
        $context = stream_context_create(array('http' => array(
        'method' => "POST",
        'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                    "Content-Type: text/xml\r\n" .
                    "Content-Length: ".strlen($request),
        'content' => $request
        )));
        
        $val = "http://".$User1->get("rpc_server").":".$User1->get("rpc_port")."/RPC2";

        $file = file_get_contents($val, false, $context);

        $response = xmlrpc_decode($file,"utf8");

        if (xmlrpc_is_fault($response)) {
            //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
	    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
        } else {
            return $response;
        }
    }
    
    public function removeFriendship (PessekPrcConnector $User1, PessekPrcConnector $User2) {
        
        
                $param_auth=array("user"=>$User1->get("admin_username"), "server"=>$User1->get("admin_vhost"), "password"=>$User1->get("admin_password"));
                
                $param_comm = array("localuser"=>$User1->get("other_username"),"localserver"=>$User1->get("other_vhost"), "user"=>$User2->get("other_username"), "server"=>$User2->get("other_vhost"));
     
                $param=array($param_auth, $param_comm);
                
                $request = xmlrpc_encode_request('delete_rosteritem', $param, (array('encoding' => 'utf-8')));

                $context = stream_context_create(array('http' => array(
                    'method' => "POST",
                    'header' => "User-Agent: XMLRPC::Client mod_xmlrpc\r\n" .
                                "Content-Type: text/xml\r\n" .
                                "Content-Length: ".strlen($request),
                    'content' => $request
                )));
                $val = "http://".$User1->get("rpc_server").":".$User1->get("rpc_port")."/RPC2";
                $file = file_get_contents($val, false, $context);

                $response = xmlrpc_decode($file,"utf8");

                if (xmlrpc_is_fault($response)) {
                    //trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
		    elgg_log("xmlrpc: $response[faultString] ($response[faultCode])", LogLevel::ERROR);
                } else {
                    return $response;
                }
    }

    public function checkAccountCreated ($chat_username, $usergroup, $chat_password, $guid) {
	  
	    $chat_user = new \Pessek\PessekChat\PessekPrcConnector($chat_username);

	    if(!$chat_user->check_account()){
		
		//$guid = elgg_get_logged_in_user_entity()->guid;
		$user = get_user($guid);
	    
		$UserSender = new \Pessek\PessekChat\PessekPrcConnector($chat_username, $usergroup, $chat_password);
		$UserSender->create_account();
		    
		$photo_type = "image/jpeg";
		//$photo_binval = base64_encode(file_get_contents($user->getIconURL('large'),false,$context));
		//$photo_binval = base64_encode(UserAvatarCurl($user));
		/*
		$icon = $user->getIcon('large');
		$contents = $icon->grabFile();
		$photo_binval = base64_encode($contents);*/
		
		$context = array(
		    'ssl' => array(
		    'verify_peer' => false,
		    'verify_peer_name' => false,
		    'allow_self_signed' => true
		    )
		);
		
		$testP = elgg_get_plugins_path().'pessek_chat/images/defaultlarge.jpeg';
		$context = stream_context_create($context);
		$photo_binval = base64_encode(file_get_contents($testP,false,$context));
		
		
		$fullname = ucwords(strtolower($user->getDisplayName()));
		
		$NickName = $fullname;
		
		if(str_word_count($fullname)>3){
	    
		        $Nick = array();
		        $Nick = str_word_count($fullname, 1);
		        $NickName = $Nick[0]." ".$Nick[1]." ".$Nick[2];
		            
		}
		    
		$this->chat_user_vcard_public($chat_user, $chat_user, "FN", $NickName);
		$this->chat_user_vcard_public($chat_user, $chat_user, "NICKNAME", $NickName);
		        
		$this->chat_user_vcard_avatar($chat_user, $chat_user, "PHOTO", "TYPE", $photo_type);
		$this->chat_user_vcard_avatar($chat_user, $chat_user, "PHOTO", "BINVAL", $photo_binval);
	    } 
    }

    public function deleteXMPPUser($chat_username, $usergroup, $chat_password, $guid){
	  
	    $chat_user = new \Pessek\PessekChat\PessekPrcConnector($chat_username);

	    if($chat_user->check_account()){
		
		//$guid = elgg_get_logged_in_user_entity()->guid;
		$user = get_user($guid);
	    
		$UserSender = new \Pessek\PessekChat\PessekPrcConnector($chat_username, $usergroup, $chat_password);
		$UserSender->delete_account();
		
	    }
     }


}

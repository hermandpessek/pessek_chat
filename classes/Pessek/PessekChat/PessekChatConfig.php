<?php
namespace Pessek\PessekChat;
use Elgg\Hook;
use Elgg\Event;
use ElggMenuItem;
use Psr\Log\LogLevel;

use Elgg\Request;
use Elgg\Http\ResponseBuilder;

class PessekChatConfig {
	
	/**
	 * Add menu items to the topbar
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value the current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function xmpp_user_when_elgg_admin_user_import_through_upload_users(Hook $hook) {

		$user = $hook->getUserParam();
    
    		$guid = (string)$user->guid;
	    	$chat_username = $user->username;
	    	$chat_password = $user->password;
	    	$usergroup = elgg_echo('pessek_chat:settings:usergroup');
	    
	   	$user->secretkey = base64_encode ($chat_password);

    		$pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();
    		$pessek_prc->checkAccountCreated($chat_username, $usergroup, $chat_password, $guid);

	}

	public static function pessek_chat_config_user_page(Hook $hook) {

		$value = $hook->getValue();
	
	    	$guid = elgg_get_logged_in_user_entity()->guid;
	    	$user = get_user($guid);
	    	$elgg_username = $user->username;
	   	$current_lang = get_current_language();
	    
	    	$value['pessek_chat']['user_jid'] = $elgg_username .'@'.trim(elgg_get_plugin_setting('userxmppdomain', 'pessek_chat'));
	    	$value['pessek_chat']['bosh_service_url'] = trim(elgg_get_plugin_setting('boshurl', 'pessek_chat'));
	    	$value['pessek_chat']['websocket_url_non_secure'] = trim(elgg_get_plugin_setting('websocketurl', 'pessek_chat'));
	    	$value['pessek_chat']['websocket_url_secure'] = trim(elgg_get_plugin_setting('websocketurl_secure', 'pessek_chat'));
	    	$value['pessek_chat']['credentials_url'] = elgg_get_site_url() . 'pessek_chat/chatusersettings';
	    	$value['pessek_chat']['prebind_url'] = elgg_get_site_url() . 'pessek_chat/chatusersettingsprebind';
	    	$value['pessek_chat']['userxmppdomain'] = trim(elgg_get_plugin_setting('userxmppdomain', 'pessek_chat'));
	    	$value['pessek_chat']['sounds_path'] = elgg_get_site_url() . 'mod/pessek_chat/lib/sounds/';
	    	$value['pessek_chat']['notification_icon'] = elgg_get_site_url() . 'mod/pessek_chat/images/';
	    	$value['pessek_chat']['site_url'] = elgg_get_site_url();
	    	$value['pessek_chat']['user_jid_pass'] = base64_decode ($user->secretkey);
	    	$value['pessek_chat']['view_mode'] = $user->chatViewMode; //$_SESSION['view_mode'];
	    
	    	return $value;
	}

	public static function pessek_chat_config_user_site(Hook $hook) {

		$value = $hook->getValue();
	
	    	$guid = elgg_get_logged_in_user_entity()->guid;
	    	$user = get_user($guid);
	    	$elgg_username = $user->username;
	   	$current_lang = get_current_language();
	    
	    	$value['pessek_chat']['user_jid'] = $elgg_username .'@'.trim(elgg_get_plugin_setting('userxmppdomain', 'pessek_chat'));
	    	$value['pessek_chat']['bosh_service_url'] = trim(elgg_get_plugin_setting('boshurl', 'pessek_chat'));
	    	$value['pessek_chat']['websocket_url_non_secure'] = trim(elgg_get_plugin_setting('websocketurl', 'pessek_chat'));
	    	$value['pessek_chat']['websocket_url_secure'] = trim(elgg_get_plugin_setting('websocketurl_secure', 'pessek_chat'));
	    	$value['pessek_chat']['credentials_url'] = elgg_get_site_url() . 'pessek_chat/chatusersettings';
	    	$value['pessek_chat']['prebind_url'] = elgg_get_site_url() . 'pessek_chat/chatusersettingsprebind';
	    	$value['pessek_chat']['userxmppdomain'] = trim(elgg_get_plugin_setting('userxmppdomain', 'pessek_chat'));
	    	$value['pessek_chat']['sounds_path'] = elgg_get_site_url() . 'mod/pessek_chat/lib/sounds/';
	    	$value['pessek_chat']['notification_icon'] = elgg_get_site_url() . 'mod/pessek_chat/images/';
	    	$value['pessek_chat']['site_url'] = elgg_get_site_url();
	    	$value['pessek_chat']['user_jid_pass'] = base64_decode ($user->secretkey);
	    	$value['pessek_chat']['view_mode'] = $user->chatViewMode; //$_SESSION['view_mode'];
	    
	    	return $value;
	}

	public static function handle_after_login(Event $event) {

	    $password = get_input('password', null, false);
	    $user_guid = elgg_get_logged_in_user_entity()->guid;
	    $user = get_user($user_guid);
	    $elgg_username = $user->username;
	    $usergroup = elgg_echo('pessek_chat:settings:usergroup');

	    if(isset($password) && $password!=''){
		    if(isset($user->secretkey) && $user->secretkey!=''){
	    
			$oldpassword = base64_decode ($user->secretkey);
			$newpassword = base64_encode ($password);

			if(strcmp($oldpassword, $newpassword) !=0){

				$chat_user = new \Pessek\PessekChat\PessekPrcConnector($elgg_username, $usergroup, $user->secretkey, $password);
				if($chat_user->check_account() === true ){
					$chat_user->changePassword(); 
					$user->secretkey = base64_encode ($password);	
				}
			}
	    
	    	    }
		$user->secretkey = base64_encode ($password);
	    }
//trigger when password forgotten
	   $password2 = get_input('password2', null, false);
	   $password1 = get_input('password1', null, false);
           if(isset($password2) && $password2!='' && isset($password1) && $password1!=''){
		$chatUser = new \Pessek\PessekChat\PessekPrcConnector($elgg_username, $usergroup, $user->secretkey, $password1);
		if($chatUser->check_account() === true ){
			$chatUser->changePassword(); 
			$user->secretkey = base64_encode ($password2);
		}
	   }
//
	    
	}

	public static function handle_before_login(Event $event) {
	    
             elgg_require_js('pessek_chat/converse.logout');

	}

	public static function xmpp_user_when_elgg_user_create_by_admin(Event $event) {
	    
		$user = $event->getObject();

		if ($user instanceof ElggUser) {
		 	return;
		}

		$guid = (string)$user->guid ;
		$chat_username = $user->username;
		$chat_password = get_input('password', null, false);
		$usergroup = elgg_echo('pessek_chat:settings:usergroup');
		    
		$user->secretkey = base64_encode ($chat_password);
		
		$pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();   
		$pessek_prc->checkAccountCreated($chat_username, $usergroup, $chat_password, $guid);

	}

	public static function xmpp_user_delete_by_admin(Event $event) {
	    
		$user = $event->getObject();

		if ($user instanceof ElggUser) {
			return;
		}
		  
		$guid = (string)$user->guid ;
		$chat_username = $user->username;
		$chat_password = get_input('password', null, false);
		$usergroup = elgg_echo('pessek_chat:settings:usergroup');
		    
		$user->secretkey = base64_encode ($chat_password);
		
		$pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();
  
		$pessek_prc->deleteXMPPUser($chat_username, $usergroup, $chat_password, $guid);

	}

	public static function friendship_del(Event $event) {

		$test = 0;

		$relationship = $event->getObject();

		$sender = get_entity($relationship->guid_one);
		$receiver = get_entity($relationship->guid_two);
		
		if (!$relationship instanceof \ElggRelationship) {
			return;
		}

		$sender_username = $sender->username;
		$receiver_username = $receiver->username;

		$sender_displayname = $sender->name;
		$receiver_displayname = $receiver->name;

		$eventval = "delete";
		
		$usergroup = elgg_echo('pessek_chat:settings:usergroup');

		if(strcmp($event, $eventval)==0){

			if (check_entity_relationship($sender->getGUID(), 'friend', $receiver->getGUID())==true && check_entity_relationship($receiver->getGUID(), 'friend', $sender->getGUID())==true){
				//register_error(elgg_echo('friend_request:approve:fail', [$event]));
				$test++;
			}
		
			if($test==0){
				
				$UserSender = new \Pessek\PessekChat\PessekPrcConnector($sender_username, $usergroup);

				$UserReceiver = new \Pessek\PessekChat\PessekPrcConnector($receiver_username, $usergroup);
				
				if($UserSender->check_account() === true && $UserReceiver->check_account() === true){
					$pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();
					$pessek_prc->removeFriendship($UserSender, $UserReceiver);
					$pessek_prc->removeFriendship($UserReceiver, $UserSender);
				}
			}
		}
	}

	public static function friendship_add(Event $event) {
	    
		$relationship = $event->getObject();

		if (!$relationship instanceof \ElggRelationship) {
			return;
		}
		
		if ($relationship->relationship !== 'friendrequest' && $relationship->relationship !== 'friend') {
			return;
		}

		$sender = get_entity($relationship->guid_one);
		$receiver = get_entity($relationship->guid_two);
		
		$requester = get_user($relationship->guid_one);
		$new_friend = get_user($relationship->guid_two);
		
		if (empty($requester) || empty($new_friend)) {
			return;
		}

		$chat_password = base64_decode ($sender->secretkey);

		$sender_username = $sender->username;
		$receiver_username = $receiver->username;

		$sender_displayname = ucwords(strtolower($sender->getDisplayName()));
		//$sender_displayname =  ucwords($sender_displayname);
		
		$receiver_displayname = ucwords(strtolower($receiver->getDisplayName()));
		//$receiver_displayname = ucwords($receiver_displayname);

		$eventval = "create";
		
		$usergroup = elgg_echo('pessek_chat:settings:usergroup');       

		if(strcmp($event, $eventval)==0){
		    
		    if($relationship->relationship === 'friendrequest'){
	    
		        $UserSender = new \Pessek\PessekChat\PessekPrcConnector($sender_username, $usergroup, $chat_password);
		        $UserReceiver = new \Pessek\PessekChat\PessekPrcConnector($receiver_username, $usergroup,  $chat_password);
		        $pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();
		        $pessek_prc->send_accept_invitation($UserSender, $UserReceiver, $receiver_displayname, "both");//from
		        
		        //$pessek_prc->send_accept_invitation($UserReceiver, $UserSender, $sender_displayname);
		        $pessek_prc->invitation_v($UserSender, $UserReceiver, $receiver_displayname);
		        //register_error('friendrequest');
		        
		    }
		    
		    if($relationship->relationship === 'friend'){
		        
		        $UserSender = new \Pessek\PessekChat\PessekPrcConnector($sender_username, $usergroup, $chat_password);
		        $UserReceiver = new \Pessek\PessekChat\PessekPrcConnector($receiver_username, $usergroup,  $chat_password);
		        $pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();
		        $pessek_prc->send_accept_invitation($UserSender, $UserReceiver, $receiver_displayname, "both");
		        $pessek_prc->send_accept_invitation($UserReceiver, $UserSender, $sender_displayname, "both");
		        //register_error('friend');
		    }
		}
	}

	public static function avatar_update(Event $event) {
	    
	    $user = $event->getObject();

	    if ($user instanceof ElggUser) {
		    return;
	    }
	   
	    $icon = $user->getIcon('large');
	    $contents = $icon->grabFile();
	    $photo_binval = base64_encode($contents);

	    $photo_type = "image/jpeg";
	    
	    $elgg_username = $user->username;
	    
	    $chat_user = new \Pessek\PessekChat\PessekPrcConnector($elgg_username);
	    
	    if($chat_user->check_account() === true ){
		    $pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();
		    $pessek_prc->chat_user_vcard_avatar($chat_user, $chat_user, "PHOTO", "TYPE", $photo_type);
		    $pessek_prc->chat_user_vcard_avatar($chat_user, $chat_user, "PHOTO", "BINVAL", $photo_binval);
	    }
	}

	public static function handle_user_update(Event $event) {
	    
	    $user = $event->getObject();

	    $DisplayName = $user->getDisplayName();
	    $password = get_input('password', null, false);
	    
	    $guid = elgg_get_logged_in_user_entity()->guid;
		
	    if ($user instanceof ElggUser) {
		    return;
	    }

	    $usergroup = elgg_echo('pessek_chat:settings:usergroup');
	    $elgg_username = $user->username;

	    $chat_user = new \Pessek\PessekChat\PessekPrcConnector($elgg_username);
	    
	    if($chat_user->check_account() === true ){
	    	$pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();
		$pessek_prc->chat_user_vcard_public($chat_user, $chat_user, "FN", $DisplayName);

		if(str_word_count($DisplayName)>3){
		        $Nick = array();
		        $Nick = str_word_count($DisplayName, 1);
		        $DisplayName = $Nick[0]." ".$Nick[1]." ".$Nick[2];
		        $pessek_prc->chat_user_vcard_public($chat_user, $chat_user, "NICKNAME", $DisplayName);
		}else{
			$pessek_prc->chat_user_vcard_public($chat_user, $chat_user, "NICKNAME", $DisplayName);
		}
	    
	    }

	}

	public static function handle_user_settings(Hook $hook) {

		$value = $hook->getValue();
		$request = $hook->getParam('request');

	    	$guid = elgg_get_logged_in_user_entity()->guid;
	    	$user = get_user($guid);
		$actor = $hook->getUserParam();
	    	$elgg_username = $actor->username;
	   	$current_lang = get_current_language();

	    	if ($user instanceof ElggUser) {
			return;
	    	}

		$usergroup = elgg_echo('pessek_chat:settings:usergroup');
	    	$DisplayName = $actor->getDisplayName();
	    	//$password = get_input('password', null, false);
		$password2 = $request->getParam('password2', null, false);
		$password = $request->getParam('password', null, false);
		$old_password = base64_decode ($actor->secretkey);

	    	$chat_user = new \Pessek\PessekChat\PessekPrcConnector($elgg_username);

	    	if($chat_user->check_account() === true ){
		    	$pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();
			$pessek_prc->chat_user_vcard_public($chat_user, $chat_user, "FN", $DisplayName);

			if(str_word_count($DisplayName)>3){
				$Nick = array();
				$Nick = str_word_count($DisplayName, 1);
				$DisplayName = $Nick[0]." ".$Nick[1]." ".$Nick[2];
				$pessek_prc->chat_user_vcard_public($chat_user, $chat_user, "NICKNAME", $DisplayName);
			}else{
				$pessek_prc->chat_user_vcard_public($chat_user, $chat_user, "NICKNAME", $DisplayName);
			}
		    	
	    	}
//
		if (!$user->isAdmin() && $actor->guid === $user->guid) {
			$currentPassword = get_input('current_password', null, false);
				if(isset($password) && $password!='' && isset($currentPassword) && $currentPassword!=''){

					if(strcmp($old_password, $currentPassword)==0){

						$chat_user = new \Pessek\PessekChat\PessekPrcConnector($elgg_username, $usergroup, $old_password, $password);

						if($chat_user->check_account() === true ){
					    		$chat_user->changePassword(); 
					    		$actor->secretkey = base64_encode ($password);
						}
					}
			       
			    	 }
		}

		if ($user->isAdmin() && $actor->guid === $user->guid) {
			$currentPassword = get_input('current_password', null, false);
				if(isset($password) && $password!=''){

					if(strcmp($old_password, $currentPassword)==0){

						$chat_user = new \Pessek\PessekChat\PessekPrcConnector($elgg_username, $usergroup, $old_password, $password);

						if($chat_user->check_account() === true ){
					    		$chat_user->changePassword(); 
					    		$actor->secretkey = base64_encode ($password);
						}
					}
			       
			    	 }
		}

		if ($user->isAdmin() && $actor->guid != $user->guid) { //register_error($DisplayName);register_error($elgg_username);register_error($old_password);
				if(isset($password) && $password!=''){

						$chat_user = new \Pessek\PessekChat\PessekPrcConnector($elgg_username, $usergroup, $old_password, $password);

						if($chat_user->changePassword() === true ){
					    		$chat_user->change_password(); 
					    		$actor->secretkey = base64_encode ($password);
						}
			       
			    	 }
		}
//
	    	

	}

	public static function xmpp_user_when_elgg_user_update_by_admin(Event $event) {
	    
	    $user = $event->getObject();

	    if ($user instanceof ElggUser) {
		    return;
	    }
	    
	    $guid = (string)$user->guid ;
	    $elgg_username = $user->username;
	    $usergroup = elgg_echo('pessek_chat:settings:usergroup'); 

	    
	    $password = get_input('password', null, false);
	    $DisplayName = get_input('name');
	    
	    if(isset($password)){
		$user->secretkey = base64_encode ($password);
	    }
	    
	    if(isset($DisplayName)){
		$user->setDisplayName($DisplayName);
	    }
	   
	    
	    $DisplayName = $user->getDisplayName();
	    
	    $chat_user = new \Pessek\PessekChat\PessekPrcConnector($elgg_username);
	    
	    if($chat_user->check_account() === true ){
	    
		    $pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();
                    $pessek_prc->chat_user_vcard_public($chat_user, $chat_user, "FN", $DisplayName);
		    if(str_word_count($DisplayName)>3){
		        
		        $Nick = array();
		        $Nick = str_word_count($DisplayName, 1);
		        $DisplayName = $Nick[0]." ".$Nick[1]." ".$Nick[2];
		        $pessek_prc->chat_user_vcard_public($chat_user, $chat_user, "NICKNAME", $DisplayName);
		            
		    }else{
			$pessek_prc->chat_user_vcard_public($chat_user, $chat_user, "NICKNAME", $DisplayName);
		    }

	    	}
	       
		$old_password = base64_decode ($user->secretkey);
		$password = base64_decode ($user->secretkey);
		$chat_user = new \Pessek\PessekChat\PessekPrcConnector($elgg_username, $usergroup, $old_password, $password);
		
		if($chat_user->check_account() === true ){
		
		    $chat_user->change_password(); 
		}

	}

}






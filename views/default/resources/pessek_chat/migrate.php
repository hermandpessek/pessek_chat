<?php

if (elgg_is_admin_logged_in()){

	$all_users = elgg_get_entities([
		'types' => 'user',
		'limit' => "0",
		'offset' => "0",
		/*'relationship_guid' => $user_guid,
		'relationship' => 'friend'*/
	]);

	$userGroup = elgg_echo('pessek_chat:settings:usergroup');
	$fullMessage = elgg_echo('pessek_chat:xmpp:migration'); 
	$errorMessage = "";
	$i = 0;	

	foreach ($all_users as $users) {

		// --- get current user settings
		$elggUsername = $users->username;
		$displayName = $users->getDisplayName();
		$guid = $users->guid;

		// --- password generation
		$password = generate_random_cleartext_password();

		// --- set user new password
		if (force_user_password_reset($guid, $password)) {


			// --- xmpp account creation
			$pessek_prc = new \Pessek\PessekChat\PessekPrcXmlrpcElgg();   
			$pessek_prc->checkAccountCreated($elggUsername, $userGroup, $password, $guid);

			// --- store current operation
			if($i==0){
				$fullMessage = $fullMessage ."<h5>". $users->getDisplayName() ." (". $users->username . " -- " . $users->guid .")</h5><br>";
			}else{
				$fullMessage = $fullMessage . "<h5>". $users->getDisplayName() ." (". $users->username . " -- " . $users->guid .")</h5><br>";
			}
			
			//--- set encrypted password
			$users->secretkey = base64_encode ($password);	

			// --- add friendship relation
			$all_user_friend = elgg_get_entities([
				'types' => 'user',
				'limit' => "0",
				'offset' => "0",
				'relationship_guid' => $guid,
				'relationship' => 'friend'
			]);
			foreach ($all_user_friend as $userFriend) {

				$NickName = $userFriend->getDisplayName();
		
				if(str_word_count($fullname)>3){
	    
		        		$Nick = array();
		        		$Nick = str_word_count($fullname, 1);
		        		$NickName = $Nick[0]." ".$Nick[1]." ".$Nick[2];
		            
				}

				$pessekRPC = new \Pessek\PessekChat\PessekPrcXmlrpcElgg(); 
				$UserSender = new \Pessek\PessekChat\PessekPrcConnector($elggUsername, $userGroup, $password);
				$UserReceiver = new \Pessek\PessekChat\PessekPrcConnector($userFriend->username, $userGroup,  $password);
				$pessekRPC->migrateInvitation($UserSender, $UserReceiver, "", "both");
				$pessekRPC->migrateInvitation($UserReceiver, $UserSender, "", "both");
			}

			// --- send notification to user
			notify_user($users->guid,
				elgg_get_site_entity()->guid,
				elgg_echo('pessek_chat:xmpp:email:resetpassword:subject', [], $users->language),
				elgg_echo('pessek_chat:xmpp:email:resetpassword:body', [$users->getDisplayName(), $password], $users->language),
				[
					'object' => $users,
					'action' => 'resetpassword',
					'password' => $password,
				],
				'email');

		}else{
			// --- error on force_user_password_reset
			$errorMessage = $errorMessage . "<br>" . elgg_echo('pessek_chat:xmpp:admin:user:resetpassword:no') . " ". $users->getDisplayName() ." (". $users->username . " -- " . $users->guid .")</h5><br>";

		}

		$i++;
	}

}else{
	//--- error you must be admin to perform this action
	$errorMessage = $errorMessage . "<br>" . elgg_echo('admin:user:resetpassword:no'). "<br>";
}

$fullMessage = $fullMessage ." <h4 style='color: red;'>". $errorMessage ."</h4>"; 

//--- notify admin about every accounts created and all erros generated

$admin_guid = elgg_get_logged_in_user_entity()->guid;
$adminUser = get_user($admin_guid);
notify_user($admin_guid,
	elgg_get_site_entity()->guid,
	elgg_echo('pessek_chat:xmpp:email:admin:subject', [], $adminUser->language),
	$fullMessage);

$body = elgg_view_layout('content', [
    'title' => ' ',
    'class' => 'converse-fullscreen',
    'content' => $fullMessage,
    'filter' => '',
]);

echo elgg_view_page('Hello', $body);

//-- Log out current admin user
forward(elgg_add_action_tokens_to_url("action/logout"));




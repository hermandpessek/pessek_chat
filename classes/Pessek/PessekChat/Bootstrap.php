<?php
namespace Pessek\PessekChat;
use Elgg\Includer;
use Elgg\PluginBootstrap;
use Elgg\Event;
use Elgg\Hook;

class Bootstrap extends PluginBootstrap {
	
	/**
	 * Get plugin root
	 * @return string
	 */
	protected function getRoot() {
		return $this->plugin->getPath();
	}
	
	public function load() {
		Includer::requireFileOnce($this->getRoot() . '/lib/Mobile_Detect.php');
		Includer::requireFileOnce($this->getRoot() . '/lib/XmppPrebind2.php');
	}
	/**
	 * {@inheritdoc}
	 */
	public function boot() {

	}
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		//Menus
		$hooks = $this->elgg()->hooks;	
		$this->elgg()->events->registerHandler('login:after', 'user', '\Pessek\PessekChat\PessekChatConfig::handle_after_login');
//$this->elgg()->events->registerHandler('login:before', 'user', '\Pessek\PessekChat\PessekChatConfig::handle_before_login');
		$this->elgg()->events->registerHandler('create', 'user', '\Pessek\PessekChat\PessekChatConfig::xmpp_user_when_elgg_user_create_by_admin');
$this->elgg()->events->registerHandler('delete', 'user', '\Pessek\PessekChat\PessekChatConfig::xmpp_user_delete_by_admin');

		$this->elgg()->events->registerHandler('create', 'relationship', '\Pessek\PessekChat\PessekChatConfig::friendship_add');
		$this->elgg()->events->registerHandler('delete', 'relationship', '\Pessek\PessekChat\PessekChatConfig::friendship_del');
		$this->elgg()->events->registerHandler('profileiconupdate', 'user', '\Pessek\PessekChat\PessekChatConfig::avatar_update');
		$this->elgg()->events->registerHandler('profileupdate', 'user', '\Pessek\PessekChat\PessekChatConfig::handle_user_update');
		$this->elgg()->events->registerHandler('profileupdate', 'user', '\Pessek\PessekChat\PessekChatConfig::xmpp_user_when_elgg_user_update_by_admin');
		$hooks->registerHandler('register', 'user', '\Pessek\PessekChat\PessekChatConfig::xmpp_user_when_elgg_admin_user_import_through_upload_users');

		$hooks->registerHandler('register', 'menu:site', ['\Pessek\PessekChat\ChatMenuHandler', 'siteMenu']);

		elgg_register_route('pessek_chat:chatusersettings', [
			'path' => 'pessek_chat/chatusersettings',
			'resource' => 'pessek_chat/chatusersettings',
		]); //elgg_register_page_handler('chatusersettings', 'chatusersettings_page_handler');

		elgg_register_route('pessek_chat:chatusersettingsprebind', [
			'path' => 'pessek_chat/chatusersettingsprebind',
			'resource' => 'pessek_chat/chatusersettingsprebind',
		]); //elgg_register_page_handler('chatusersettingsprebind', 'chatusersettingsprebinds_page_handler');

		elgg_register_route('pessek_chat:chat_user_search', [
			'path' => 'pessek_chat/chat_user_search',
			'resource' => 'pessek_chat/chat_user_search',
		]); //elgg_register_page_handler('chat_user_search', 'chat_user_search_page_handler');

	       elgg_register_route('pessek_chat:fullscreen', [
			'path' => 'pessek_chat/fullscreen.html',
			'resource' => 'pessek_chat/fullscreen',
		]); //elgg_register_page_handler('chat_user_search', 'chat_user_search_page_handler');

		elgg_register_route('pessek_chat:migrate', [
			'path' => 'pessek_chat/migrate.php',
			'resource' => 'pessek_chat/migrate',
		]); 

		if (elgg_is_logged_in()) {

	    		$guid = elgg_get_logged_in_user_entity()->guid;
    			$user = get_user($guid);

			$user->chatViewMode = "overlayed";
			$detect = new \Pessek\PessekChat\Mobile_Detect();
			if ( $detect->isMobile() ) {
				$user->chatViewMode = "mobile";
			}

		}

		$hooks->registerHandler('usersettings:save', 'user', '\Pessek\PessekChat\PessekChatConfig::handle_user_settings');
		$hooks->registerHandler('elgg.data', 'page', '\Pessek\PessekChat\PessekChatConfig::pessek_chat_config_user_page');
		$hooks->registerHandler('elgg.data', 'site', '\Pessek\PessekChat\PessekChatConfig::pessek_chat_config_user_site');

	    	if (elgg_is_logged_in()) {

			$css_path = elgg_get_site_url() . "mod/pessek_chat/dist/";
		
			elgg_register_css("converse-min-css", $css_path . "converse.min.css");
			elgg_load_css('converse-min-css');

			elgg_define_js('converse-min', [
				            'src' => 'mod/pessek_chat/dist/converse.min.js',
				            'exports' => 'converse-min',
				    ]);
			elgg_define_js('emojis-js', [
				            'src' => 'mod/pessek_chat/dist/emojis.js',
				            'exports' => 'emojis-js',
				    ]);
		        elgg_require_js('pessek_chat/converse.init.chat');
            

    		}

	}
	/**
	 * {@inheritdoc}
	 */
	public function ready() {
	/**
	 * {@inheritdoc}
	 */
	}
	/**
	 * {@inheritdoc}
	 */
	public function shutdown() {
	}
	/**
	 * {@inheritdoc}
	 */
	public function activate() {
	}
	/**
	 * {@inheritdoc}
	 */
	public function deactivate() {
	}
	/**
	 * {@inheritdoc}
	 */
	public function upgrade() {
	}
}

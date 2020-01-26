<?php

namespace Pessek\PessekChat;

class ChatMenuHandler {
	
	/**
	 * Add a menu item to the site menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:site'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function siteMenu(\Elgg\Hook $hook) {
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'chatfullsreen',
			'text' => elgg_echo('pessek_chat:fullscreen'),
			'href' => 'pessek_chat/fullscreen.html',
			'target' => '_blank',
			'icon' => 'chart-pie',
		]);
		
		return $return_value;
	}

}

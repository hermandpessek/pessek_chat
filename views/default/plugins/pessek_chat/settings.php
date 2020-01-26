<?php

$plugin = elgg_extract('entity', $vars);

$enable_pessek_chat = elgg_echo('pessek_chat:settings:lib');

$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'text',
		   '#label' => elgg_echo('pessek_chat:settings:ejabberdip'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:ejabberdip'),
		   'required' => true,
		   'name' => 'params[ejabberdip]',
		   'value' => $plugin->ejabberdip,
		   'class' => 'mls',
	));

$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'text',
		   '#label' => elgg_echo('pessek_chat:settings:xmlrpcport'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:xmlrpcport'),
		   'required' => true,
		   'name' => 'params[xmlrpcport]',
		   'value' => $plugin->xmlrpcport,
		   'class' => 'mls',
	));

$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'text',
		   '#label' => elgg_echo('pessek_chat:settings:adminxmppdomain'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:adminxmppdomain'),
		   'required' => true,
		   'name' => 'params[adminxmppdomain]',
		   'value' => $plugin->adminxmppdomain,
		   'class' => 'mls',
	));

$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'text',
		   '#label' => elgg_echo('pessek_chat:settings:adminxmppusername'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:adminxmppusername'),
		   'required' => true,
		   'name' => 'params[adminxmppusername]',
		   'value' => $plugin->adminxmppusername,
		   'class' => 'mls',
	));

$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'password',
		   '#label' => elgg_echo('pessek_chat:settings:adminxmpppassword'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:adminxmpppassword'),
		   'required' => true,
		   'name' => 'params[adminxmpppassword]',
		   'value' => $plugin->adminxmpppassword,
		   'class' => 'mls',
	));

$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'text',
		   '#label' => elgg_echo('pessek_chat:settings:userxmppdomain'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:userxmppdomain'),
		   'required' => true,
		   'name' => 'params[userxmppdomain]',
		   'value' => $plugin->userxmppdomain,
		   'class' => 'mls',
	));
	
// Bosh URL
	
$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'url',
		   '#label' => elgg_echo('pessek_chat:settings:boshurl:https'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:boshurl:https'),
		   'required' => true,
		   'name' => 'params[boshurl]',
		   'value' => $plugin->boshurl,
		   'class' => 'mls',
	));

$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'url',
		   '#label' => elgg_echo('pessek_chat:settings:boshurl:http'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:boshurl:http'),
		   'required' => true,
		   'name' => 'params[boshurlhttp]',
		   'value' => $plugin->boshurlhttp,
		   'class' => 'mls',
	));
    
// websocket URL

$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'url',
		   '#label' => elgg_echo('pessek_chat:settings:websocketurl:https'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:websocketurl:https'),
		   'required' => true,
		   'name' => 'params[websocketurl_secure]',
		   'value' => $plugin->websocketurl_secure,
		   'class' => 'mls',
	));

$enable_pessek_chat .= elgg_view_field(array(
		   '#type' => 'url',
		   '#label' => elgg_echo('pessek_chat:settings:websocketurl:http'),
		   '#help' => elgg_view_icon('help') . elgg_echo('pessek_chat:help:websocketurl:http'),
		   'required' => true,
		   'name' => 'params[websocketurl]',
		   'value' => $plugin->websocketurl,
		   'class' => 'mls',
	));

$enable_pessek_chat .= elgg_view_field([
        '#type' => 'hidden',
        'name' => 'flush_cache',
        'value' => 1,
]);

echo elgg_format_element('div', [], $enable_pessek_chat);


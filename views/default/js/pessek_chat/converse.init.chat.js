define(function (require) {

    var currentLocation = window.location.pathname;
    var locationPath = currentLocation.split("/");

    var converse = require('converse-min');
    var emojisjs = require('emojis-js');
    
    var view_mode = elgg.data.pessek_chat.view_mode;
    var user_jid = elgg.data.pessek_chat.user_jid;    
    var bosh_service_url = elgg.data.pessek_chat.bosh_service_url; 
    var websocket_url_non_secure = elgg.data.pessek_chat.websocket_url_non_secure;
    var websocket_url_secure = elgg.data.pessek_chat.websocket_url_secure;
    var credentials_url = elgg.data.pessek_chat.credentials_url;     
    var prebind_url = elgg.data.pessek_chat.prebind_url;   
    var userxmppdomain = elgg.data.pessek_chat.userxmppdomain;
    var sounds_path = elgg.data.pessek_chat.sounds_path;
    var notification_icon = elgg.data.pessek_chat.notification_icon;
    var site_url = elgg.data.pessek_chat.site_url;
    var user_jid_pass = elgg.data.pessek_chat.user_jid_pass; 
    var language_code = elgg.get_language(); 
 
    if(locationPath.length==3){
	var fullScreen = locationPath[2];
	var fullScreen = fullScreen.split(".");
	if(fullScreen[0].localeCompare("fullscreen")==0 && locationPath[1].localeCompare("pessek_chat")==0){
		view_mode = 'fullscreen';
	}
     }

     converse.default.initialize({
	authentication: 'login',
	jid: user_jid,
	password: user_jid_pass,
	credentials_url: credentials_url,
   	auto_login: true,
	auto_reconnect: true,
      	keepalive: true,
	websocket_url: websocket_url_secure,
       	message_carbons: true,
       	play_sounds: true,
	sounds_path: sounds_path,
       	roster_groups: true,
       	show_controlbox_by_default: false,
	allow_logout: false,
	use_vcards: true,
	view_mode: view_mode,
	allow_message_corrections: "all",
	omemo_default: true,
        allow_muc: true,
        notification_icon: notification_icon + 'logo.png',
        muc_instant_rooms: true,
        allow_muc_invitations: true,
        allow_non_roster_messaging: true,
        allow_chat_pending_contacts: true,
        allow_contact_requests: false,
	show_chat_state_notifications: true,
        message_archiving: 'always',
        i18n: language_code,
        csi_waiting_time: 60,
        auto_away: 500,
	auto_xa: 600,
	idle_presence_timeout: 300,
        ping_interval: 180,
        archived_messages_page_size: 70,
	show_desktop_notifications: true,
	send_chat_state_notifications: true,
	show_images_inline: true,
	allow_dragresize: true,
	auto_focus: true,
	autocomplete_add_contact: false,
	hide_offline_users: false,
        default_domain : userxmppdomain,
        allow_contact_removal: false,
        allow_registration: false,
        strict_plugin_dependencies: false,
        synchronize_availability: true,
	muc_domain: "conference."+userxmppdomain,
	locked_muc_domain: "hidden",
	muc_mention_autocomplete_min_chars: 3,
	notify_all_room_messages: true,
	muc_respect_autojoin: false,
	muc_show_logs_before_join: true,
	muc_instant_rooms: false,

        visible_toolbar_buttons: {
    		spoiler: true,
   		emoji: true,
    		toggle_occupants: true
        },

    });
});

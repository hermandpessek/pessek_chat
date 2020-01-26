define(function (require) {

   	var converse = require('converse-min');
   	var emojisjs = require('emojis-js');

    	var view_mode = elgg.data.pessek_chat.view_mode;   
    	var bosh_service_url = elgg.data.pessek_chat.bosh_service_url; 
    	var credentials_url = elgg.data.pessek_chat.credentials_url;      
   	var userxmppdomain = elgg.data.pessek_chat.userxmppdomain;
    	var language_code = elgg.get_language();

    	converse.default.plugins.add('myplugin', {
		initialize: function () {
			this._converse.api.waitUntil('statusInitialized').then(() => {
				this._converse.api.user.logout();
				this._converse.api.connection.disconnect();
			});
   		} 
   	});

    	converse.default.initialize({
    	bosh_service_url: bosh_service_url,
	authentication: 'login',
	credentials_url: credentials_url,
       	message_carbons: true,
       	roster_groups: false,
       	show_controlbox_by_default: true,
	allow_logout: false,
	use_vcards: true,
	view_mode: view_mode,
        message_archiving: 'always',
        i18n: language_code,
        default_domain : userxmppdomain,
        allow_registration: false,
        strict_plugin_dependencies: false,
	whitelisted_plugins: ['myplugin'],
    });
});

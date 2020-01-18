# pessek_chat
XMPP Client for ELGG based on Converse.js

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
  </head>
  <body>
    <h2>DESCRIPTION</h2>
    <p>This plugin is a fully featured bridge between <a href="https://elgg.org" target="_blank">elgg</a> and <a href="https://conversejs.org" target="_blank">converse.js</a> library, an advanced <a href="https://xmpp.org/" target="_blank">XMPP (Jabber)</a> chat client for your social networking engine.</p>
    <p>Converse.js is an open source webchat client, that runs in the browser and can be integrated into any website.</p>
    <p>It’s similar to Facebook chat, but also supports multi-user chatrooms.</p>
    <p>Converse.js can connect to any accessible XMPP/Jabber server, either from a public provider, or to one you have set up yourself.</p>
    <p>For more information, check out <a href="https://conversejs.org" target="_blank">conversejs</a> </p>
    <h2><a id="user-content-features" class="anchor" aria-hidden="true" href="#features"><svg class="octicon octicon-link" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9h1v1H4c-1.5 0-3-1.69-3-3.5S2.55 3 4 3h4c1.45 0 3 1.69 3 3.5 0 1.41-.91 2.72-2 3.25V8.59c.58-.45 1-1.27 1-2.09C10 5.22 8.98 4 8 4H4c-.98 0-2 1.22-2 2.5S3 9 4 9zm9-3h-1v1h1c1 0 2 1.22 2 2.5S13.98 12 13 12H9c-.98 0-2-1.22-2-2.5 0-.83.42-1.64 1-2.09V6.25c-1.09.53-2 1.84-2 3.25C6 11.31 7.55 13 9 13h4c1.45 0 3-1.69 3-3.5S14.5 6 13 6z"></path></svg></a>SPECIAL THANKS</h2>
    <ul>
      <li>To my WIFE</li>
    </ul>
    <h2><a id="user-content-features" class="anchor" aria-hidden="true" href="#features"><svg class="octicon octicon-link" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9h1v1H4c-1.5 0-3-1.69-3-3.5S2.55 3 4 3h4c1.45 0 3 1.69 3 3.5 0 1.41-.91 2.72-2 3.25V8.59c.58-.45 1-1.27 1-2.09C10 5.22 8.98 4 8 4H4c-.98 0-2 1.22-2 2.5S3 9 4 9zm9-3h-1v1h1c1 0 2 1.22 2 2.5S13.98 12 13 12H9c-.98 0-2-1.22-2-2.5 0-.83.42-1.64 1-2.09V6.25c-1.09.53-2 1.84-2 3.25C6 11.31 7.55 13 9 13h4c1.45 0 3-1.69 3-3.5S14.5 6 13 6z"></path></svg></a>FEATURES</h2>
    <ul>
      <li>Available as overlayed chat boxes or as a fullscreen application. See <a href="https://inverse.chat" rel="nofollow">inverse.chat</a> for the fullscreen version.</li>
      <li>Custom status messages</li>
      <li>Desktop notifications</li>
      <li>A <a href="https://conversejs.org/docs/html/plugin_development.html" rel="nofollow">plugin architecture</a> based on <a href="https://conversejs.github.io/pluggable.js/" rel="nofollow">pluggable.js</a></li>
      <li>Multi-user chat rooms <a href="https://xmpp.org/extensions/xep-0045.html" rel="nofollow">XEP 45</a></li>
      <li>Chatroom bookmarks <a href="https://xmpp.org/extensions/xep-0048.html" rel="nofollow">XEP 48</a></li>
      <li>Direct invitations to chat rooms <a href="https://xmpp.org/extensions/xep-0249.html" rel="nofollow">XEP 249</a></li>
      <li>vCard support <a href="https://xmpp.org/extensions/xep-0054.html" rel="nofollow">XEP 54</a></li>
      <li>Service discovery <a href="https://xmpp.org/extensions/xep-0030.html" rel="nofollow">XEP 30</a></li>
      <li>In-band registration <a href="https://xmpp.org/extensions/xep-0077.html" rel="nofollow">XEP 77</a></li>
      <li>Roster item exchange <a href="https://xmpp.org/extensions/tmp/xep-0144-1.1.html" rel="nofollow">XEP 144</a></li>
      <li>Chat statuses (online, busy, away, offline)</li>
      <li>Typing and state notifications <a href="https://xmpp.org/extensions/xep-0085.html" rel="nofollow">XEP 85</a></li>
      <li>File sharing / HTTP File Upload <a href="https://xmpp.org/extensions/xep-0363.html" rel="nofollow">XEP 363</a></li>
      <li>Messages appear in all connnected chat clients / Message Carbons <a href="https://xmpp.org/extensions/xep-0280.html" rel="nofollow">XEP 280</a></li>
      <li>Third person "/me" messages <a href="https://xmpp.org/extensions/xep-0245.html" rel="nofollow">XEP 245</a></li>
      <li>XMPP Ping <a href="https://xmpp.org/extensions/xep-0199.html" rel="nofollow">XEP 199</a></li>
      <li>Server-side archiving of messages <a href="https://xmpp.org/extensions/xep-0313.html" rel="nofollow">XEP 313</a></li>
      <li>Hidden Messages (aka Spoilers) <a href="https://xmpp.org/extensions/xep-0382.html" rel="nofollow">XEP 382</a></li>
      <li>Client state indication <a href="https://xmpp.org/extensions/xep-0352.html" rel="nofollow">XEP 352</a></li>
      <li>Last Message Correction <a href="https://xmpp.org/extensions/xep-0308.html" rel="nofollow">XEP 308</a></li>
      <li>OMEMO encrypted messaging <a href="https://xmpp.org/extensions/xep-0384.html%22" rel="nofollow">XEP 384</a></li>
      <li>Anonymous logins, see the <a href="https://conversejs.org/demo/anonymous.html" rel="nofollow">anonymous login demo</a></li>
      <li>Message Retractions <a href="https://xmpp.org/extensions/xep-0424.html" rel="nofollow">XEP-424</a></li>
      <li>Message Moderation <a href="https://xmpp.org/extensions/xep-0425.html" rel="nofollow">XEP-425</a></li>
      <li>Translated into over 30 languages</li>
    </ul>

  </body>
</html>

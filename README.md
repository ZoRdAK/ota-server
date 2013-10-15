ota-server
==========

Deploy and install over the air your iOS &amp; Android apps like a breeze. Works everywhere on PHP server.


upload from curl
================

[OS] : ios or android

[PATH] : Path where you want to put your ipa (if path didn't exist, the server will create it for you)

curl -i -F name=upload -F filedata=@app.ipa http://[your-ota-server]/apps/[OS]/[PATH]


upload with UI
==============

http://[your-ota-server]/upload

delete with UI
==============

http://[your-ota-server]/delete

© 2013

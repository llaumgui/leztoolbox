<?php /* #?ini charset="utf-8"?

[eZJSCore]

# List of external JavaScript YUI / jQuery libraries with their CDN URL
ExternalScripts[jqueryui]=http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js

# List of local JavaScript YUI / jQuery libraries, optionally start with "/" to signal that its in
# root of design folder and not in /javascript sub folder
LocalScripts[jqueryui]=jquery-ui-1.8.11.min.js

[Packer]
# Appends the last modified time to the cached file name so Proxy/Browser cache
# is forced to re fetch file on change. Note: cronjob to cleanup expired
# files does not exist, but should be fairly trivial to create.
AppendLastModifiedTime=enabled


[ezjscServer_ezjsce]
Class=ezjscExtendedFunctions
File=extension/leztoolbox/classes/ezjscextendedfunctions.php

*/ ?>
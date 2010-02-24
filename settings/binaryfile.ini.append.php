<?php /* #?ini charset="utf-8"?

# Here you can add handlers for new datatypes.
[HandlerSettings]
MetaDataExtractor[]
MetaDataExtractor[text/plain]=ezplaintext

MetaDataExtractor[application/pdf]=ezbinaryfile
MetaDataExtractor[application/msword]=ezbinaryfile
MetaDataExtractor[application/vnd.ms-excel]=ezbinaryfile
MetaDataExtractor[application/vnd.ms-powerpoint]=ezbinaryfile


# A list of extensions which have metadata extractor handlers
# It's common to create a settings/binaryfile.ini.append.php file
# in your extension and add the extension name to automatically
# get handlers from the extension when it's turned on.
# Handlers need to be placed in the extension subdir "plugins".
ExtensionRepositories[]=leztoolbox



[BinaryFileHandlerSettings]
#LogFile=var/log/index.log

*/ ?>
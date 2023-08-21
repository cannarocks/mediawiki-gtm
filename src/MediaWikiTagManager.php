<?php
if (!defined('MEDIAWIKI')) {
    die("This is a MediaWiki extension and cannot be used standalone.\n");
}

use MediaWiki\MediaWikiServices;


$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,
    'name' => 'GoogleTagManager',
    'author' => 'Luca Cannarozzo (@cannarocks)',
    'url' => 'https://github.com/cannarocks/mediawiki-gtm',
    'descriptionmsg' => 'googletagmanager-desc',
    'version' => '1.0.0',
);

$wgHooks['BeforePageDisplay'][] = 'GoogleTagManager::onBeforePageDisplay';

class MediaWikiTagManager
{
    public static function onBeforePageDisplay(OutputPage $out, Skin $skin)
    {
        $config = MediaWikiServices::getInstance()->getConfigFactory()->makeConfig('mediawikitagmanager');
        $user = $config->get('MediaWikiTagManagerGTMCode');
        // Add script to <head>
        $out->addHeadItem('google-tag-manager-head', '<script>/* Your Google Tag Manager head script */</script>');

        // Add script to <body>
        $out->addInlineScript('google-tag-manager-body', '/* Your Google Tag Manager body script */');

        return true;
    }
}

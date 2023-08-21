<?php
if (!defined('MEDIAWIKI')) {
    die("This is a MediaWiki extension and cannot be used standalone.\n");
}

use MediaWiki\MediaWikiServices;


$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,
    'name' => 'MediaWikiTagManager',
    'author' => 'Luca Cannarozzo (@cannarocks)',
    'url' => 'https://github.com/cannarocks/mediawiki-gtm',
    'descriptionmsg' => 'googletagmanager-desc',
    'version' => '1.0.0',
);

$wgHooks['BeforePageDisplay'][] = 'MediaWikiTagManager::onBeforePageDisplay';

class MediaWikiTagManager
{
    public static function onBeforePageDisplay(OutputPage $out, Skin $skin)
    {
        $config = MediaWikiServices::getInstance()->getConfigFactory()->makeConfig('mediawikitagmanager');
        $GTMCode = $config->get('MediaWikiTagManagerGTMCode');
        $headScript = <<<MEDIAWIKITAGMANAGER
        <script>
        <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{$GTMCode}');</script>
        <!-- End Google Tag Manager -->
        </script>
        MEDIAWIKITAGMANAGER;

        $bodyScript = <<<MEDIAWIKITAGMANAGER
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$GTMCode}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        MEDIAWIKITAGMANAGER;

        // Add script to <head>
        $out->addHeadItem('google-tag-manager-head', $headScript);

        // Add script to <body>
        $out->addInlineScript('google-tag-manager-body', $bodyScript);

        return true;
    }
}

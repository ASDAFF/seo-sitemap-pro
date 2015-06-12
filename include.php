<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(
    'maximaster.seositemappro',
    array(
        'Maximaster\SeoSitemapPro\SitemapRuntimeEx' => 'lib/SitemapRuntimeEx.php',
        'Maximaster\SeoSitemapPro\SitemapIndexEx' => 'lib/SitemapIndexEx.php'
    )
);

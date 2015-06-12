<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$aMenu = array(
    array(
        'parent_menu' => 'global_menu_services',
        'sort' => 85,
        'text' => Loc::getMessage("SEO_MENU_SITEMAP"),
        'title' => Loc::getMessage("SEO_MENU_SITEMAP_ALT"),
        'url' => 'seo_sitemap_pro.php',
    ),
);

return $aMenu;
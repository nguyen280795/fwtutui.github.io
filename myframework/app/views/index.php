<?php

require_once (dirname(__DIR__).'/libs/smarty/libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->debugging = false;
//$smarty->caching= false;
//$smarty->cache_lifetime = 60;
$smarty->setCompileDir('templates_c/');
$smarty->setConfigDir('../libs/smarty/configs/');
$smarty->setCacheDir('../libs/smarty/cache/');
$smarty->setTemplateDir(dirname(__DIR__).'/views/templates');

$tieude = 'Wellcome to Smarty';
$hoten = 'Pham Hoang Nguyen';
$smarty->assign('title', $tieude);
$smarty->assign('name', $hoten);

$smarty->display('gioithieu.tpl');
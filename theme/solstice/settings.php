<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

// logo image setting
	$name = 'theme_solstice/logo';
	$title = get_string('logo','theme_solstice');
	$description = get_string('logodesc', 'theme_solstice');
	$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
	$settings->add($setting);

	// link color setting
	$name = 'theme_solstice/headercolor';
	$title = get_string('headercolor','theme_solstice');
	$description = get_string('headercolordesc', 'theme_solstice');
	$default = '#222222';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);
	
	// link color setting
	$name = 'theme_solstice/menucolor';
	$title = get_string('menucolor','theme_solstice');
	$description = get_string('menucolordesc', 'theme_solstice');
	$default = '#9f0b0b';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);
	
	// link color setting
	$name = 'theme_solstice/linkcolor';
	$title = get_string('linkcolor','theme_solstice');
	$description = get_string('linkcolordesc', 'theme_solstice');
	$default = '#990000';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);

	// link hover color setting
	$name = 'theme_solstice/linkhover';
	$title = get_string('linkhover','theme_solstice');
	$description = get_string('linkhoverdesc', 'theme_solstice');
	$default = '#333333';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);
}
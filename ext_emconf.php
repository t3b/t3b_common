<?php

########################################################################
# Extension Manager/Repository config file for ext "t3b_config".
#
# Auto generated 01-08-2012 11:11
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'T3B Viewhelpers and Utilites',
	'description' => 'Use this for your plugin and templating pleasure',
	'category' => 'misc',
	'author' => 'Anno v. Heimburg',
	'author_email' => 'anno@vonheimburg.de',
	'author_company' => '',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.0.2',
            'extbase' => '6.0.2',
            'fluid' => '6.0.2'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	)
);
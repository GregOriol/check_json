<?php

require_once(__DIR__.'/vendor/autoload.php');

require_once(__DIR__.'/inc/nagios.php');

// Command line parser
$parser = new Console_CommandLine(array(
	'description'	=> 'Check JSON',
	'version'		=> '0.0.2',
	'force_posix'	=> true
));

$parser->addOption('url', array(
	// 'short_name'	=> '-u',
	'long_name'		=> '--url',
	'description'	=> 'URL',
	'action'		=> 'StoreString'
));

try {
	$result = $parser->parse();

	$url = $result->options['url'];
	if (empty($url)) {
		echo 'No URL specified'."\n";
		exit(NAGIOS_UNKNOWN);
	}

	$data = @file_get_contents($url);
	if (!$data || empty($data)) {
		echo 'Couldn\'t retrieve data from URL'."\n";
		exit(NAGIOS_UNKNOWN);
	}

	$data = json_decode($data, true);
	if (!$data || empty($data)) {
		echo 'Couldn\'t read JSON from URL'."\n";
		exit(NAGIOS_UNKNOWN);
	}

	if (!isset($data['status']) && !isset($data['message'])) {
		echo 'Invalid response from URL'."\n";
		exit(NAGIOS_UNKNOWN);
	}

	$r = NAGIOS_UNKNOWN;
	switch ($data['status']) {
		case 'OK':
			$r = NAGIOS_OK;
			break;
		case 'WARNING':
			$r = NAGIOS_WARNING;
			break;
		case 'CRITICAL':
			$r = NAGIOS_CRITICAL;
			break;
		default:
			$r = NAGIOS_UNKNOWN;
			break;
	}

	echo $data['message']."\n";
	exit($r);

} catch (Exception $exc) {
	$parser->displayError($exc->getMessage());
	exit(NAGIOS_UNKNOWN);
}

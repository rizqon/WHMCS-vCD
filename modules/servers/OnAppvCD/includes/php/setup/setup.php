<?php

use Illuminate\Database\Capsule\Manager as Capsule;

# process SQL
logactivity( OnAppvCDModule::MODULE_NAME . ' Module: process SQL file.' );

$sql = file_get_contents( __DIR__ . '/module.sql' );
$sql = explode( PHP_EOL . PHP_EOL, $sql );

$tmpSQLConfig = $CONFIG[ 'SQLErrorReporting' ];
$CONFIG[ 'SQLErrorReporting' ] = '';
foreach( $sql as $qry ) {
	$qry = str_replace( '{moduleName}', OnAppvCDModule::MODULE_NAME, $qry );
	Capsule::connection()->statement( $qry );
}
$CONFIG[ 'SQLErrorReporting' ] = $tmpSQLConfig;
unset( $tmpSQLConfig );

# process mail templates
// todo uncomment
//require __DIR__ . '/module.mail.php';

# store module version
$whmcs->set_config( OnAppvCDModule::MODULE_NAME . 'Version', OnAppvCDModule::MODULE_VERSION );
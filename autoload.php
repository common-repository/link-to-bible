<?php

spl_autoload_register( function ( $class ) {
	if ( strpos( $class, 'LTB\\' ) === false ) {
		return;
	}

	$class = str_replace( 'LTB\\', '', $class );
	$path  = str_replace( '\\', '/', $class );

	require_once sprintf( __DIR__ . '/classes/%s.php', $path );
} );

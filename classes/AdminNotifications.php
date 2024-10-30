<?php

namespace LTB;

class AdminNotifications implements HasActionsInterface {
	public static function show() {
		if ( $message = self::getMessage() ) {
			echo sprintf( '<div id="message" class="notice notice-warning warning is-dismissible"><p>%s</p></div>', $message );
		}

		\delete_transient( self::getHash() );
	}

	private static function getMessage() {
		return \get_transient( self::getHash() );
	}

	public static function setMessage( $message, $expiration = 60 ) {
		\set_transient( self::getHash(), $message, $expiration );
	}

	private static function getHash() {
		return md5( sprintf( 'LTB_%s_%s', \get_the_ID(), \wp_get_current_user()->ID ) );
	}

	public static function getActions() {
		return [
			new Dto\Action( 'admin_notices', [AdminNotifications::class, 'show'] ),
		];
	}
}

<?php
require_once( 'constants.php' );
require_once( 'error_msg.php' );
require_once( 'logger.php' );
require_once( 'utils.php' );

class Encryption {
	public $pool;
	public $newMsg;
	public $isEncryptedMsg;

	public function __construct() {
		$this->isEncryptedMsg = false;
		$this->newMsg = "";
		$this->init();
	}

	public function init() {
		if( $_POST['responseName'] == "encryptMsg" ) {
			$this->setPool();
			$this->encryptMsg( $_POST['data'] );
		} elseif ( $_POST['responseName'] == "decryptMsg"  ) {
			$this->isEncryptedMsg = true;
			$this->setPool();
			$this->decryptMsg( $_POST['data'] );
		}
	}

	public function setPool() {
		$this->pool = array(
			':', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
			'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q',
			'R', 'S', 'T', 'U', 'V', 'W' ,'X', 'Y', 'Z'
		);
	}

	public function encryptMsg( $str ) {
		$this->getEquivalent( strtoupper($str) );
	}

	public function decryptMsg( $str ) {
		$this->getEquivalent( $str );
	}

	public function getEquivalent( $str = "" ) {
		try {
			$strlen = strlen( $str );
			for( $i = 0; $i <= $strlen; $i++ ) {
				$char = substr( $str, $i, 1 );
				if( in_array($char, $this->pool) ){
					if ( $this->isEncryptedMsg == true){
						$index = array_search($char, $this->pool) - 1;
					}else{
						$index = array_search($char, $this->pool) + 1;
					}
					$this->newMsg .=  $this->pool[$index];
				}else{
					$this->newMsg .=  $char;
				}
			}

			if( $this->isEncryptedMsg )
				$this->newMsg = ucfirst( strtolower( $this->newMsg ) );

			Utils::createMsg( '', $this->newMsg );
		} catch ( Exception $e ) {
			Utils::createMsg( 'ERROR_MSG_0001' );
		}
	}
}
if( method_exists ( 'Encryption',$_POST['responseName'] ) ) {
	$encryption = new Encryption;
}
?>
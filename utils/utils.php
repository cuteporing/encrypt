<?php
class Utils {

	/**
	 * Function for generating error code
	 *
	 * @param string $errorCode
	 * @return string $errorCode
	 */
	public static function createErrorCode( $errorCode ) {
		if( isset( $errorCode ) && !empty( $errorCode )	){
			if( !defined( $errorCode ) ){
				$errorCode = "ERROR";
			}else{
				( strpbrk($errorCode,'ERROR_MSG_') )?
					$errorCode = str_replace( 'ERROR_MSG_', '', $errorCode )
				:	$errorCode = 'ERROR_MSG_'.$errorCode;
			}

		} else {
			$errorCode = "";
		}

		return $errorCode;
	}

	/**
	 * Function for generating an error message
	 *
	 * @param string $errorCode -- constant variable
	 * @return string $errorMsg
	 */
	public static function createErrorMsg( $errorCode ) {
		if ( isset( $errorCode ) && !empty( $errorCode ) ){
			if( !defined( $errorCode ) ){
				$errorMsg = $errorCode;
			} else {
				$errorMsg = constant($errorCode);
			}

			Logger::error( $errorMsg );
		} else {
			$errorMsg = "";
		}

		return $errorMsg;
	}

	/**
	 * Function for setting a result response
	 *
	 * @param string $newResponseName
	 */
	public static function setResultMsg( $newResponseName ) {
		if ( isset( $newResponseName ) && !is_null( $newResponseName ) &&
				!empty( $newResponseName ) ) {
			$_POST['responseName'] = $newResponseName;
		} else {
			$_POST['responseName'] = 'result';
		}
	}

	/**
	 * Create response message
	 *
	 * @param string $errorCode
	 * @param array  $data
	 * @return array $msg
	 */
	public static function createMsg( $errorCode, $data ) {
		$msg['responseName'] = $_POST['responseName'];
		$msg['errorCode']    = self::createErrorCode( $errorCode );
		$msg['errorMsg']     = self::createErrorMsg( $errorCode );

		( isset( $data ) && !empty( $data ) && !is_null( $data ) )?
			$msg['data'] = $data : $msg['data'] = array();

		echo json_encode( $msg );
	}
}

?>
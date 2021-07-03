<?php
namespace App\Core;

class Session
{
    private static $_sesion;
    protected const TOKEN_KEY = 'token_key';
    protected const TOKEN_EXPIRE = 'token_expire';
    protected const CURRENT_USER = 'current_user';

    private function __construct(){}

    public static function init()
    {
        session_start();
        self::setSessionId();
    }
  
    private static function setSessionId() {
		self::$_sesion = session_id();
        // $_SESSION['flash'] = [];
        // $_SESSION['body'] = [];
	}
  
    public static function getSessionId()
    {
		return self::$_sesion;
    }
  
    public static function set( string $clave, $valor )
    {
        if ( $clave != "tiempo" && isset($_SESSION[$clave]) ) {
			return false;
		}  
		if ( is_array($valor) ) {
			$_SESSION[$clave] = $valor;
			return true;
		}
        if ( !empty(filter_var($clave, FILTER_SANITIZE_STRING)) && !empty($valor) ) {
            $_SESSION[$clave] = $valor;
			return true;
        }
    }
  
    public static function get( string $clave )
    {
        if ( isset($_SESSION[$clave]) )
            return $_SESSION[$clave];
        return false;
    }

    public static function setBody(string $key, $value)
    {
        $_SESSION['body'][$key] = $value;
    }

    public static function getBody(string $key)
    {
        if ( !isset($_SESSION['body']) ) {
            return false;
        }
        if ( !isset($_SESSION['body'][$key]) ) {
            return false;
        }
        $value = $_SESSION['body'][$key];
        unset($_SESSION['body'][$key]);
        return $value;
    }
    
    public static function setFlash(string $key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    public static function getFlash(string $key)
    {
        if ( !isset($_SESSION['flash']) ) {
            return false;
        }
        if ( !isset($_SESSION['flash'][$key]) ) {
            return false;
        }
        $flash = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $flash;
    }

    public static function setToken()
    {
        $_SESSION[self::TOKEN_KEY] = bin2hex(random_bytes(32));
        $_SESSION[self::TOKEN_EXPIRE] = time() + 600; // 1 hour = 3600 secs
        return $_SESSION[self::TOKEN_KEY];
    }

    public static function token(string $token)
    {
        if ( !isset($_SESSION[self::TOKEN_KEY]) ) {
            return false;
        }
        if ($_SESSION[self::TOKEN_KEY] == $token) {
            if (time() >= $_SESSION[self::TOKEN_EXPIRE]) {
                self::setFlash(self::TOKEN_KEY, "Token expired. Please reload form." );
            } else {
                unset($_SESSION[self::TOKEN_KEY]);
                unset($_SESSION[self::TOKEN_EXPIRE]);
                return true;
            }
        } else {
            self::setFlash(self::TOKEN_KEY, "Token invalid. Please reload form." );
        }
        return false;
    }

    public static function setUser($user)
    {
        $_SESSION[self::CURRENT_USER] = $user;
    }

    public static function getUser()
    {
        return $_SESSION[self::CURRENT_USER] ?? null;
    }

    public static function logout()
    {
        unset($_SESSION[self::CURRENT_USER]);
    }
  
    public static function iniciarSesion($user, $rememberme, $ip)
    {
		self::regenerarSesion(true, $rememberme, $ip);
        self::set('inicioSesion', time());
        self::set('tiempo', time());
        self::set('autorizado', 1);
        self::set('rememberme', $rememberme);
        self::setUser($user);
    }
	
    public static function regenerarSesion($recargar = false, $rememberme, $ip)
	{
        // This token is used by forms to prevent cross site forgery attempts
        if( !self::get('nonce') || $recargar ) {
            self::set( 'nonce', bin2hex(openssl_random_pseudo_bytes(32)) );
        }
        if( !self::get('IPaddress') || $recargar ) {
            self::set( 'IPaddress', $ip );
        }
        if( !self::get('userAgent') || $recargar ) {
            self::set( 'userAgent', $_SERVER['HTTP_USER_AGENT'] );
        }
		
        // Set current session to expire in 1 minute
        self::set('OBSOLETE', true);
        self::set('EXPIRES', time() + 60);
		
        // Create new session without destroying the old one
        session_regenerate_id(false);

        // Grab current session ID and close both sessions to allow other scripts to use them
        $newSession = session_id();
        session_write_close();

        // Set session ID to the new one, and start it back up again
        session_id($newSession);
        if ( $rememberme ) {
			self::set('rememberme', true);
            ini_set('session.cookie_lifetime', '864000');
        }
        self::init();

        // Don't want this one to expire
        self::destruir('OBSOLETE');
        self::destruir('EXPIRES');
    }
  
    public static function destruir( string $clave = null )
    {
		try {
            if ( $clave ) {
                unset($_SESSION[$clave]);
            } else {
                session_unset();
                session_destroy();
				self::init();
            }
        } catch(\Exception $e) {
            throw new \Exception($e);
            exit;
        }
	}
}
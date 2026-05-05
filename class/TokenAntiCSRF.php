<?php 
class TokenAntiCSRF {

    public static function generarToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $token = bin2hex(random_bytes(3));
        $_SESSION['tokenAntiCSRF'] = $token;
        return $token;
    }

    public static function validarToken($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['tokenAntiCSRF']) && $_SESSION['tokenAntiCSRF'] === $token) {
            return true;
        }
        return false;
    }
}
?>
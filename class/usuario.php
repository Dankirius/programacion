<?php
require_once("DB.php");

class usuarios {
    protected $id;
    protected $usuario;
    protected $contraseña;

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
    public function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getUsuario() {
        return $this->usuario;
    }
    
    public function getContraseña() {
        return $this->contraseña;
    }

    public function existeUsuario() {
        $con = DB::conectar();
        $sql = "SELECT id FROM usuarios WHERE usuario = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $this->usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $existe = $resultado->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    public function guardar() {
        if ($this->existeUsuario()) {
            return false;
        }
        
        $con = DB::conectar();
        $contraseña_hash = password_hash($this->contraseña, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios(usuario, contraseña) VALUES(?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $this->usuario, $contraseña_hash);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function login() {
        $con = DB::conectar();
        $sql = "SELECT id, usuario, contraseña FROM usuarios WHERE usuario = ? LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $this->usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $fila = $resultado->fetch_assoc();
            
            if (password_verify($this->contraseña, $fila['contraseña'])) {
                $_SESSION['usuario_id'] = $fila['id'];
                $_SESSION['usuario_nombre'] = $fila['usuario'];
                $stmt->close();
                return true;
            }
        }
        
        $stmt->close();
        return false;
    }
}
?>
<?php
require_once("DB.php");

class categoria_productos {
    protected $id;
    protected $nombre_categoria;

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setNombre_categoria($nombre_categoria) {
        $this->nombre_categoria = $nombre_categoria;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getNombre_categoria() {
        return $this->nombre_categoria;
    }

    public function guardar() {
        $con = DB::conectar();
        $sql = "INSERT INTO categorias_productos(nombre_categoria) VALUES(?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $this->nombre_categoria);
        $stmt->execute();
        $stmt->close();
    }

    public static function listar() {
        $con = DB::conectar();
        $sql = "SELECT * FROM categorias_productos";
        $resultado = $con->query($sql);
        return $resultado;
    }

    public function obtenerPorId() {
        $con = DB::conectar();
        $sql = "SELECT * FROM categorias_productos WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function actualizar() {
        $con = DB::conectar();
        $sql = "UPDATE categorias_productos SET nombre_categoria = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $this->nombre_categoria, $this->id);
        $stmt->execute();
        $stmt->close();
    }

    public function eliminar() {
        $con = DB::conectar();
        $sql = "DELETE FROM categorias_productos WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
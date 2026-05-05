<?php
require_once("DB.php");

class producto {
    protected $id;
    protected $categoria_productoid;
    protected $producto;

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setCategoria_productoid($categoria_productoid) {
        $this->categoria_productoid = $categoria_productoid;
    }
    
    public function setProducto($producto) {
        $this->producto = $producto;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getCategoria_productoid() {
        return $this->categoria_productoid;
    }
    
    public function getProducto() {
        return $this->producto;
    }

    public function guardar() {
        $con = DB::conectar();
        $sql = "INSERT INTO productos(categoria_productoid, nombre_producto) VALUES(?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("is", $this->categoria_productoid, $this->producto);
        $stmt->execute();
        $stmt->close();
    }

    public static function listar() {
        $con = DB::conectar();
        $sql = "SELECT p.id, p.nombre_producto, c.nombre_categoria 
                FROM productos p 
                JOIN categorias_productos c ON p.categoria_productoid = c.id";
        $resultado = $con->query($sql);
        return $resultado;
    }

    public function obtenerPorId() {
        $con = DB::conectar();
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function actualizar() {
        $con = DB::conectar();
        $sql = "UPDATE productos SET categoria_productoid = ?, nombre_producto = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isi", $this->categoria_productoid, $this->producto, $this->id);
        $stmt->execute();
        $stmt->close();
    }

    public function eliminar() {
        $con = DB::conectar();
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
<?php
require_once("DB.php");

class precios {
    protected $id;
    protected $productoid;
    protected $precio;
    protected $iva;

    public function setId($id) {
        $this->id = $id;
    }
    
    public function setProductoid($productoid) {
        $this->productoid = $productoid;
    }
    
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    
    public function setIva($iva) {
        $this->iva = $iva;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getProductoid() {
        return $this->productoid;
    }
    
    public function getPrecio() {
        return $this->precio;
    }
    
    public function getIva() {
        return $this->iva;
    }

    public function guardar() {
        $con = DB::conectar();
        $sql = "INSERT INTO precios(productoid, precio, iva) VALUES(?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("idd", $this->productoid, $this->precio, $this->iva);
        $stmt->execute();
        $stmt->close();
    }

    public function obtenerPorProductoId() {
        $con = DB::conectar();
        $sql = "SELECT * FROM precios WHERE productoid = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $this->productoid);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function actualizar() {
        $con = DB::conectar();
        $sql = "UPDATE precios SET precio = ?, iva = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ddi", $this->precio, $this->iva, $this->id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
<?php

class TablaDetallesModel
{

    private $db;

    function __construct()
    {
        // Abro la conexión
        $this->db = $this->getConnection();
    }

    // Hago mi función getConection private para que solo se acceda desde esta clase
    private function getConnection(){
        return new PDO('mysql:host=localhost;dbname=db_tiendaropa;charset=utf8', 'root', '');
    }

    //VER TABLA 2 
    function verTabla2()
    {

        $query = $this->db->prepare('SELECT * FROM detallesprenda');
        $query->execute();

        $tabla2 = $query->fetchAll(PDO::FETCH_OBJ);

        return $tabla2;
    }

    function verDetalles($id){
        $query = $this->db->prepare('SELECT * FROM detallesprenda WHERE id_tipoPrenda = ?');
        $query->execute([$id]);

        $detalles = $query->fetch(PDO::FETCH_OBJ);

        return $detalles;
    }

    function insertar($talle, $stock, $categoria, $id){
        // Envío la consulta y después la ejecuto
        $query = $this->db->prepare('INSERT INTO detallesprenda (talle, stock, categoria, id_prenda) VALUES(?,?,?,?)'); //bindeo injeccion sql 
        $query->execute([$talle, $stock, $categoria, $id]);

        return $this->db->lastInsertId();
    }

    function eliminar($id){
        
        $query = $this->db->prepare('DELETE FROM detallesprenda WHERE id_tipoPrenda  = ?' );
        $query->execute([$id]);
        
        // Devolver la cant de columnas afectadas, sino borro ninguna nos devuelve 0, por ende da false
        return $query->rowCount();
    }

    function actualizarEdit($id_tipoPrenda, $talleEdit, $stockEdit){

        $query = $this->db->prepare('UPDATE detallesprenda SET talle = ?, stock = ? WHERE detallesprenda.id_tipoPrenda = ?');
        $query->execute([$talleEdit, $stockEdit,$id_tipoPrenda]);
    }


    // ORDENAMIENTO ASC Y DESC TABLA DETALLES

    function sortbyorder($sortby, $order){
        $query = $this->db->prepare("SELECT * FROM detallesprenda ORDER BY $sortby $order");
        $query->execute();
        $detalles = $query->fetchAll(PDO::FETCH_OBJ);
        return $detalles;
    }

    // método filtrar por costo de la prenda

    public function filterByStock($filtro) {
        $query = $this->db->prepare("SELECT * FROM detallesprenda WHERE stock < ?");
        $query->execute([$filtro]);
        $detalles = $query->fetchAll(PDO::FETCH_OBJ);
        return $detalles;
    }
}
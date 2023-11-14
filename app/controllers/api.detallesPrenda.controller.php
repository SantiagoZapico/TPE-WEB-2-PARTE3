<?php

require_once 'app/models/tablaDetalles.model.php';
require_once 'app/views/api.view.php';

class ApiDetallesPrendaController
{

    private $model;
    private $view;
    private $data;

    function __construct()
    {
        $this->model = new TablaDetallesModel();
        $this->view = new APIview();
        $this->data = file_get_contents("php://input");
    }

    // Lee la variable asociada a la entrada y la parsea a JSON
    public function getData()
    {
        return json_decode(($this->data));
    }

    public function get($params = []){

        // ORDENAR ASC O DESC
        if (isset($_GET['sortby']) && isset($_GET['order'])) { 
            if (($_GET['sortby'] == 'id_tipoPrenda' || $_GET['sortby'] == 'stock'|| $_GET['sortby'] == 'categoria' || $_GET['sortby'] == 'id_prenda')
            &&($_GET['order']== 'ASC' || $_GET['order']== 'DESC')){
              $detalles = $this->model->sortbyorder($_GET['sortby'], $_GET['order']);
              return $this->view->response($detalles, 200);
            }else{
              return $this->view->response("Los campos son inválidos", 400);
            }
          } 

        // TRAER TODOS LOS DETALLES DE LAS PRENDAS
        if (empty($params)) {
            $detalles = $this->model->verTabla2();
            if (empty($detalles)) {
                $this->view->response($detalles, 404);
            } else {
                $this->view->response($detalles, 200);
            }
        } else { // TRAER EL DETALLE DE UNA PRENDA POR EL ID
            $detalle = $this->model->verDetalles($params[':ID']);
            if (!empty($detalle)) {
                $this->view->response($detalle, 200);
            } else {
                $this->view->response('El detalle de la prenda con el id =' . $params[':ID'] . ' no existe', 404);
            }
        }
    }

    // función que filtra por stock disponible de una prenda

    public function filter($params=[]){
        if(isset($_GET['stock'])){
            $filtro = $_GET['stock'];
            $detalles = $this->model->filterByStock($filtro);
            if(!empty($detalles)){
                $this->view->response($detalles,200);
            }else{
                $this->view->response('No se encontró ninguna cantidad de stock menor a '.$filtro, 404);
            }

        }else{
            $this->view->response('El parámetro enviado es inválido', 400);
        }
    }

    // función que elimina el detalle de una prenda dado un id
    
    public function delete($params = [])
    {
        $idDetallePrenda = $params[':ID'];
        $existe = $this->model->eliminar($idDetallePrenda);
        if ($existe)
            $this->view->response('El detalle de la prenda con el id=' . $idDetallePrenda . ' se borró exitosamente', 200);
        else
            $this->view->response('El detalle de la prenda con el id=' . $idDetallePrenda . ' no existe para eliminar', 404);
    }



    /*
    función que agrega el detalle de una prenda
    recordar que hay que hacer una función especial para leer la entrada y parsearla a json
    */ 

    public function add($params = [])
    {
        $body = $this->getData();

        $talle = $body->talle;
        $stock = $body->stock;
        $categoria = $body->categoria;
        $id_prenda = $body->id_prenda;

        if (empty($talle) || empty($stock) || empty($categoria) || empty($id_prenda)) {
            $this->view->response("Complete los datos", 400);
        } else {

            $id = $this->model->insertar($talle, $stock, $categoria, $id_prenda);

            $detalle = $this->model->verDetalles($id);
            $this->view->response($detalle, 201);
        }
    }

    
    // función que edita el detalle de una prenda dado un id 
    public function update($params = [])
    {
        $idDetallePrenda = $params[':ID'];
        $detalle = $this->model->verDetalles($idDetallePrenda);

        if ($detalle) {
            $body = $this->getData();
            $talle = $body->talle;
            $stock = $body->stock;

            $this->model->actualizarEdit($idDetallePrenda, $talle, $stock);
            $this->view->response('Se actualizó el detalle de la prenda con id=' . $idDetallePrenda . ' con éxito', 200);
        } else {
            $this->view->response('El detalle de la prenda con id= ' . $idDetallePrenda . ' no existe', 404);
        }
    }
}
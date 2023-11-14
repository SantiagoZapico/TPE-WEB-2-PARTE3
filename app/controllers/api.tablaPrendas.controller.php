<?php

require_once 'app/models/tablaPrendas.model.php';
require_once 'app/views/api.view.php';

class ApiTablaPrendasController
{

    private $model;
    private $view;
    private $data;

    function __construct()
    {
        $this->model = new TablaPrendasModel();
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
            if (($_GET['sortby'] == 'id_prenda' || $_GET['sortby'] == 'prenda'|| $_GET['sortby'] == 'tipo'|| $_GET['sortby'] == 'costo' || $_GET['sortby'] == 'rebaja')
            &&($_GET['order']== 'ASC' || $_GET['order']== 'DESC')){
              $prendas = $this->model->sortbyorder($_GET['sortby'], $_GET['order']);
              return $this->view->response($prendas, 200);
            }else{
              return $this->view->response("Los campos son inválidos", 400);
            }
          } 
          //?sortby=&order=ASC

        // TRAER TODAS LAS PRENDAS
        if (empty($params)) {
            $tabla = $this->model->ver();
            if (empty($tabla)) {
                $this->view->response($tabla, 404);
            } else {
                $this->view->response($tabla, 200);
            }
        } else { // TRAER UNA PRENDA POR ID
            $prenda = $this->model->verUno($params[':ID']);
            if (!empty($prenda)) {
                $this->view->response($prenda, 200);
            } else {
                $this->view->response('La prenda con el id=' . $params[':ID'] . ' no existe', 404);
            }
        }
    }

    public function delete($params = [])
    {
        $idPrenda = $params[':ID'];
        $existe = $this->model->eliminar($idPrenda);
        if ($existe)
            $this->view->response('La prenda con el id=' . $idPrenda . ' se borró exitosamente', 200);
        else
            $this->view->response('La prenda con el id=' . $idPrenda . ' no existe para eliminar', 404);
    }

    // Hay que hacer una función especial para leer la entrada y parsearla a json
    public function add($params = [])
    {
        $body = $this->getData();

        $prenda = $body->prenda;
        $tipo = $body->tipo;
        $costo = $body->costo;
        $rebaja = $body->rebaja;

        if (empty($prenda) || empty($tipo) || empty($costo) || empty($rebaja)) {
            $this->view->response("Complete los datos", 400);
        } else {

            $id = $this->model->insertar($prenda, $tipo, $costo, $rebaja);

            $Prenda = $this->model->verUno($id);
            $this->view->response($Prenda, 201);
        }
    }

    public function update($params = [])
    {
        $idPrenda = $params[':ID'];
        $prenda = $this->model->verUno($idPrenda);

        if ($prenda) {
            $body = $this->getData();
            $costo = $body->costo;
            $rebaja = $body->rebaja;

            $this->model->actualizar($idPrenda, $costo, $rebaja);
            $this->view->response('Se actualizó la prenda con id=' . $idPrenda . ' con éxito', 200);
        } else {
            $this->view->response('La prenda con id= ' . $idPrenda . ' no existe', 404);
        }
    }

    // función que filtra por precio de la prenda

    public function filter($params=[]){
        if(isset($_GET['costo'])){
            $filtro = $_GET['costo'];
            $prendas = $this->model->filterByCost($filtro);
            if(!empty($prendas)){
                $this->view->response($prendas,200);
            }else{
                $this->view->response('No se encontró ninguna prenda con el valor menor a '.$filtro, 404);
            }

        }else{
            $this->view->response('El parámetro enviado es inválido', 400);
        }
    }
    // endpoint: prendas/filtro/costos?costo=150000  (menor a 150000)

}

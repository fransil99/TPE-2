<?php
require_once './app/models/bikes.model.php';
require_once './app/views/api.view.php';

class BikesApiController
{
    private $model;
    private $view;

    private $data;

    public function __construct()
    {
        $this->model = new BikesModel();
        $this->view = new ApiView();

        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    public function getBikes(){
        $defaultColumn = "id";
        $defaultOrder = "ASC";
        foreach ($_GET as $i => $valor) {
            if ($i != 'sort' && $i != 'order' && $i != 'limit' && $i != 'resource' && $i != 'filter' && $i != 'filtervalue') {
                    $this->view->response('Bad Request4', 400);
                    die();
                }
        }
        //si estan ambos, columna y orden hacer esto
        if (isset($_GET['sort']) && isset($_GET['order'])) {
            $bikes = $this->model->getAll($_GET['sort'], $_GET['order']);
        }
        //si esta solo columna hacer esto
        else if (isset($_GET['sort'])) {
            $bikes = $this->model->getAll($_GET['sort'], $defaultOrder);
        }
        //si esta solo order hacer esto
        else if (isset($_GET['order'])) {
            $bikes = $this->model->getAll($defaultColumn, $_GET['order']);
        } else {
            $bikes = $this->model->getAll($defaultColumn, $defaultOrder);
        }
        //&& isset(ctype_digit($_GET['offset']))
        if ($bikes != null) {
            if (isset($_GET['filter']) && isset($_GET['filtervalue'])) {
                if (!is_string($_GET['filter'])){
                    $this->view->response('Bad request1', 400);
                    die();
                }
                $bikes = $this->filtrar($_GET['filter'], $_GET['filtervalue'], $bikes);
            }
            if (isset($_GET['limit'])) {
                if (!ctype_digit($_GET['limit'])){
                    $this->view->response('Bad request2', 400);
                    die();
                }
                $bikes = $this->paginar($bikes, $_GET['limit'],);
            }
            $this->view->response($bikes, 200);
        } else {
            $this->view->response('Bad Request3', 400);
        }
    }

    public function filtrar($filter, $value, $bikes){
        $filteredBikes = [];
        foreach ($bikes as $bike) {
            if($bike->$filter == $value){
                array_push($filteredBikes, $bike);
            }
        }            
        return $filteredBikes;
    }

    public function paginar($bikes, $limit){
        //se pasa el array primero, despues el inicio, y el fin
        return array_slice($bikes,0,$limit);
    }




    public function getBike($params = null)
    {
        // obtengo el id del arreglo de params
        $id = $params[':ID'];
        $bike = $this->model->get($id);

        // si no existe devuelvo 404
        if ($bike)
            $this->view->response($bike);
        else
            $this->view->response("La moto con el id=$id no existe", 404);
    }

    public function deleteBike($params = null)
    {
        $id = $params[':ID'];

        $bike = $this->model->get($id);
        if ($bike) {
            $this->model->delete($id);
            $this->view->response("La moto con el id=$id fue eliminada, detalles abajo.", 200);
            $this->view->response($bike);
        } else
            $this->view->response("La moto con el id=$id no existe", 404);
    }

    public function insertBike($params = null)
    {
        $bike = $this->getData();

        if (empty($bike->nombre) || empty($bike->descripcion) || empty($bike->cilindrada) || empty($bike->precio) || empty($bike->imagen) || empty($bike->id_marca_fk)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insert($bike->nombre, $bike->descripcion, $bike->cilindrada, $bike->precio, $bike->imagen, $bike->id_marca_fk);
            $bike = $this->model->get($id);
            $this->view->response("La moto con el id=$bike->id_moto, fue insertada.", 201);
            $this->view->response($bike);
        }
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MainModel;

class MainController extends ResourceController
{
    public function index()
    {
        //
    }

    public function getData()
    {
        try {
            $main = new MainModel();
            $data = $main->findAll();
            return $this->respond($data, 200);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching data: ' . $e->getMessage());
            return $this->failServerError('An error occurred while fetching data.');
        }
    }
public function save()
{
    $json = $this->request->getJSON();
    $data= [
        'name' => $json->name,
        'description' => $json->description,
        'price' => $json->price,
        'capacity' => $json->capacity,
        'num_bed' => $json->num_bed,
        'room_image' => $json->room_image,
    ];
    $main = new MainModel();
    $r = $main->save($data);
    return $this->respond($r, 200);
}
}

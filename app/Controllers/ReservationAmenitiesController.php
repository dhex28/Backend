<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ReservationAmenitiesModel;

class ReservationAmenitiesController extends ResourceController

{


    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new ReservationAmenitiesModel();
    }

    public function index()
    {
        // Retrieve and return existing reservations (if needed)
        $reservations = $this->model->findAll();
        return $this->respond($reservations);
    }

    public function create()
    {
        // Receive reservation data from the frontend
        $data = $this->request->getJSON(true);

        // Assuming the JSON data matches the expected structure
        $reservationData = [
            'name' => $data['name'], // Adjust based on your database structure
            'date' => $data['date'],
            'customer_name' => $data['customer_name'],
            'contact' => $data['contact'],
            'email' => $data['email'],
            'address' => $data['address'],
        ];

        // Insert the reservation data into the database
        $result = $this->model->insert($reservationData);



        if ($result) {
            return $this->respondCreated(['message' => 'Reservation created successfully']);
        } else {
            return $this->respond(['error' => 'Failed to create reservation'], 500);
        }
    }
}

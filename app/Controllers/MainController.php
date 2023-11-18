<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AmenitiesModel;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MainModel;
use App\Models\UserModel;

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
        $data = [
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
    

    public function amenitiesgetData()
    {
        try {
            $main = new AmenitiesModel();
            $data = $main->findAll();
            return $this->respond($data, 200);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching data: ' . $e->getMessage());
            return $this->failServerError('An error occurred while fetching data.');
        }
    }
    public function amenitiesSave()
    {
        $json = $this->request->getJSON();
        $data = [
            'name' => $json->name,
            'category' => $json->category,
            'description' => $json->description,
            'price' => $json->price,
            
        ];
        $main = new AmenitiesModel();
        $r = $main->save($data);
        return $this->respond($r, 200);
    }
    public function update($id = null)
    {
        try {
            $main = new MainModel();
    
        
            if (!$id) {
                return $this->failValidationError('Invalid ID');
            }
    
    
            $existingData = $main->find($id);
    
    
            if (!$existingData) {
                return $this->failNotFound('Record not found');
            }
    
            // Get JSON data from the request
            $json = $this->request->getJSON();
    
            // Prepare the data for update
            $data = [
                'name' => $json->name ?? $existingData['name'],
                'description' => $json->description ?? $existingData['description'],
                'price' => $json->price ?? $existingData['price'],
                'capacity' => $json->capacity ?? $existingData['capacity'],
                'num_bed' => $json->num_bed ?? $existingData['num_bed'],
                'room_image' => $json->room_image ?? $existingData['room_image'],
            ];
    
            // Update the record
            $result = $main->update($id, $data);
    
            return $this->respond(['msg' => 'Record updated successfully'], 200);
        } catch (\Exception $e) {
            log_message('error', 'Error updating data: ' . $e->getMessage());
            return $this->failServerError('An error occurred while updating data.');
        }
    }
    
    public function register()
    {
        $user = new UserModel();
        $token = $this->verification(50);
        $data = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'token' => $token,
            'status' => 'active',
            'role' => 'user',
        ];
        $u = $user->save($data);
        if ($u) {
            return $this->respond(['msg' => 'okay', 'token' => $token]);
        } else {
            return $this->respond(['msg' => 'failed']);
        }
    }
    
    public function verification($length)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length);
    }
    
    public function login()
    {
        $user = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $user->where('username', $username)->first();
        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                return $this->respond(['msg' => 'okay', 'token' => $data['token']]);
            } else {
                return $this->respond(['msg' => 'error'], 200);
            }
        }
    }

}
<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BookingRoomModel;

class BookingRoomController extends ResourceController
{
    public function index()
    {
        //
    }
    public function createBooking()
    {
        $model = new BookingRoomModel();

        // Get the JSON data sent from the client
        $json = $this->request->getJSON();

        // Assuming the JSON data matches the expected structure
        $data = [
            'room_id' => $json->room_id,
            'check_in_date' => $json->check_in_date,
            'check_out_date' => $json->check_out_date,
            'special_request' => $json->special_request,
            'name' => $json->name,
            'email' => $json->email,
            'phone_number' => $json->phone_number,
            'address' => $json->address,
            'status' => 'pending',
        ];

        // Insert the booking data into the database
        $model->insert($data);

        // You can send a response back to the client if needed
        return $this->response->setJSON(['message' => 'Booking successfully created']);
    }

    public function getBookingroom()
    {
        // Assuming you have a BookingRoomModel to interact with the database
        $model = new BookingRoomModel();

        // Fetch booking details from the database
        $bookingDetails = $model->findAll(); // You might need to adjust this based on your database schema and requirements

        // Return the booking details as JSON
        return $this->response->setJSON($bookingDetails);
    }
    public function updateBookingStatus($id)
{
    $model = new BookingRoomModel();
    $existingBooking = $model->find($id);

    if (!$existingBooking) {
        return $this->respond(['error' => 'Booking not found.'], 404);
    }

    // Get the status from the request
    $newStatus = $this->request->getJSON()->status;

    // Validate the status - You can add more validation as needed
    if (!in_array($newStatus, ['approved', 'denied'])) {
        return $this->respond(['error' => 'Invalid status.'], 400);
    }

    // Update the status of the booking
    $data = ['status' => $newStatus];
    $model->set($data)->where('id', $id)->update();

    // Fetch the updated data after the update
    $updatedBooking = $model->find($id);

    // Include the updated data in the response
    return $this->respond(['message' => 'Booking status updated successfully.', 'data' => $updatedBooking], 200);
}
}

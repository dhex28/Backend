<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductController extends ResourceController
{
    public function inventorySave()
    {
        try {
            // Use CodeIgniter's file helper to handle file uploads
            $productImage = $this->request->getFile('product_image');
    
            // Use the provided image name
            $imageName = $productImage->getName();
    
            $data = [
                'product_name' => $this->request->getPost('product_name'),
                'category_id' => $this->request->getPost('category_id'),
                'price' => $this->request->getPost('price'),
                'quantity' => $this->request->getPost('quantity'),
                'status' => $this->request->getPost('status'),
                'product_image' => base_url() . $this->producthandleImageUpload($productImage, $imageName),

            ];
    
            $productModel = new ProductModel();
            $savedData = $productModel->save($data);
    
            return $this->respond($savedData, 200);
        } catch (\Exception $e) {
            log_message('error', 'Error saving data:' . $e->getMessage());
            return $this->failServerError('An error occurred while saving the data.');
        }
    }
    private function producthandleImageUpload($productImage, $imageName)
    {
        // Move the uploaded image to the desired directory
        $productImage->move(ROOTPATH . 'public/uploads/product', $imageName);

        // Return the relative path to save in the database
        return 'uploads/product/' .$imageName;
    }

    public function getInventory()
    {
      $produ = new ProductModel();
      $datas = $produ->findAll();
      return $this->respond($datas, 200);
    }
    
    public function saveCateg()
    {
        try {
            $data = [
                'category_name' => $this->request->getPost('category_name'),
            ];
    
            $categoryModel = new CategoryModel();
            $savedData = $categoryModel->save($data);
    
            return $this->respond($savedData, 200);
        } catch (\Exception $e) {
            log_message('error', 'Error saving data:' . $e->getMessage());
            return $this->failServerError('An error occurred while saving the data.');
        }
    }
    
    
      public function getCategory()
    {
        $category = new CategoryModel();
        $data = $category->findAll();
    
        $categories = []; // Initialize an array to hold formatted categories
        foreach ($data as $category) {
            $categories[] = [
                'id' => $category['id'],
                'category_name' => $category['category_name']
            ];
        }
    
        return $this->respond($categories, 200);
      }
}

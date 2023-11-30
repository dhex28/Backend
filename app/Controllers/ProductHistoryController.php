<?php

namespace App\Controllers;

use App\Models\ProductHistoryModel;
use CodeIgniter\API\ResponseTrait;

class ProductHistoryController extends BaseController
{
    use ResponseTrait;

    public function getProductHistory($productId)
    {
        $model = new ProductHistoryModel();

        $productHistory = $model->getProductHistory($productId);

        return $this->respond($productHistory);
    }
}
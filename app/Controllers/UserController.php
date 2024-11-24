<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function getUserData()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');  // Get user_id from session
        $userData = $userModel->find($userId);  // Retrieve user data from the database
    
        return $this->response->setJSON($userData);
    }
    
}

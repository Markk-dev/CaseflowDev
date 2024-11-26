<?php

namespace App\Controllers;

use App\Models\CaseModel;
use App\Models\UserModel;
class Dashboard extends BaseController
{
    public function index()
{
    $caseModel = new CaseModel();
    
    // Fetch all cases ordered by priority
    $cases = $caseModel->orderBy('FIELD(case_priority, "High", "Medium", "Low")')->findAll();
    
    // Get the logged-in user's ID
    $userId = session()->get('user_id');
    
    $data = [
        'cases' => $cases,
        'totalCases' => count($cases),
        'highPriorityCases' => $caseModel->where('case_priority', 'High')->countAllResults(),
        'completedCases' => $caseModel->where('progress', 'Completed')->countAllResults(),
    ];

    return view('dashboard', $data);
}
    public function createCasePage()
    {
        return view('create_case'); 
    }

    public function createCase()
    {
        $caseModel = new CaseModel();
        $userId = session()->get('user_id');
    
        if (!$userId) {
            return redirect()->back()->with('error', 'User not logged in.');
        }
    
        $data = [
            'case_type'     => $this->request->getPost('case_type'),
            'description'   => $this->request->getPost('description'),
            'case_priority' => $this->request->getPost('case_priority'),
            'progress'      => $this->request->getPost('progress') ?? 0, // Default to 0 if not provided
            'user_id'       => session()->get('user_id'), // or fetch from session/login
            'created_by' => session()->get('user_id'), // Set the creator's ID
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];
        
    
        if ($caseModel->insert($data)) {
            return redirect()->to('/dashboard')->with('success', 'Case created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create case.');
        }
    }
    
    

    public function deleteCase($id)
    {
        $caseModel = new CaseModel();

        if (!$caseModel->find($id)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Case not found.']);
        }

        $caseModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }

    public function editCase($id)
{
    $caseModel = new CaseModel();
    $userModel = new UserModel();
    
    $userId = session()->get('user_id');
    
    if (!$caseModel->isCreator($id, $userId)) {
        return redirect()->back()->with('error', 'You do not have permission to edit this case.');
    }
    
    $data = [
        'case_type'    => $this->request->getPost('case_type'),
        'description'  => $this->request->getPost('description'),
        'case_priority' => $this->request->getPost('case_priority'),
        'progress'     => $this->request->getPost('progress'),
    ];
    
    if ($caseModel->update($id, $data)) {
        return redirect()->to('/dashboard')->with('success', 'Case updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to update the case.');
    }
}


    public function editCasePage($id)
    {
        $caseModel = new CaseModel();
        $userModel = new UserModel();
        
        $case = $caseModel->getCaseWithCreator($id);
        if (!$case) {
            return redirect()->back()->with('error', 'Case not found.');
        }
        
        $userId = session()->get('user_id');
        if (!$caseModel->isCreator($id, $userId)) {
            return redirect()->back()->with('error', 'You do not have permission to edit this case.');
        }
    
        $data = [
            'case' => $case,
        ];
        
        return view('edit_case', $data);
    }
    

}


<?php

namespace App\Controllers;

use App\Models\CaseModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $caseModel = new CaseModel();
       
        // Correct the ordering of case priorities
        $cases = $caseModel->orderBy('FIELD(case_priority, "High", "Medium", "Low")')->findAll();
        
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
    
        $data = [
            'case_type'    => $this->request->getPost('case_type'),
            'description'  => $this->request->getPost('description'),
            'case_priority'=> $this->request->getPost('case_priority'),
            'progress'     => 'Incomplete', 
            'admin_id'     => session()->get('user_id'), // Use dynamic admin ID based on authenticated user
        ];
    
        // Attempt to save data and handle errors
        if (!$caseModel->save($data)) {
            log_message('error', 'Case creation failed: ' . implode(', ', $caseModel->errors())); // Log error
            return $this->response->setJSON([
                'success' => false,
                'error'   => 'Failed to save case. Please review your input.',
            ]);
        }
    
        return $this->response->setJSON(['success' => true]);
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

        if (!$caseModel->find($id)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Case not found.']);
        }

        $data = [
            'case_type' => $this->request->getPost('case_type'),
            'description' => $this->request->getPost('description'),
            'case_priority' => $this->request->getPost('case_priority'),
            'progress' => $this->request->getPost('progress')
        ];

        if (!$caseModel->update($id, $data)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to update case.']);
        }

        return $this->response->setJSON(['success' => true]);
    }
}

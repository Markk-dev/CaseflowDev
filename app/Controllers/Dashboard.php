<?php

namespace App\Controllers;

use App\Models\CaseModel;
use App\Models\UserModel;
use App\Libraries\navbar;
class Dashboard extends BaseController
{
    public function index()
    {
        $caseModel = new CaseModel();
        $userId = session()->get('user_id');
    
        // Fetch active cases only (progress != "Complete") ordered by priority
        $activeCases = $caseModel
            ->where('progress !=', 'Complete')
            ->orderBy('FIELD(case_priority, "High", "Medium", "Low")')
            ->findAll();
    
        // Fetch counts for statistics
        $totalCases = $caseModel->countAllResults();
        $highPriorityCases = $caseModel->where('case_priority', 'High')->countAllResults();
        $completedCases = $caseModel->where('progress', 'Complete')->countAllResults();
    
        $data = [
            'cases' => $activeCases, // Only show active cases
            'totalCases' => $totalCases,
            'highPriorityCases' => $highPriorityCases,
            'completedCases' => $completedCases,
            'navbar' => new navbar(),
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
        
        $location = $this->request->getPost('location');
        if (empty($location)) {
            return redirect()->back()->with('error', 'Location is required.');
        }
    
        $data = [
            'case_type'     => $this->request->getPost('case_type'),
            'description'   => $this->request->getPost('description'),
            'case_priority' => $this->request->getPost('case_priority'),
            'progress'      => $this->request->getPost('progress') ?? 'Incomplete', // Default to "Incomplete"
            'location'      => $this->request->getPost('location'), // New fi
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
    

    public function completedCases()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('complete');
        $builder->select('cases.case_type, cases.description, cases.case_priority, complete.completed_at');
        $builder->join('cases', 'complete.case_id = cases.id');
        $query = $builder->get();
        $data['completedCases'] = $query->getResultArray();
        echo view('completed', $data);
    }

}


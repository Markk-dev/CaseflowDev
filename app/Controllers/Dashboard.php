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

        // Fetch active cases excluding those with 'Complete' progress
        $activeCases = $caseModel
            ->where('progress !=', 'Complete')
            ->orderBy('FIELD(case_priority, "High", "Medium", "Low")')
            ->paginate(10); // Pagination for better performance with large datasets
        
        $pager = \Config\Services::pager(); // Pager service to manage pagination

        // Count total cases and high priority cases
        $totalCases = $caseModel->countAllResults();
        $highPriorityCases = $caseModel->where('case_priority', 'High')->countAllResults();
        $completedCases = $caseModel->where('progress', 'Complete')->countAllResults();

        $data = [
            'cases' => $activeCases,
            'totalCases' => $totalCases,
            'highPriorityCases' => $highPriorityCases,
            'completedCases' => $completedCases,
            'pager' => $pager,  // Pass pager data to the view
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

        // Validate required fields
        $location = $this->request->getPost('location');
        if (empty($location)) {
            return redirect()->back()->with('error', 'Location is required.');
        }

        $data = [
            'case_type'     => $this->request->getPost('case_type'),
            'description'   => $this->request->getPost('description'),
            'case_priority' => $this->request->getPost('case_priority'),
            'progress'      => $this->request->getPost('progress') ?? 'Incomplete',
            'location'      => $location,
            'user_id'       => $userId,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        // Insert case and provide feedback
        if ($caseModel->insert($data)) {
            return redirect()->to('/dashboard')->with('success', 'Case created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create case.');
        }
    }

    public function deleteCase($id)
    {
        $caseModel = new CaseModel();

        // Check if the case exists before trying to delete
        if (!$caseModel->find($id)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Case not found.']);
        }

        // Delete the case
        $caseModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }

    public function editCase($id)
    {
        $caseModel = new CaseModel();
        $userModel = new UserModel();
        $userId = session()->get('user_id');

        // Check if the user is the creator of the case
        if (!$this->isUserAuthorized($id, $userId)) {
            return redirect()->back()->with('error', 'You do not have permission to edit this case.');
        }

        // Prepare case update data
        $data = [
            'case_type'     => $this->request->getPost('case_type'),
            'description'   => $this->request->getPost('description'),
            'case_priority' => $this->request->getPost('case_priority'),
            'progress'      => $this->request->getPost('progress'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        // Update case data and provide feedback
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

        // Get the case along with creator info
        $case = $caseModel->getCaseWithCreator($id);
        if (!$case) {
            return redirect()->back()->with('error', 'Case not found.');
        }

        $userId = session()->get('user_id');
        
        // Check if the user is the creator of the case
        if (!$this->isUserAuthorized($id, $userId)) {
            return redirect()->back()->with('error', 'You do not have permission to edit this case.');
        }

        // Pass case data to the view
        $data = [
            'case' => $case,
        ];

        return view('edit_case', $data);
    }

    // Helper method to check if the user is the creator of the case
    private function isUserAuthorized($caseId, $userId)
    {
        $caseModel = new CaseModel();
        return $caseModel->isCreator($caseId, $userId);
    }
}

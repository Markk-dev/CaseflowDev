<?php

namespace App\Controllers;

use App\Models\CaseModel;
use App\Models\CompleteCasesModel;

class ConfigController extends BaseController
{
    public function edit($id)
    {
        $caseModel = new \App\Models\CaseModel();
        $case = $caseModel->select('id, case_type, description, case_priority, progress, created_by')->find($id);

        if (!$case) {
            return redirect()->to('/dashboard')->with('error', 'Case not found.');
        }

        // Validate ownership
        $currentUserId = session()->get('user_id');
        if ($case['created_by'] !== $currentUserId) {
            return redirect()->to('/dashboard')->with('error', 'You cannot edit this case as it belongs to another user.');
        }

        return view('edit_case', ['case' => $case]);
    }

    public function update($id)
    {
        $caseModel = new CaseModel();
        $completeCasesModel = new CompleteCasesModel();
    
        // Find the case to update
        $case = $caseModel->find($id);
    
        if (!$case) {
            return redirect()->to('/dashboard')->with('error', 'Case not found.');
        }
    
        // Get data from the request
        $data = $this->request->getPost();
    
        // Update the case progress in the `cases` table
        $data = [
            'progress' => 'Complete',
            'completed_at' => date('Y-m-d H:i:s'),
        ];
        $caseModel->update($id, $data);
    
        // If progress is complete, move to complete_cases table
        $this->moveCompletedCases();
    
        return redirect()->to('/dashboard')->with('success', 'Case updated successfully.');
    }
    
    

    public function moveCompletedCases()
{
    $caseModel = new CaseModel();
    $completeModel = new CompleteCasesModel(); // This model works with the `complete` table.

    // Fetch all cases with progress 'Complete'
    $completedCases = $caseModel->where('progress', 'Complete')->findAll();

    foreach ($completedCases as $case) {
        try {
            // Check if the case already exists in the complete table
            $exists = $completeModel->where('case_id', $case['id'])->first();

            if (!$exists) {
                // Insert into the `complete` table
                $completeModel->insert([
                    'user_id' => $case['created_by'], // Ensure `created_by` is correct
                    'case_id' => $case['id'],
                    'completed_at' => date('Y-m-d H:i:s'),
                ]);

                log_message('debug', 'Moved case ID ' . $case['id'] . ' to the complete table.');
            } else {
                log_message('debug', 'Case ID ' . $case['id'] . ' already exists in the complete table.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error moving case ID ' . $case['id'] . ': ' . $e->getMessage());
        }
    }
}

    
}

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

        // Check if the case's progress is being updated to "Complete"
        if (isset($data['progress']) && $data['progress'] === 'Complete') {
            // Add an entry to the `complete_cases` table
            $completeCasesModel->insert([
                'user_id' => session()->get('user_id'),
                'case_id' => $id,
                'completed_at' => date('Y-m-d H:i:s'),
            ]);

            // Update the case progress in the `cases` table
            $caseModel->update($id, ['progress' => 'Complete']);
        } else {
            // Update the case in the `cases` table to set the progress
            $caseModel->update($id, $data);
        }

        return redirect()->to('/dashboard')->with('success', 'Case updated successfully.');
    }

    public function moveCompletedCases()
    {
        $caseModel = new CaseModel();
        $completeCasesModel = new CompleteCasesModel();

        // Fetch all cases with progress 'Complete'
        $completedCases = $caseModel->where('progress', 'Complete')->findAll();

        foreach ($completedCases as $case) {
            // Check if the case is already in the complete_cases table to avoid duplicates
            $exists = $completeCasesModel->where('case_id', $case['id'])->first();

            if (!$exists) {
                // Insert into complete_cases table
                $completeCasesModel->insert([
                    'user_id' => $case['created_by'],
                    'case_id' => $case['id'],
                    'completed_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect()->to('/dashboard')->with('success', 'All completed cases have been moved successfully.');
    }
}

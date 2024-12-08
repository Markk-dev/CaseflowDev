<?php

namespace App\Controllers;

use App\Models\CompleteCasesModel;
use App\Models\CaseModel;

class CompletedCase extends BaseController
{
    public function completedCases(): string
    {
        // Load models
        $completeCasesModel = new CompleteCasesModel();
        $caseModel = new CaseModel();

        // Get the logged-in user ID
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'You must be logged in to view completed cases.');
        }

        // Fetch completed cases
        $completedCases = $completeCasesModel
            ->select('cases.case_type, cases.description, cases.case_priority, complete_cases.completed_at')
            ->join('cases', 'cases.id = complete_cases.case_id')
            ->where('complete_cases.user_id', $userId)
            ->findAll();

        // Pass completed cases to the view
        return view('complete', ['completedCases' => $completedCases]);
    }
}

<?php

namespace App\Controllers;

use App\Models\CaseModel;
use App\Libraries\CaseItem; // Import the CaseItem class

class CompletedCase extends BaseController
{
    public function completedCases()
    {
        $caseModel = new CaseModel();
        $completedCases = $caseModel->where('progress', 'Complete')->findAll();
        
        // Instantiate the CaseItem class from Libraries
        $caseItem = new CaseItem();
        
        // Render the component for each case
        $caseRows = '';
        foreach ($completedCases as $case) {
            $caseRows .= $caseItem->render($case); // Concatenate the rendered rows
        }

        // Pass the rendered rows to the view
        return view('completed', [
            'caseRows' => $caseRows,
        ]);
    }
}

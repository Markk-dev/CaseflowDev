<?php

namespace App\Controllers;

use App\Models\CaseModel;

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
        $case = $caseModel->find($id);

        if (!$case) {
            return redirect()->to('/dashboard')->with('error', 'Case not found.');
        }

        
        $data = $this->request->getPost();

        if ($caseModel->update($id, $data)) {
            return redirect()->to('/dashboard')->with('success', 'Case updated successfully.');
        } else {
            return redirect()->to('/cases/edit/' . $id)->with('error', 'Failed to update case.');
        }
    }
}

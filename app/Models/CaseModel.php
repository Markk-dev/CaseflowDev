<?php

namespace App\Models;

use CodeIgniter\Model;

namespace App\Models;

use CodeIgniter\Model;

class CaseModel extends Model
{
    protected $table = 'cases';
    protected $primaryKey = 'id';
    protected $allowedFields = ['case_type', 'description', 'case_priority', 'progress', 'admin_id'];
    protected $useTimestamps = true;

    // Validation rules
    protected $validationRules = [
        'case_type'    => 'required|max_length[100]',
        'description'  => 'required',
        'case_priority' => 'required|in_list[High,Medium,Low]',
    ];
    
    protected $validationMessages = [
        'case_type' => [
            'required' => 'Case type is required.',
            'min_length' => 'Case type must be at least 3 characters long.',
        ],
        'description' => [
            'required' => 'Description is required.',
            'min_length' => 'Description must be at least 10 characters long.',
        ],
        'case_priority' => [
            'required' => 'Priority is required.',
            'in_list' => 'Priority must be one of: High, Medium, Low.',
        ],
    ];


    public function countCompletedCases()
    {
        return $this->where('progress', 'Complete')->countAllResults();
    }

    public function getCasesByPriority()
    {
        return $this->orderBy('FIELD(case_priority, "High", "Medium", "Low")', 'ASC')->findAll();
    }
    
}

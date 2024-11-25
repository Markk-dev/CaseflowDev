<?php

namespace App\Libraries;

class DataTableComponent {

    /**
     * Generate table rows dynamically based on case data.
     *
     * @param array $cases
     * @return string
     */
    public function generateTableRows(array $cases): string
    {
        if (empty($cases)) {
            return '<tr><td colspan="5" class="text-center">No cases found</td></tr>';
        }

        $counter = 1;
        $rows = '';

        foreach ($cases as $case) {
            $priorityComponent = $this->getPriorityComponent($case['case_priority']);

            $rows .= '
                <tr>
                    <td>' . esc($counter++) . '</td>
                    <td>' . esc($case['case_type']) . '</td>
                    <td>' . esc($case['description']) . '</td>
                    <td>' . $priorityComponent . '</td>
                    <td>
                        <a href="' . base_url('cases/edit/' . $case['id']) . '" class="btn btn-sm btn-warning">Edit</a>
                        <button class="btn btn-sm btn-success" onclick="completeCase(' . esc($case['id']) . ')">Complete</button>
                    </td>
                </tr>
            ';
        }

        return $rows;
    }

    /**
     * Get the priority capsule component based on the priority level.
     *
     * @param string $priority
     * @return string
     */
    private function getPriorityComponent(string $priority): string
    {
        switch (strtolower($priority)) {
            case 'high':
                return '
                    <div class="HighCapsule">
                        <span class="material-symbols-outlined" style="color: var(--red); font-size: 1rem">warning</span>
                        <p class="highPriority">High</p>
                    </div>
                ';
            case 'medium':
                return '
                    <div class="MediumCapsule">
                        <span class="material-symbols-outlined" style="color: var(--blue); font-size: 1rem">error</span>
                        <p class="mediumPriority">Medium</p>
                    </div>
                ';
            case 'low':
                return '
                    <div class="LowCapsule">
                        <span class="material-symbols-outlined" style="color: var(--green); font-size: 1rem">priority_high</span>
                        <p class="lowPriority">Low</p>
                    </div>
                ';
            default:
                return '<p>Unknown Case Priority</p>';
        }
    }
} 
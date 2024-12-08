<?php
namespace App\Libraries;

class CaseItem
{
    public function render($case)
    {
        
        ob_start();
        ?>
        <tr>
            <td><?= esc($case['case_type']); ?></td>
            <td><?= esc($case['description']); ?></td>
            <td><?= esc($case['case_priority']); ?></td>
            <td><?= esc($case['completed_at']) ?? 'Not Available'; ?></td> <!-- This will show NULL if not set -->
        </tr>
        <?php
        
        return ob_get_clean();
    }
}

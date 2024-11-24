<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Case</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2>Create Case</h2>
        <form id="createCaseForm" method="POST" action="<?= base_url('/cases/create') ?>">
            <div class="form-group">
                <label for="case_type">Case Type</label>
                <input type="text" class="form-control" name="case_type" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="case_priority">Priority</label>
                <select class="form-control" name="case_priority" required>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Case</button>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Back to Dashboard</a>
        </form>

        <!-- Error Toast -->
        <div aria-live="polite" aria-atomic="true" style="position: relative;">
            <div class="toast" id="errorToast" style="position: absolute; top: 20px; right: 20px; display: none;">
                <div class="toast-header">
                    <strong class="mr-auto">Error</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body" id="toastBody"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#createCaseForm').on('submit', function (e) {
                e.preventDefault();

                // Validation
                const caseType = $('input[name="case_type"]').val();
                const description = $('textarea[name="description"]').val();
                const casePriority = $('select[name="case_priority"]').val();

                if (!caseType || !description || !casePriority) {
                    $('#toastBody').html("All fields are required.");
                    $('#errorToast').toast({ delay: 3000 }).toast('show');
                    return;
                }

                // Submit Form via AJAX
                $.ajax({
                    url: '<?= base_url('/cases/create') ?>', // Ensure correct URL
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success) {
                            alert("Case created successfully!");
                            window.location.href = '<?= base_url('dashboard') ?>';
                        } else {
                            $('#toastBody').html(response.error);
                            $('#errorToast').toast({ delay: 3000 }).toast('show');
                        }
                    },
                    error: function () {
                        $('#toastBody').html("An error occurred while creating the case.");
                        $('#errorToast').toast({ delay: 3000 }).toast('show');
                    }
                });
            });
        });
    </script>
</body>

</html>

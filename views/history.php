<?php
require_once '../models/Action.php';
$action = new Action();
$actions = $action->read();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .description-btn {
            padding: 2px 8px;
            font-size: 0.9rem;
        }
        .modal-description {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Action History</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>User ID</th>
                                        <th>Product ID</th>
                                        <th>Quantity</th>
                                        <th>Action Type</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($actions as $action): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($action['timeStamp']); ?></td>
                                        <td><?php echo htmlspecialchars($action['userID']); ?></td>
                                        <td><?php echo htmlspecialchars($action['productID']); ?></td>
                                        <td><?php echo htmlspecialchars($action['quantity']); ?></td>
                                        <td><?php echo htmlspecialchars($action['actionType']); ?></td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-sm btn-info description-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#descriptionModal<?php echo $action['actionID']; ?>">
                                                View
                                            </button>

                                            <!-- Description Modal -->
                                            <div class="modal fade" id="descriptionModal<?php echo $action['actionID']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Action Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <strong>Description:</strong>
                                                                <p class="modal-description"><?php echo htmlspecialchars($action['description']); ?></p>
                                                            </div>
                                                            <?php if (!empty($action['oldValue']) || !empty($action['newValue'])): ?>
                                                            <div class="mb-3">
                                                                <strong>Changes:</strong>
                                                                <p>
                                                                    <?php 
                                                                    if (!empty($action['oldValue'])) {
                                                                        echo "From: " . htmlspecialchars($action['oldValue']);
                                                                    }
                                                                    if (!empty($action['newValue'])) {
                                                                        echo "<br>To: " . htmlspecialchars($action['newValue']);
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    </script>
</body>
</html> 
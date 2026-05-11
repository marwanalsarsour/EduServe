<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إشعارات - EduServe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
 <style>
    .notification-item { 
        cursor: pointer; 
        transition: 0.2s; 
        border-right: 4px solid transparent; 
        background-color: white; 
    }

    .notification-item.unread { 
        border-right-color: blue; 
        background-color: azure;  
    }


    .notification-item:hover { 
        background-color: whitesmoke; 
    }
    
    .notification-item.unread .fw-bold {
        color: black;
    }
</style>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container py-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center p-4">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-bell text-primary"></i> إشعارات النظام</h4>
                    <p class="text-muted mb-0">متابعة آخر التحديثات المتعلقة بالطلاب والطلبات.</p>
                </div>
                <button class="btn btn-outline-primary btn-sm" onclick="markAllAsRead()">
                    <i class="bi bi-check2-all ms-1"></i> تعليم الكل كمقروء
                </button>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="list-group list-group-flush" id="notificationsList">
                <?php if (!empty($notifications)): ?>
                    <?php foreach ($notifications as $index => $note): ?>
                        <div class="list-group-item list-group-item-action notification-item unread" 
                             onclick="showDetails('<?= htmlspecialchars($note['message']) ?>', this)">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <?php if($note['type'] == 'application'): ?>
                                            <span class="badge bg-primary-subtle text-primary p-2 rounded-circle"><i class="bi bi-file-earmark-plus"></i></span>
                                        <?php elseif($note['type'] == 'report'): ?>
                                            <span class="badge bg-info-subtle text-info p-2 rounded-circle"><i class="bi bi-journal-text"></i></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary p-2 rounded-circle"><i class="bi bi-info-circle"></i></span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($note['message']) ?></div>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i> <?= date('Y/m/d - h:i A', strtotime($note['event_time'])) ?>
                                        </small>
                                    </div>
                                </div>
                                <span class="badge bg-light text-dark border">جديد</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-bell-slash fs-1 d-block mb-2"></i>
                        لا توجد إشعارات حالياً.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="notificationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold">تفاصيل الإشعار</h5>
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p id="modalMessage" class="fs-5"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetails(message, element) {
            document.getElementById('modalMessage').innerText = message;
            const modal = new Bootstrap.Modal(document.getElementById('notificationModal'));
            modal.show();
            element.classList.remove('unread');
            element.querySelector('.badge.bg-light')?.remove();
        }

        function markAllAsRead() {
            document.querySelectorAll('.notification-item').forEach(item => {
                item.classList.remove('unread');
                item.querySelector('.badge.bg-light')?.remove();
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
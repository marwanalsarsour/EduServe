<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز الإشعارات - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    

    <main class="flex-grow-1 container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">
                <i class="bi bi-bell ms-2 text-primary"></i>الإشعارات الواردة
            </h4>
            <?php if(!empty($data['notifications'])): ?>
                <a href="/supervisor/notifications/mark-read" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    تحديد الكل كمقروء
                </a>
            <?php endif; ?>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="list-group list-group-flush">
                <?php if(!empty($data['notifications'])): ?>
                    <?php 
                    foreach(array_reverse($data['notifications']) as $notif): 
                    ?>
                        <div class="list-group-item list-group-item-action p-3 border-0 border-bottom <?= $notif['is_read'] ? '' : 'bg-white border-end border-primary border-4' ?>">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h6 class="mb-1 fw-bold"><?= htmlspecialchars($notif['title']) ?></h6>
                                <small class="text-muted small"><?= $notif['time_ago'] ?></small>
                            </div>
                            <p class="mb-1 text-secondary small"><?= htmlspecialchars($notif['message']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="p-5 text-center text-muted bg-white">
                        <i class="bi bi-bell-slash fs-1 d-block mb-3 opacity-25"></i>
                        <p>لا توجد إشعارات جديدة حالياً.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="mt-auto py-3 bg-white text-center border-top small text-muted">
        © 2026 EduServe - جامعة بوليتكنك فلسطين
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
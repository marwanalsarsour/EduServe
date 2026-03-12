<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إشعارات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/assets/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .notification-item { transition: all 0.3s ease; cursor: pointer; border-right: 5px solid transparent; }
        
        .notification-item:hover { background-color: white; border-bottom: 1px solid silver; }
        
        .icon-circle {
            width: 45px; height: 45px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            
            background-color: whitesmoke; 
        }
    </style>
</head>

<body style="background-color: white;"> <div class="container py-5">

        <div class="card shadow-sm border-0 mb-4" style="background-color: white;">
            <div class="card-body">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-bell ms-2" style="color: blue;"></i> 
                    مركز الإشعارات
                </h4>
                <p style="color: gray; margin-bottom: 0;">تابع آخر التحديثات على طلبات التدريب والفرص المتاحة حالياً.</p>
            </div>
        </div>

        <div class="card shadow-sm border-0" style="background-color: white;">
            <div class="card-header fw-bold py-3" style="background-color: white; color: black; border-bottom: 1px solid silver;">
                أحدث التنبيهات
            </div>

            <div class="list-group list-group-flush">
                <?php if (empty($notifications)): ?>
                    <div class="list-group-item text-center py-5" style="color: gray;">
                        <i class="bi bi-mailbox fs-1 d-block mb-3" style="color: silver;"></i>
                        لا توجد إشعارات جديدة.
                    </div>
                <?php else: ?>
                    <?php foreach ($notifications as $notif): 
                       
                        $displayColor = 'black'; 
                        
                        if (strpos($notif['title'], 'قبول') !== false) {
                            $displayColor = 'green'; 
                        } elseif (strpos($notif['title'], 'رفض') !== false) {
                            $displayColor = 'red'; 
                        } elseif (strpos($notif['title'], 'فرصة') !== false) {
                            $displayColor = 'blue'; 
                        }
                    ?>
                        <div class="list-group-item list-group-item-action notification-item p-3"
                             style="border-right-color: <?= $displayColor ?>; background-color: white;"
                             data-bs-toggle="modal" 
                             data-bs-target="#notificationModal"
                             data-title="<?= htmlspecialchars($notif['title']) ?>"
                             data-message="<?= htmlspecialchars($notif['message']) ?>"
                             data-color="<?= $displayColor ?>">
                            
                            <div class="d-flex align-items-center">
                                <div class="icon-circle ms-3" style="background-color: whitesmoke;">
                                    <i class="bi <?= $notif['icon'] ?? 'bi-info-circle' ?> fs-5" 
                                       style="color: <?= $displayColor ?>;"></i>
                                </div>
                                
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold mb-1" style="color: <?= $displayColor ?>;">
                                            <?= htmlspecialchars($notif['title']) ?>
                                        </h6>
                                        <small style="color: gray;"><?= $notif['time'] ?? 'الآن' ?></small>
                                    </div>
                                    <p style="color: dimgray; font-size: 0.9rem; margin-bottom: 0;" class="text-truncate">
                                        <?= htmlspecialchars($notif['message']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="notificationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; background-color: white;">
                <div class="modal-header" style="border-bottom: none; padding-top: 20px;">
                    <h5 class="modal-title fw-bold" id="modalTitle" style="color: black;">تفاصيل الإشعار</h5>
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center" style="padding: 30px;">
                    <div class="mb-3 fs-1">
                        <i class="bi bi-envelope-open" id="modalIcon" style="color: blue;"></i>
                    </div>
                    <p id="modalMessage" style="color: black; font-size: 1.2rem;"></p>
                </div>
                <div class="modal-footer" style="border-top: none; justify-content: center; padding-bottom: 20px;">
                    <button type="button" class="btn" data-bs-dismiss="modal" 
                            style="background-color: black; color: white; padding: 10px 40px; border-radius: 20px; border: none;">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const notificationModal = document.getElementById('notificationModal');
        notificationModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            const message = button.getAttribute('data-message');
            const color = button.getAttribute('data-color');
            
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalTitle').style.color = color;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('modalIcon').style.color = color;
        });
    </script>
</body>
</html>
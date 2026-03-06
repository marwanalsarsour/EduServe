<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلباتي - EduServe</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        
        .badge-pending { background-color: Gold; color: Black; }
        .badge-approved { background-color: Green; color: White; }
        .badge-rejected { background-color: Red; color: White; }
        
        .opportunity-card-table { border-radius: 10px; overflow: hidden; }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <div class="flex-grow-1">
        <div class="container py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="fw-bold mb-1">طلباتي</h4>
                    <p class="text-muted small mb-0">تتبع حالات طلبات الانضمام التي قمت بالتقديم عليها</p>
                </div>

                <a href="/student_opportunities" class="btn btn-primary">
                    <i class="bi bi-plus-circle ms-1"></i>
                    التقديم على فرصة جديدة
                </a>
            </div>

            <div class="card shadow-sm border-0 opportunity-card-table">
                <div class="card-body p-4">

                    <?php if (empty($applications)): ?>
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                            <h5 class="fw-bold">لا يوجد طلبات حتى الآن</h5>
                            <p class="small">ابدأ باستكشاف الفرص المتاحة والتقديم عليها من خلال زر التقديم.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table align-middle text-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start">الفرصة</th>
                                        <th>النوع</th>
                                        <th>تاريخ التقديم</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($applications as $app): 
                                        // تحديد كلاس الحالة بناءً على القيمة القادمة من الداتابيز
                                        $statusClass = 'badge-pending';
                                        $statusLabel = 'قيد الانتظار';
                                        
                                        if ($app['Status'] === 'Approved') {
                                            $statusClass = 'badge-approved';
                                            $statusLabel = 'مقبول';
                                        } elseif ($app['Status'] === 'Rejected') {
                                            $statusClass = 'badge-rejected';
                                            $statusLabel = 'مرفوض';
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-start fw-bold">
                                                <?php echo htmlspecialchars($app['Title']); ?>
                                                <div class="text-muted x-small fw-normal"><?php echo htmlspecialchars($app['OrganizationName'] ?? ''); ?></div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    <?php echo ($app['Type'] === 'Training' ? 'تدريب ميداني' : 'عمل تطوعي'); ?>
                                                </span>
                                            </td>
                                            <td class="text-muted">
                                                <?php echo date('Y-m-d', strtotime($app['RequestDate'])); ?>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo $statusClass; ?> px-3 py-2 rounded-pill">
                                                    <?php echo $statusLabel; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto py-3 bg-primary text-white text-center">
        <div class="container">
            <small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
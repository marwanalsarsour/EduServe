<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المتطوع - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body class="bg-light text-end">

    <div class="container py-5">

        <!-- رسائل النجاح أو الخطأ -->
        <?php if(!empty($successMessage)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>
        <?php if(!empty($errorMessage)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <div class="mb-4">
            <a href="/v_manager/volunteers" class="text-decoration-none text-secondary small">
                <i class="bi bi-arrow-right ms-1"></i> العودة لقائمة المتطوعين
            </a>
        </div>

        <div class="row g-4">
            <!-- بطاقة المتطوع -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                    <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-badge fs-2 text-danger"></i>
                    </div>
                    <h5 class="fw-bold text-dark"><?= htmlspecialchars($student['name'] ?? 'غير معروف') ?></h5>
                    <p class="text-muted extra-small"><?= htmlspecialchars($student['majorName'] ?? $student['major'] ?? 'غير محدد') ?></p>
                    <hr>
                    
                    <?php
                        $requiredHours = $student['requiredVolunteerHours'] ?? $student['required_hours'] ?? 50;
                        $completedHours = $student['completed_hours'] ?? 0;
                        $progress = min(100, round(($completedHours / $requiredHours) * 100));
                    ?>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span>إجمالي الساعات المنجزة:</span>
                        <span class="fw-bold text-danger"><?= $completedHours ?> من <?= $requiredHours ?> س</span>
                    </div>
                    <div class="progress rounded-pill mb-3" style="height: 10px;">
                        <div class="progress-bar bg-danger" style="width: <?= $progress ?>%"></div>
                    </div>
                    <p class="small text-muted mb-4">نسبة الإنجاز: <?= $progress ?>%</p>

                   
                    <form method="POST" action="/v_manager/complete-volunteer">
                        <input type="hidden" name="studentID" value="<?= $student['studentID'] ?? $student['id'] ?>">
                        <button
                            type="submit"
                            name="complete_volunteer"
                            class="btn btn-dark w-100 rounded-pill fw-bold shadow-sm"
                            <?= ($completedHours < $requiredHours) ? 'disabled' : '' ?>
                        >
                            تأكيد إنهاء التطوع
                        </button>
                    </form>
                    <?php if($completedHours < $requiredHours): ?>
                        <p class="extra-small text-danger mt-2">لا يمكن إنهاء التطوع قبل استكمال الساعات</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0 text-danger"><i class="bi bi-clock-history ms-2"></i>سجل الحضور</h6>
                        <span class="badge bg-light text-dark border"><?= count($attendance) ?></span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="small text-secondary">
                                    <th>التاريخ</th>
                                    <th>عدد الساعات</th>
                                    <th>الملاحظة</th>
                                    <th class="text-center">الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($attendance)): ?>
                                    <?php foreach($attendance as $row): ?>
                                        <tr>
                                            <td class="fw-bold small"><?= htmlspecialchars($row['date'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['total_hours'] ?? 0) ?> ساعات</td>
                                            <td class="small text-muted"><?= htmlspecialchars($row['notes'] ?? 'لا توجد ملاحظات') ?></td>
                                            <td class="text-center">
                                                <?php
                                                    $status = $row['status'] ?? '';
                                                    if($status == 'حاضر'):
                                                        $badgeClass = 'bg-success-subtle text-success';
                                                        $label = 'حاضر';
                                                    elseif($status == 'معذر' || $status == 'مُعذر'):
                                                        $badgeClass = 'bg-info-subtle text-info';
                                                        $label = 'معذر';
                                                    elseif($status == 'غائب'):
                                                        $badgeClass = 'bg-danger-subtle text-danger';
                                                        $label = 'غائب';
                                                    else:
                                                        $badgeClass = 'bg-secondary-subtle text-secondary';
                                                        $label = htmlspecialchars($status);
                                                    endif;
                                                ?>
                                                <span class="badge <?= $badgeClass ?> rounded-pill px-3"><?= $label ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted small">لا يوجد سجل حضور مسجل لهذا الطالب بعد.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
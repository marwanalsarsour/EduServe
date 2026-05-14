<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الحضور اليومي - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light text-end">
    <?php 
    require_once '../src/views/layout/header.php'; 
    $current_hour = (int)date('H');
    $is_locked = ($current_hour >= 17); 
    ?>

    <div class="container py-5">
        <?php if ($is_locked): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
                <i class="bi bi-clock-history ms-3 fs-3"></i>
                <div>
                    <strong>نظام الرصد مغلق:</strong> لا يمكن تعديل الحضور بعد الساعة 05:00 مساءً.
                </div>
            </div>
        <?php endif; ?>

        <form action="/trainer/attendance/save" method="POST">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-calendar-check ms-2 text-primary"></i>كشف حضور يوم: <?= date('Y-m-d') ?>
                </h4>
                <button type="submit" class="btn btn-success shadow-sm rounded-pill px-4 fw-bold" <?= $is_locked ? 'disabled' : '' ?>>
                    <i class="bi bi-check-all ms-1"></i>اعتماد الكشف النهائي
                </button>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden <?= $is_locked ? 'opacity-75' : '' ?>">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-white border-bottom">
                            <tr class="text-secondary small">
                                <th class="py-3 px-4">اسم الطالب</th>
                                <th class="py-3 text-center">وقت الحضور</th>
                                <th class="py-3 text-center">وقت الانصراف</th>
                                <th class="py-3 text-center">عدد الساعات</th>
                                <th class="py-3 text-center">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attendance_list as $row): ?>
                            <tr class="bg-white">
                                <td class="px-4">
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($row['student_name']) ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($row['major']) ?></div>
                                </td>
                                <td class="text-center">
                                    <input type="time" name="attendance[<?= $row['student_id'] ?>][arrival]" 
                                           class="form-control form-control-sm border-0 bg-light shadow-sm mx-auto" 
                                           style="max-width: 120px;" value="<?= $row['arrival_time'] ?? '08:00' ?>" <?= $is_locked ? 'disabled' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="time" name="attendance[<?= $row['student_id'] ?>][departure]" 
                                           class="form-control form-control-sm border-0 bg-light shadow-sm mx-auto" 
                                           style="max-width: 120px;" value="<?= $row['departure_time'] ?? '14:00' ?>" <?= $is_locked ? 'disabled' : '' ?>>
                                </td>
                                <td class="text-center fw-bold text-primary">
                                    <?= $row['total_hours'] ?? '0' ?> ساعة
                                </td>
                                <td class="text-center">
                                    <select name="attendance[<?= $row['student_id'] ?>][status]" 
                                            class="form-select form-select-sm border-0 bg-light shadow-sm mx-auto" 
                                            style="max-width: 130px;" <?= $is_locked ? 'disabled' : '' ?>>
                                        <option value="present" <?= ($row['status'] == 'present') ? 'selected' : '' ?>>حاضر</option>
                                        <option value="absent" <?= ($row['status'] == 'absent') ? 'selected' : '' ?>>غائب</option>
                                        <option value="leave" <?= ($row['status'] == 'leave') ? 'selected' : '' ?>>إجازة</option>
                                    </select>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
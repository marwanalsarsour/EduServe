<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة حضور المتدربين - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light text-end">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">كشف حضور المتدربين</h4>
            <p class="text-muted small mb-0">تاريخ الرصد: <span class="fw-bold text-primary"><?= date('Y-m-d') ?></span></p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-white border-bottom">
                    <tr class="small text-secondary">
                        <th class="py-3 px-4">المتدرب</th>
                        <th class="py-3 text-center">حالة الحضور</th>
                        <th class="py-3 text-center">دخول</th>
                        <th class="py-3 text-center">خروج</th>
                        <th class="py-3 text-center">الساعات</th>
                        <th class="py-3 text-center">ملاحظات</th>
                        <th class="py-3 text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($attendance_list as $row): ?>
                    <tr class="bg-white" id="row-<?= $row['student_id'] ?>">
                        <td class="px-4">
                            <div class="fw-bold text-dark"><?= htmlspecialchars($row['student_name']) ?></div>
                            <div class="text-muted small"><?= htmlspecialchars($row['major']) ?></div>
                        </td>
                        <td class="text-center">
                            <select class="form-select form-select-sm border-0 bg-light shadow-sm mx-auto status-input" style="width: 110px;">
                                <option value="حاضر" <?= ($row['status'] == 'حاضر') ? 'selected' : '' ?>>حاضر</option>
                                <option value="غائب" <?= ($row['status'] == 'غائب') ? 'selected' : '' ?>>غائب</option>
                                <option value="متأخر" <?= ($row['status'] == 'متأخر') ? 'selected' : '' ?>>متأخر</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <input type="time" class="form-control form-control-sm border-0 bg-light checkin-input" value="<?= $row['arrival_time'] ?? '' ?>" style="width: 110px;">
                        </td>
                        <td class="text-center">
                            <input type="time" class="form-control form-control-sm border-0 bg-light checkout-input" value="<?= $row['departure_time'] ?? '' ?>" style="width: 110px;">
                        </td>
                        <td class="text-center">
                            <input type="number" step="0.5" class="form-control form-control-sm border-0 bg-light text-center hours-input" value="<?= $row['total_hours'] ?? 0 ?>" style="width: 80px;">
                        </td>
                        <td class="text-center">
                            <input type="text" class="form-control form-control-sm border-0 bg-light notes-input" value="<?= htmlspecialchars($row['notes'] ?? '') ?>" placeholder="ملاحظة...">
                        </td>
                        <td class="text-center">
                            <button onclick="saveAttendance(<?= $row['student_id'] ?>)" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm save-btn">
                                <i class="bi bi-save ms-1"></i> حفظ
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function saveAttendance(studentId) {
    const row = document.querySelector(`#row-${studentId}`);
    const btn = row.querySelector('.save-btn');
    
    const data = {
        studentID: studentId,
        status: row.querySelector('.status-input').value,
        checkIn: row.querySelector('.checkin-input').value,
        checkOut: row.querySelector('.checkout-input').value,
        hours: row.querySelector('.hours-input').value,
        notes: row.querySelector('.notes-input').value
    };

    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    btn.disabled = true;

    fetch('/trainer/attendance/save', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(data)
    })
    .then(res => res.json())
    .then(result => {
        btn.disabled = false;
        if(result.success) {
            btn.innerHTML = '<i class="bi bi-check-lg"></i> تم';
            btn.classList.replace('btn-outline-primary', 'btn-success');
            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-save ms-1"></i> حفظ';
                btn.classList.replace('btn-success', 'btn-outline-primary');
            }, 2000);
        } else {
            alert('خطأ في الحفظ: ' + (result.message || ''));
            btn.innerHTML = '<i class="bi bi-save ms-1"></i> حفظ';
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-save ms-1"></i> حفظ';
        alert('حدث خطأ أثناء الاتصال بالخادم');
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
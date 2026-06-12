<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رصد الحضور والساعات - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>

<body class="bg-light text-end">

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark">سجل حضور المتطوعين</h4>
                <p class="text-muted small mb-0">
                    تاريخ الرصد: <span class="fw-bold text-danger"><?= date('Y-m-d') ?></span>
                </p>
            </div>

            <button id="finalize-btn" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-check2-all ms-1"></i> اعتماد النهائي للكشف
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-white border-bottom">
                        <tr class="small text-secondary">
                            <th class="py-3 px-4">المتطوع</th>
                            <th class="py-3 text-center">حالة الحضور</th>
                            <th class="py-3 text-center">دخول</th>
                            <th class="py-3 text-center">خروج</th>
                            <th class="py-3 text-center">الساعات</th>
                            <th class="py-3 text-center">ملاحظات</th>
                            <th class="py-3 text-center">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($volunteers as $v): ?>
                            <tr class="bg-white" id="row-<?= $v['id'] ?>">
                                <td class="px-4">
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($v['name']) ?></div>
                                </td>
                                <td class="text-center">
                                    <select class="form-select form-select-sm border-0 bg-light shadow-sm mx-auto status-input" style="width: 110px;">
                                        <option value="حاضر" <?= ($v['status'] == 'حاضر') ? 'selected' : '' ?>>حاضر</option>
                                        <option value="غائب" <?= ($v['status'] == 'غائب') ? 'selected' : '' ?>>غائب</option>
                                        <option value="متأخر" <?= ($v['status'] == 'متأخر') ? 'selected' : '' ?>>متأخر</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <input type="time" class="form-control form-control-sm border-0 bg-light checkin-input" value="<?= $v['checkIn'] ?? '' ?>" style="width: 110px;">
                                </td>
                                <td class="text-center">
                                    <input type="time" class="form-control form-control-sm border-0 bg-light checkout-input" value="<?= $v['checkOut'] ?? '' ?>" style="width: 110px;">
                                </td>
                                <td class="text-center">
                                    <div class="input-group input-group-sm mx-auto" style="width: 90px;">
                                        <input type="number" class="form-control border-0 bg-light text-center hours-input" value="<?= $v['total_hours'] ?? 0 ?>" min="0" max="24">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control form-control-sm border-0 bg-light shadow-sm notes-input" value="<?= htmlspecialchars($v['notes'] ?? '') ?>" placeholder="ملاحظة...">
                                </td>
                                <td class="text-center">
                                    <button onclick="saveAttendance(<?= $v['id'] ?>)" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm save-btn">
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
        function getRowData(row) {
            return {
                student_id: row.id.replace('row-', ''),
                status: row.querySelector('.status-input').value,
                check_in: row.querySelector('.checkin-input').value,
                check_out: row.querySelector('.checkout-input').value,
                hours: row.querySelector('.hours-input').value,
                notes: row.querySelector('.notes-input').value
            };
        }

        function saveAttendance(studentId) {
            const row = document.querySelector(`#row-${studentId}`);
            const data = getRowData(row);
            const btn = row.querySelector('.save-btn');

            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            fetch('/v_manager/attendance/save', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(data)
            })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    btn.innerHTML = '<i class="bi bi-check-lg"></i> تم الحفظ';
                    btn.classList.replace('btn-outline-danger', 'btn-success');
                    setTimeout(() => {
                        btn.innerHTML = '<i class="bi bi-save ms-1"></i> حفظ';
                        btn.classList.replace('btn-success', 'btn-outline-danger');
                    }, 2000);
                } else {
                    alert('حدث خطأ: ' + (result.error || ''));
                    btn.innerHTML = '<i class="bi bi-save ms-1"></i> حفظ';
                }
            });
        }

        document.getElementById('finalize-btn').addEventListener('click', function() {
            const rows = document.querySelectorAll('tbody tr');
            const promises = Array.from(rows).map(row => {
                return fetch('/v_manager/attendance/save', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams(getRowData(row))
                })
                .then(res => res.json());
            });

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = 'جارٍ الحفظ...';

            Promise.all(promises).then(results => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check-lg"></i> تم الاعتماد النهائي';
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-check2-all ms-1"></i> اعتماد النهائي للكشف';
                }, 2000);
            });
        });
    </script>
</body>
</html>
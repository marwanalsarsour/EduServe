<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>توثيق الحضور</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <div class="flex-grow-1">
        <div class="container py-4">
            <h4 class="fw-bold mb-4">
                <i class="bi bi-calendar-check ms-2"></i> توثيق ساعات الحضور
            </h4>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-2"><?php echo htmlspecialchars($opportunity['type'] ?? 'لا يوجد تدريب نشط حالياً'); ?></h5>
                    <h6 class="text-muted"><?php echo htmlspecialchars($opportunity['OrganizationName'] ?? '-'); ?></h6>
                </div>
            </div>

            <div id="attendanceMsg" class="alert d-none"></div>

            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>التاريخ</th>
                                <th>اليوم</th>
                                <th>ساعة القدوم</th>
                                <th>ساعة المغادرة</th>
                                <th>الساعات</th>
                                <th>حالة الاعتماد</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceTableBody">
                            <?php 
                            $totalAllHours = 0;
                            if (!empty($attendanceRecords)): 
                                foreach ($attendanceRecords as $record): 
                                    $totalAllHours += (float)($record['hours'] ?? 0);
                                    $dayName = date('l', strtotime($record['date'] ?? 'now'));
                                    $daysAr = ['Monday'=>'الإثنين','Tuesday'=>'الثلاثاء','Wednesday'=>'الأربعاء','Thursday'=>'الخميس','Friday'=>'الجمعة','Saturday'=>'السبت','Sunday'=>'الأحد'];
                                    
                                    // التحقق من حالة الاعتماد
                                    $isApproved = ($record['academicStatus'] === 'معتمد');
                            ?>
                                <tr data-id="<?php echo $record['attendanceID']; ?>">
                                    <td><?php echo htmlspecialchars($record['date'] ?? ''); ?></td>
                                    <td><?php echo $daysAr[$dayName] ?? $dayName; ?></td>
                                    <td>
                                        <input type="time" class="form-control form-control-sm text-center check-in" 
                                               value="<?php echo htmlspecialchars($record['checkIn'] ?? ''); ?>" 
                                               <?php echo $isApproved ? 'disabled' : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="time" class="form-control form-control-sm text-center check-out" 
                                               value="<?php echo htmlspecialchars($record['checkOut'] ?? ''); ?>" 
                                               <?php echo $isApproved ? 'disabled' : ''; ?>>
                                    </td>
                                    <td class="fw-bold"><?php echo number_format((float)($record['hours'] ?? 0), 2); ?></td>
                                    <td>
                                        <?php if ($isApproved): ?>
                                            <span class="badge bg-success"><i class="bi bi-check-all"></i> معتمد</span>
                                        <?php elseif ($record['academicStatus'] === 'بانتظار الاعتماد'): ?>
                                            <span class="badge bg-warning text-dark">بانتظار الاعتماد</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">لم يتم التوثيق</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="6" class="text-muted py-4">لا توجد سجلات حضور مسجلة حالياً.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3 shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">إجمالي الساعات الكلي: <span id="totalHours" class="text-primary"><?php echo number_format($totalAllHours, 2); ?> ساعة</span></h6>
                    <button class="btn btn-success" onclick="saveChanges()">
                        <i class="bi bi-save ms-1"></i> حفظ التغييرات
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-3 bg-primary text-white text-center">
        <small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function saveChanges() {
            // نأخذ فقط الصفوف التي ليست معتمدة (أو نرسل الكل والسيرفر يتحقق)
            const rows = document.querySelectorAll('#attendanceTableBody tr[data-id]');
            const data = [];

            rows.forEach(row => {
                // لا نرسل بيانات الصفوف المعتمدة (المعطلة)
                const checkIn = row.querySelector('.check-in');
                if (!checkIn.disabled) {
                    data.push({
                        id: row.getAttribute('data-id'),
                        check_in: checkIn.value,
                        check_out: row.querySelector('.check-out').value
                    });
                }
            });

            if(data.length === 0) {
                alert('لا توجد سجلات قابلة للتعديل.');
                return;
            }

            const btn = event.target;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm ms-1"></span> جاري الحفظ...';

            fetch('/save_attendance', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ records: data })
            })
            .then(res => res.json())
            .then(res => {
                const msg = document.getElementById('attendanceMsg');
                msg.className = `alert d-block alert-${res.status === 'success' ? 'success' : 'danger'}`;
                msg.innerText = res.message;
                if(res.status === 'success') {
                    setTimeout(() => location.reload(), 1000); 
                }
            })
            .catch(() => alert('حدث خطأ في الاتصال بالسيرفر'))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-save ms-1"></i> حفظ التغييرات';
            });
        }
    </script>
</body>
</html>
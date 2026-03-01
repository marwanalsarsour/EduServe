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
                <i class="bi bi-calendar-check ms-2"></i>
                توثيق ساعات الحضور
            </h4>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <h5 id="opportunityType" class="fw-bold text-primary mb-2">
                        <?php echo htmlspecialchars($opportunity['Type'] ?? 'لا يوجد تدريب نشط حالياً'); ?>
                    </h5>

                    <h6 id="organizationName" class="text-muted">
                        <?php echo htmlspecialchars($opportunity['OrganizationName'] ?? '-'); ?>
                    </h6>
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
                                <th>مجموع الساعات</th>
                                <th>توقيع الطالب</th>
                                <th>توقيع المشرف</th>
                            </tr>
                        </thead>

                        <tbody id="attendanceTableBody">
                            <?php 
                            $totalAllHours = 0;
                            if (!empty($attendanceRecords)): 
                                foreach ($attendanceRecords as $record): 
                                    $totalAllHours += $record['HoursWorked'];
                                    $dayName = date('l', strtotime($record['Date']));
                                    
                                    $daysAr = ['Monday'=>'الإثنين','Tuesday'=>'الثلاثاء','Wednesday'=>'الأربعاء','Thursday'=>'الخميس','Friday'=>'الجمعة','Saturday'=>'السبت','Sunday'=>'الأحد'];
                            ?>
                                <tr data-id="<?php echo $record['AttendanceID']; ?>">
                                    <td><?php echo $record['Date']; ?></td>
                                    <td><?php echo $daysAr[$dayName] ?? $dayName; ?></td>
                                    <td>
                                        <input type="time" class="form-control form-control-sm text-center check-in" 
                                               value="<?php echo $record['CheckIn']; ?>">
                                    </td>
                                    <td>
                                        <input type="time" class="form-control form-control-sm text-center check-out" 
                                               value="<?php echo $record['CheckOut']; ?>">
                                    </td>
                                    <td class="hours-worked fw-bold"><?php echo number_format($record['HoursWorked'], 1); ?></td>
                                    <td><span class="badge bg-success">تم التوقيع</span></td>
                                    <td>
                                        <?php if ($record['SupervisorSignature']): ?>
                                            <span class="badge bg-success"><i class="bi bi-check-all"></i> معتمد</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">قيد الانتظار</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="7" class="text-muted py-4">لا توجد سجلات حضور مسجلة حالياً.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3 shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">
                        إجمالي الساعات الكلي:
                        <span id="totalHours" class="text-primary"><?php echo number_format($totalAllHours, 1); ?> ساعة</span>
                    </h6>

                    <button class="btn btn-success" onclick="saveChanges()">
                        <i class="bi bi-save ms-1"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </div>

        </div>
    </div>

    <footer class="mt-5 py-3 bg-primary text-white text-center">
        <div class="container">
            <small>
                © 2026 EduServe - جامعة بوليتكنك فلسطين
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        
        function saveChanges() {
            const rows = document.querySelectorAll('#attendanceTableBody tr[data-id]');
            const data = [];

            rows.forEach(row => {
                data.push({
                    id: row.getAttribute('data-id'),
                    check_in: row.querySelector('.check-in').value,
                    check_out: row.querySelector('.check-out').value
                });
            });

            
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
            .catch(err => {
                alert('حدث خطأ في الاتصال بالسيرفر');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-save ms-1"></i> حفظ التغييرات';
            });
        }
    </script>
</body>

</html>
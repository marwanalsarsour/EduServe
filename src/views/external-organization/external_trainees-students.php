<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title><?= $labels['title'] ?> - EduServe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">


    <div class="container my-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-people ms-1 text-primary"></i>
                    الطلاب <?= $labels['title'] ?>
                </h4>
                <p class="text-muted mb-0"><?= $labels['desc'] ?></p>
            </div>
        </div>

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body p-3">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" id="searchInput" class="form-control" placeholder="بحث باسم الطالب أو التخصص...">
                    </div>
                    <div class="col-md-4">
                        <select id="statusFilter" class="form-select">
                            <option value="">كل الحالات</option>
                            <option value="active">نشط</option>
                            <option value="completed">منتهي</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100" onclick="filterTable()">
                            <i class="bi bi-funnel"></i> تصفية
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الطالب</th>
                                <th>التخصص</th>
                                <th><?= $labels['supervisor_label'] ?></th>
                                <th>ساعات الإنجاز</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTable">
                            <?php if (!empty($trainees)): ?>
                                <?php foreach ($trainees as $index => $student): 
                                    $statusClass = ($student['internship_status'] == 'active') ? 'bg-success' : 'bg-secondary';
                                    $statusText = ($student['internship_status'] == 'active') ? 'نشط' : 'منتهي';
                                ?>
                                <tr class="student-row" data-status="<?= $student['internship_status'] ?>">
                                    <td><?= $index + 1 ?></td>
                                    <td class="student-name fw-bold"><?= htmlspecialchars($student['student_name']) ?></td>
                                    <td><?= htmlspecialchars($student['major'] ?? 'غير محدد') ?></td>
                                    <td><?= htmlspecialchars($student['supervisor_name'] ?? 'لم يحدد') ?></td>
                                    <td>
                                        <span class="badge rounded-pill bg-light text-dark border">
                                            <?= $student['total_hours'] ?? 0 ?> ساعة
                                        </span>
                                    </td>
                                    <td><span class="badge <?= $statusClass ?>"><?= $statusText ?></span></td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="/external/student-profile/<?= $student['student_id'] ?>" 
                                               class="btn btn-sm btn-outline-info" title="عرض ملف الطالب">
                                                <i class="bi bi-person-badge"></i>
                                            </a>

                                            <?php if ($student['internship_status'] == 'completed'): ?>
                                            <a href="/external/certificates?student_id=<?= $student['student_id'] ?>" 
                                               class="btn btn-sm btn-success" title="إصدار شهادة">
                                                <i class="bi bi-award"></i>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="py-5 text-muted">
                                        <i class="bi bi-inbox d-block fs-2 mb-2"></i>
                                        لا يوجد سجلات حالياً لهؤلاء الطلاب.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterTable() {
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('.student-row');

            rows.forEach(row => {
                const name = row.querySelector('.student-name').innerText.toLowerCase();
                const status = row.getAttribute('data-status');
                
                const matchesSearch = name.includes(searchText);
                const matchesStatus = statusFilter === "" || status === statusFilter;

                if (matchesSearch && matchesStatus) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        document.getElementById('searchInput').addEventListener('keyup', filterTable);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
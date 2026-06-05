<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إدارة المسؤول - EduServe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">


    <div class="container my-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="fw-bold mb-1">
                            <i class="bi bi-person-badge ms-1 text-primary"></i>
                            بيانات المسؤول المعتمد
                        </h4>
                        <p class="text-muted small">هذا هو المسؤول الوحيد المخول بإدارة الطلاب لهذه الجهة.</p>
                    </div>
                    <?php if ($supervisor): ?>
                    <button class="btn btn-outline-primary btn-sm" onclick="toggleEditForm()">
                        <i class="bi bi-pencil-square ms-1"></i> تعديل البيانات
                    </button>
                    <?php endif; ?>
                </div>
                
                <hr>

                <?php if ($supervisor): ?>
                <div class="row mt-3" id="supervisorInfo">
                    <div class="col-md-3">
                        <label class="text-muted small d-block">اسم المسؤول</label>
                        <span class="fw-bold"><?= htmlspecialchars($supervisor['name']) ?></span>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small d-block">البريد الإلكتروني</label>
                        <span class="fw-bold"><?= htmlspecialchars($supervisor['email']) ?></span>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small d-block">رقم الهاتف</label>
                        <span class="fw-bold"><?= htmlspecialchars($supervisor['phone']) ?></span>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small d-block">المجال / النشاط</label>
                        <span class="fw-bold text-success"><?= htmlspecialchars($supervisor['field']) ?></span>
                    </div>
                </div>

                <form id="editSupervisorForm" class="mt-4 d-none" method="POST" action="/external/officials/update">
                    <input type="hidden" name="id" value="<?= $supervisor['id'] ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">اسم المسؤول</label>
                            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($supervisor['name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($supervisor['email']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($supervisor['phone']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">المجال</label>
                            <input type="text" class="form-control" name="field" value="<?= htmlspecialchars($supervisor['field']) ?>">
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                            <button type="button" class="btn btn-light" onclick="toggleEditForm()">إلغاء</button>
                        </div>
                    </div>
                </form>
                <?php else: ?>
                    <div class="alert alert-warning">لم يتم تعريف مسؤول لهذه الجهة بعد. يرجى التواصل مع الإدارة.</div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($supervisor): ?>
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-plus-circle ms-1 text-success"></i>
                    إضافة طالب تحت إشراف المسؤول
                </h5>
                <form method="POST" action="/external/officials/assign">
                    <input type="hidden" name="supervisor_id" value="<?= $supervisor['id'] ?>">
                    
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label">اختيار الطالب من قائمة المنتظرين</label>
                            <select class="form-select" name="student_id" required>
                                <option value="">اختر الطالب...</option>
                                <?php foreach ($unassignedStudents as $st): ?>
                                    <option value="<?= $st['id'] ?>"><?= htmlspecialchars($st['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-lg ms-1"></i> تعيين الطالب للمسؤول
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">الطلاب المسجلين حالياً (<?= count($assignedStudents) ?> طلاب)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الطالب</th>
                                <th>تاريخ التعيين</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($assignedStudents as $index => $student): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($student['name']) ?></td>
                                <td><?= date('Y-m-d', strtotime($student['assigned_at'])) ?></td>
                                <td>
                                    <a href="/external/officials/unassign/<?= $student['id'] ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('هل أنت متأكد من إزالة الطالب من إشراف هذا المسؤول؟')">
                                        <i class="bi bi-person-x"></i> إزالة
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($assignedStudents)): ?>
                                <tr><td colspan="4" class="text-muted py-3">لا يوجد طلاب معينين حالياً</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script>
        function toggleEditForm() {
            document.getElementById('supervisorInfo').classList.toggle('d-none');
            document.getElementById('editSupervisorForm').classList.toggle('d-none');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
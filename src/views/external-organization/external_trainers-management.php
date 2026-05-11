<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إدارة المدرب - EduServe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <?php require_once '../src/views/layout/header.php'; ?>

    <div class="container my-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-person-badge-fill ms-1 text-primary"></i>
                    إدارة المدرب المسؤول
                </h4>
                <p class="text-muted mb-0">عرض بيانات المدرب الحالي وتعيين الطلاب الجدد له.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold mb-0">بيانات المدرب</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($trainer): ?>
                            <div class="text-center mb-4">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-person fs-1"></i>
                                </div>
                                <h5 class="fw-bold"><?= htmlspecialchars($trainer['name']) ?></h5>
                                <span class="badge bg-info text-dark"><?= htmlspecialchars($trainer['specialization']) ?></span>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <span class="text-muted"><i class="bi bi-envelope ms-2"></i>البريد:</span>
                                    <span class="fw-medium"><?= htmlspecialchars($trainer['email']) ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <span class="text-muted"><i class="bi bi-telephone ms-2"></i>الهاتف:</span>
                                    <span class="fw-medium"><?= htmlspecialchars($trainer['phone'] ?? '---') ?></span>
                                </li>
                            </ul>
                            <button class="btn btn-outline-warning w-100 mt-4" onclick="showEditForm()">
                                <i class="bi bi-pencil-square ms-1"></i> تعديل بيانات المدرب
                            </button>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-muted">لا يوجد مدرب مسجل حالياً.</p>
                                <button class="btn btn-primary" onclick="showAddForm()">إضافة مدرب</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-4 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold mb-0">توزيع الطلاب على المدرب</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($trainer): ?>
                            <form method="POST" action="/assign-student">
                                <input type="hidden" name="trainer_id" value="<?= $trainer['id'] ?>">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small uppercase">اختيار الطلاب الجدد</label>
                                    <select class="form-select form-select-lg" name="student_id" required>
                                        <option value="">اختر الطالب لربطه بهذا المدرب...</option>
                                        <?php foreach ($availableStudents as $student): ?>
                                            <option value="<?= $student['id'] ?>"><?= htmlspecialchars($student['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (empty($availableStudents)): ?>
                                        <div class="form-text text-success">
                                            <i class="bi bi-check-all"></i> تم تعيين جميع الطلاب المقبولين بنجاح.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg w-100" <?= empty($availableStudents) ? 'disabled' : '' ?>>
                                    <i class="bi bi-plus-circle ms-1"></i> تعيين الطالب للمدرب
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning border-0">
                                يرجى إضافة بيانات المدرب أولاً لتتمكن من توزيع الطلاب عليه.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4 border-0 d-none" id="editTrainerCard">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">تحديث بيانات المدرب</h5>
                <form action="/update-trainer" method="POST">
                    <input type="hidden" name="trainer_id" value="<?= $trainer['id'] ?? '' ?>">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">الاسم</label>
                            <input type="text" class="form-control" name="name" value="<?= $trainer['name'] ?? '' ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">البريد</label>
                            <input type="email" class="form-control" name="email" value="<?= $trainer['email'] ?? '' ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">التخصص</label>
                            <input type="text" class="form-control" name="specialization" value="<?= $trainer['specialization'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                        <button type="button" class="btn btn-light border" onclick="hideEditForm()">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showEditForm() {
            document.getElementById('editTrainerCard').classList.remove('d-none');
            window.scrollTo(0, document.body.scrollHeight);
        }
        function hideEditForm() {
            document.getElementById('editTrainerCard').classList.add('d-none');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
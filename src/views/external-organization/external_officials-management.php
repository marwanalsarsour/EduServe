<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إدارة المسؤولين</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="container my-4">
        <!-- العنوان -->
        <div class="card shadow-sm border-1 mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-people-fill ms-1"></i>
                        إدارة مسؤولين
                    </h4>
                    <p class="text-muted mb-0">
                        إدارة حسابات المسؤولين داخل المؤسسة وتوزيع الطلاب عليهم.
                    </p>
                </div>
                <button class="btn btn-success" onclick="showSupervisorForm()">
                    <i class="bi bi-person-plus ms-1"></i>
                    إضافة مسؤول
                </button>
            </div>
        </div>

        <!-- توزيع الطلاب -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-diagram-3 ms-1"></i>
                    توزيع الطلاب على المسؤولين
                </h5>
                <form method="POST" action="/assign-volunteer">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">اختيار الطالب</label>
                            <select class="form-select" name="student_id" required>
                                <option value="">اختر الطالب</option>
                                <option value="1">أحمد محمد</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">اختيار المسؤول</label>
                            <select class="form-select" name="supervisor_id" required>
                                <option value="">اختر المسؤول</option>
                                <option value="1">عمر اسماعيل</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle ms-1"></i>
                            تعيين الطالب
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- إضافة / تعديل مسؤول -->
        <div class="card shadow-sm mb-4 d-none" id="supervisorFormCard">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="fw-bold" id="supervisorFormTitle">إضافة مسؤول</h5>
                    <button class="btn btn-sm btn-outline-danger" onclick="hideSupervisorForm()">إغلاق</button>
                </div>
                <form id="supervisorForm">
                    <input type="hidden" name="supervisor_id" id="supervisorId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">اسم المسؤول</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">المجال / النشاط</label>
                            <input type="text" class="form-control" name="field">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">حفظ</button>
                        <button type="button" class="btn btn-secondary" onclick="hideSupervisorForm()">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- جدول المسؤولين -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>المسؤول</th>
                                <th>البريد</th>
                                <th>رقم الهاتف</th>
                                <th>المجال</th>
                                <th>عدد الطلاب</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>

                        <tbody id="supervisorsTable">
                            <tr data-id="1">
                                <td>1</td>
                                <td>عمر اسماعيل</td>
                                <td>volunteer@example.com</td>
                                <td>0598888888</td>
                                <td>أنشطة مجتمعية</td>
                                <td>7</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-warning" onclick="editSupervisor(this)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="openDeleteModal(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- رسالة لتاكيد الحذف -->
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">تأكيد الحذف</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد من حذف هذا المسؤول؟
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button class="btn btn-danger" id="confirmDelete">حذف</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
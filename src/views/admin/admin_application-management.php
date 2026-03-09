<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الطلبات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/EduServe/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="flex-grow-1">
        <div class="container my-4">

            <!-- العنوان -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1">
                            <i class="bi bi-file-earmark-text ms-1"></i>
                            إدارة الطلبات
                        </h4>
                        <p class="text-muted mb-0">عرض وإدارة جميع الطلبات المقدمة من الطلاب</p>
                    </div>
                    <button class="btn btn-primary" onclick="showAddForm()">
                        <i class="bi bi-plus-lg ms-1"></i>
                        إضافة طلب
                    </button>
                </div>
            </div>

            <!-- البحث -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="بحث برقم الجامعي..." id="searchApplication">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">كل الحالات</option>
                                <option value="pending">قيد المراجعة</option>
                                <option value="approved">مقبول</option>
                                <option value="rejected">مرفوض</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary w-100">
                                <i class="bi bi-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card إضافة/تعديل الطلب -->
            <div class="card shadow-sm mb-4 d-none" id="applicationFormCard">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0" id="formTitle"> إضافة طلب </h5>
                        <button class="btn btn-sm btn-outline-danger" onclick="hideForm()">
                            <i class="bi bi-x"></i> إغلاق
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">اسم الطالب</label>
                            <input type="text" class="form-control" id="studentNameInput">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الرقم الجامعي</label>
                            <input type="text" class="form-control" id="studentIdInput">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الفرصة</label>
                            <input type="text" class="form-control" id="opportunityInput">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ التقديم</label>
                            <input type="date" class="form-control" id="applicationDateInput">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" id="applicationStatusInput">
                                <option value="pending">قيد المراجعة</option>
                                <option value="approved">مقبول</option>
                                <option value="rejected">مرفوض</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-success" id="saveApplicationBtn"> حفظ </button>
                        <button class="btn btn-secondary" onclick="hideForm()"> إلغاء </button>
                    </div>
                </div>
            </div>

            <!-- جدول الطلبات -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الطالب</th>
                                    <th>رقم الجامعي</th>
                                    <th>الفرصة</th>
                                    <th>تاريخ التقديم</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="applicationsTable">
                                <!-- مثال للتوضيح -->
                                <tr>
                                    <td>1</td>
                                    <td>أحمد محمد</td>
                                    <td>201234</td>
                                    <td>فرصة تدريبية</td>
                                    <td>2026-03-07</td>
                                    <td><span class="badge bg-warning">قيد المراجعة</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewApplicationModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="showEditForm()">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteApplicationModal">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-3 border-top">
                        <nav>
                            <ul class="pagination justify-content-center mb-0" id="pagination">
                                <li class="page-item">
                                    <button class="page-link" onclick="changePage(currentPage-1)">السابق</button>
                                </li>
                                <span id="pagesContainer" class="d-flex"></span>
                                <li class="page-item">
                                    <button class="page-link" onclick="changePage(currentPage+1)">التالي</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal عرض الطلب -->
    <div class="modal fade" id="viewApplicationModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">معلومات الطلب</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>الاسم:</strong> أحمد محمد</p>
                    <p><strong>الرقم الجامعي:</strong> 201234</p>
                    <p><strong>الفرصة:</strong> فرصة تدريبية</p>
                    <p><strong>تاريخ التقديم:</strong> 2026-03-07</p>
                    <p><strong>الحالة:</strong> قيد المراجعة</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal حذف الطلب -->
    <div class="modal fade" id="deleteApplicationModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حذف الطلب</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>هل أنت متأكد من حذف هذا الطلب؟</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal"> إلغاء </button>
                    <button class="btn btn-danger" id="deleteApplicationBtn"> حذف </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
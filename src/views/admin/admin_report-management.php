<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إدارة التقارير</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/EduServe/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="flex-grow-1">
        <div class="container my-4">

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-bar-chart ms-1"></i>
                        إدارة التقارير
                    </h4>
                    <p class="text-muted mb-0">تقارير المرفوعة من الطلاب</p>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="بحث برقم الجامعي..."
                                id="searchReports">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary w-100">
                                <i class="bi bi-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الطالب</th>
                                    <th>الرقم الجامعي</th>
                                    <th>عنوان التقرير</th>
                                    <th>تاريخ الإرسال</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="reportsTable">
                                <!-- مثال للتوضيح -->
                                <tr>
                                    <td>1</td>
                                    <td>أحمد محمد</td>
                                    <td>201234</td>
                                    <td>تقرير التدريب الميداني</td>
                                    <td>2026-03-08</td>
                                    <td><span class="badge bg-warning">قيد المراجعة</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#viewReportModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteReportModal">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

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

    <div class="modal fade" id="viewReportModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">معلومات التقرير</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>الاسم:</strong> أحمد محمد</p>
                    <p><strong>الرقم الجامعي:</strong> 201234</p>
                    <p><strong>عنوان التقرير:</strong> تقرير التدريب الميداني</p>
                    <p><strong>تاريخ الإرسال:</strong> 2026-03-08</p>
                    <p><strong>الحالة:</strong> قيد المراجعة</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="downloadReportBtn">
                        <i class="bi bi-download"></i> تنزيل التقرير
                    </button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteReportModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حذف التقرير</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>هل أنت متأكد من حذف هذا التقرير؟</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal"> إلغاء </button>
                    <button class="btn btn-danger" id="deleteReportBtn"> حذف </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الشهادات</title>
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
                <div class="card-body">
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-award ms-1"></i>
                        إدارة الشهادات
                    </h4>
                    <p class="text-muted mb-0">
                        الشهادات الصادرة للطلاب
                    </p>
                </div>
            </div>

            <!-- البحث -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="بحث بالرقم الجامعي..."
                                id="searchCertificates">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary w-100">
                                <i class="bi bi-search"></i>
                                بحث
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جدول الشهادات -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الطالب</th>
                                    <th>الرقم الجامعي</th>
                                    <th>عنوان الشهادة</th>
                                    <th>جهة التدريب</th>
                                    <th>تاريخ الإصدار</th>
                                    <th>الإجراءات</th>
                                </tr>

                            </thead>
                            <tbody id="certificatesTable">
                                <tr>
                                    <td>1</td>
                                    <td>أحمد محمد</td>
                                    <td>201234</td>
                                    <td>شهادة التدريب الميداني</td>
                                    <td>شركة الاتصالات</td>
                                    <td>2026-03-06</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- عرض الشهادة -->
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#viewCertificateModal">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            <!-- حذف الشهادة -->
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteCertificateModal">
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
                                    <button class="page-link" onclick="changePage(currentPage-1)">
                                        السابق
                                    </button>
                                </li>
                                <span id="pagesContainer" class="d-flex"></span>
                                <li class="page-item">
                                    <button class="page-link" onclick="changePage(currentPage+1)">
                                        التالي
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal عرض الشهادة -->
    <div class="modal fade" id="viewCertificateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        معلومات الشهادة
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>الاسم:</strong> أحمد محمد</p>
                    <p><strong>الرقم الجامعي:</strong> 201234</p>
                    <p><strong>عنوان الشهادة:</strong> شهادة التدريب الميداني</p>
                    <p><strong>الجهة:</strong> شركة الاتصالات</p>
                    <p><strong>تاريخ الإصدار:</strong> 2026-03-06</p>
                </div>
                <div class="modal-footer">

                    <!-- تنزيل الشهادة -->
                    <button class="btn btn-success" id="downloadCertificateBtn">
                        <i class="bi bi-download"></i>
                        تنزيل الشهادة
                    </button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        إغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal حذف الشهادة -->
    <div class="modal fade" id="deleteCertificateModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        حذف الشهادة
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>هل أنت متأكد من حذف هذه الشهادة؟</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        إلغاء
                    </button>
                    <button class="btn btn-danger" id="deleteCertificateBtn">
                        حذف
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الحضور</title>
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
                        <i class="bi bi-calendar-check ms-1"></i>
                        إدارة الحضور
                    </h4>
                    <p class="text-muted mb-0">
                        متابعة حضور الطلاب للتدريب
                    </p>
                </div>
            </div>

            <!-- البحث -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="بحث برقم الجامعي..."
                                id="searchStudentId">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="attendanceDate">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary w-100">
                                <i class="bi bi-search"></i>
                                بحث
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جدول الحضور -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الطالب</th>
                                    <th>الرقم الجامعي</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>الساعات</th>
                                </tr>
                            </thead>

                            <tbody id="attendanceTable">
                                <!-- مثال للتوضيح -->
                                <tr>
                                    <td>1</td>
                                    <td>أحمد محمد</td>
                                    <td>201234</td>
                                    <td>2026-03-07</td>
                                    <td>
                                        <span class="badge bg-success">حاضر</span>
                                    </td>
                                    <td>8</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>علي محمود</td>
                                    <td>204567</td>
                                    <td>2026-03-09</td>
                                    <td>
                                        <span class="badge bg-danger">غائب</span>
                                    </td>
                                    <td>0</td>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
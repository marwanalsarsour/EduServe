<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الطلاب</title>
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
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1">
                            <i class="bi bi-people ms-1"></i>
                            إدارة الطلاب
                        </h4>
                        <p class="text-muted mb-0"> عرض وإدارة جميع الطلاب المسجلين في النظام </p>
                    </div>
                    <button class="btn btn-primary" onclick="showAddForm()">
                        <i class="bi bi-person-plus ms-1"></i>
                        إضافة طالب
                    </button>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="ابحث باسم الطالب أو الرقم الجامعي..."
                                id="searchStudent">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterMajor">
                                <option value="">كل التخصصات</option>
                                <option>هندسة الحاسوب</option>
                                <option>تكنولوجيا معلومات</option>
                                <option>علم الحاسوب</option>
                                <option>ذكاء اصطناعي</option>
                                <option>أمن السيبراني</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">كل الحالات</option>
                                <option value="active">نشط</option>
                                <option value="inactive">غير نشط</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary w-100">
                                <i class="bi bi-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card الاضافة و التعديل يظهر تحت card البحث -->
            <div class="card shadow-sm mb-4 d-none" id="studentFormCard">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0" id="formTitle"> إضافة طالب </h5>
                        <button class="btn btn-sm btn-outline-danger" onclick="hideForm()">
                            <i class="bi bi-x"></i>
                            إغلاق
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">اسم الطالب</label>
                            <input type="text" class="form-control" id="studentNameInput">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="studentEmailInput">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الرقم الجامعي</label>
                            <input type="text" class="form-control" id="studentIdInput">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">التخصص</label>
                            <input type="text" class="form-control" id="studentMajorInput">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" id="studentStatusInput">
                                <option value="active">نشط</option>
                                <option value="inactive">غير نشط</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-success" id="saveStudentBtn"> حفظ </button>
                        <button class="btn btn-secondary" onclick="hideForm()"> إلغاء </button>
                    </div>
                </div>
            </div>

            <!-- جدول الطلاب -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الطالب</th>
                                    <th>الرقم الجامعي</th>
                                    <th>التخصص</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTable">
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-person-circle fs-4 text-secondary"></i>
                                            <div>
                                                <div class="fw-semibold">أحمد محمد</div>
                                                <div class="small text-muted">ahmad@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>201234</td>
                                    <td>هندسة الحاسوب</td>
                                    <td>
                                        <span class="badge bg-success"> نشط </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#viewStudentModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="showEditForm()">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteStudentModal">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-person-circle fs-4 text-secondary"></i>
                                            <div>
                                                <div class="fw-semibold"> علي محمود </div>
                                                <div class="small text-muted">ali@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>204567</td>
                                    <td>علم الحاسوب</td>
                                    <td>
                                        <span class="badge bg-secondary"> غير نشط </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#viewStudentModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="showEditForm()">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteStudentModal">
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

    <!-- Modal عرض الطالب -->
    <div class="modal fade" id="viewStudentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">معلومات الطالب</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>الاسم:</strong> أحمد محمد</p>
                    <p><strong>البريد:</strong> ahmad@example.com</p>
                    <p><strong>الرقم الجامعي:</strong> 201234</p>
                    <p><strong>التخصص:</strong> هندسة الحاسوب</p>
                    <p><strong>الحالة:</strong> نشط</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal حذف -->
    <div class="modal fade" id="deleteStudentModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">حذف الطالب</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>هل أنت متأكد من حذف هذا الطالب؟</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal"> إلغاء </button>
                    <button class="btn btn-danger"> حذف </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
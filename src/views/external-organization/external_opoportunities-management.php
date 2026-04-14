<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إدارة الفرص</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="container my-4">
        <!-- العنوان -->
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-briefcase"></i> إدارة الفرص</h4>
                    <p class="text-muted mb-0">إدارة جميع الفرص التي تم نشرها</p>
                </div>
                <a href="external_adding-opportunities.html" class="btn btn-primary">
                    <i class="bi bi-plus-circle ms-1"></i> إضافة فرصة
                </a>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input class="form-control" placeholder="ابحث عن فرصة">
                    </div>
                    <div class="col-md-3 mb-3">
                        <select class="form-select">
                            <option>كل الحالات</option>
                            <option>مفتوحة</option>
                            <option>مغلقة</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100"> بحث
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- عرض / تعديل الفرصة -->
        <div id="opportunityCard" class="card shadow-sm mb-4 d-none">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 id="cardTitle" class="fw-bold"></h5>
                    <button class="btn btn-sm btn-outline-danger" onclick="closeCard()">إغلاق</button>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم الفرصة</label>
                        <input id="fieldTitle" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">عدد المقاعد</label>
                        <input id="fieldSeats" type="number" class="form-control" min="1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">موعد انتهاء التسجيل</label>
                        <input id="fieldDeadline" type="date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الحالة</label>
                        <select id="fieldStatus" class="form-select">
                            <option>مفتوحة</option>
                            <option>مغلقة</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">نوع الفرصة</label>
                        <input id="fieldType" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الموقع</label>
                        <input id="fieldLocation" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">الوصف</label>
                        <textarea id="fieldDescription" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">المتطلبات الأساسية</label>
                        <textarea id="fieldRequirements" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button id="saveEditBtn" class="btn btn-success d-none">
                        <i class="bi bi-save"></i> حفظ التعديل
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>اسم الفرصة</th>
                            <th>عدد المقاعد</th>
                            <th>انتهاء التسجيل</th>
                            <th>الحالة</th>
                            <th>نوع الفرصة</th>
                            <th style="width:160px">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="opportunityTable">
                        <tr>
                            <td>1</td>
                            <td>تدريب تطوير ويب</td>
                            <td>10</td>
                            <td>10/06/2026</td>
                            <td><span class="badge bg-success">مفتوحة</span></td>
                            <td>تدريب ميداني</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm btn-outline-primary viewBtn"><i
                                            class="bi bi-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning editBtn"><i
                                            class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger deleteBtn" data-id="1"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item">
                            <a class="page-link" href="?page=1">السابق</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="?page=1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="?page=2">التالي</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal حذف -->
        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تأكيد الحذف</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">هل أنت متأكد أنك تريد حذف هذه الفرصة؟</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button id="confirmDeleteBtn" class="btn btn-danger">حذف</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
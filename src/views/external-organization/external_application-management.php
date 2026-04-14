<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إدارة طلبات الطلاب</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/src/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once '../layout/header.php'; ?>
    <div class="flex-grow-1">
        <div class="container my-4">
            <div class="card shadow-sm border-1 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-file-earmark-text ms-1"></i>
                        إدارة طلبات الطلاب
                    </h4>
                    <p class="text-muted mb-0">
                        عرض وإدارة جميع الطلبات المقدمة
                    </p>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="row g-3">
                        <form class="d-flex flex-column flex-md-row gap-2" method="GET" action="#">
                            <input type="text" name="search" class="form-control mb-2 h-100"
                                placeholder="بحث باسم الطالب...">
                            <button class="btn btn-outline-primary h-100 w-100">
                                <i class="bi bi-search"></i> بحث
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 d-none" id="viewCard">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold">تفاصيل الطلب</h5>
                        <button class="btn btn-sm btn-outline-danger" onclick="closeView()">
                            إغلاق
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني الجامعي</label>
                            <input id="emailField" name="email" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">التخصص</label>
                            <input id="majorField" name="major" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم التواصل</label>
                            <input id="phoneField" name="phone" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">اسم الطالب</label>
                            <input id="studentNameField" name="student_name" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الفرصة</label>
                            <input id="opportunityField" name="opporyunity" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ التقديم</label>
                            <input id="dateField" name="application_date" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الحالة</label>
                            <input id="statusField" name="status" class="form-control" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label">الدافع</label>
                            <textarea id="motivationField" name="motivation" class="form-control"></textarea>
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">السيرة الذاتية "CV"</label>
                            <input id="cvName" name="cv" class="form-control" readonly>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <a id="downloadCvBtn" name="cv_file" class="btn btn-success w-100" href="" download>
                                <i class="bi bi-download"></i>
                                تحميل
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الطالب</th>
                                    <th>التخصص</th>
                                    <th>الفرصة</th>
                                    <th>تاريخ التقديم</th>
                                    <th>الحالة</th>
                                    <th style="width:180px">الإجراءات</th>
                                </tr>
                            </thead>

                            <tbody id="applictionTable">
                                <tr data-id="1" data-student-id="101" data-opportunity-id="55">
                                    <td>1</td>
                                    <td>أحمد محمد</td>
                                    <td>علم الحاسوب</td>
                                    <td>تدريب ويب</td>
                                    <td>2026-03-07</td>
                                    <td>
                                        <span class="badge bg-warning">قيد المراجعة</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- زر الانتقال للملف الشخصي للطالب -->
                                            <button class="btn btn-sm btn-outline-info portfolioBtn"
                                                data-student-id="101">
                                                <i class="bi bi-person-badge"></i>
                                            </button>
                                            <!-- زر عرض طلب التقديم -->
                                            <button class="btn btn-sm btn-outline-primary viewBtn">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <!-- رسالة تاكيد قبول الطلب مربوط في المودل تاكيد قبول الطلب  -->
                                            <button class="btn btn-sm btn-outline-success approveBtn" data-id="1"
                                                data-action="approve">
                                                <i class="bi bi-check"></i>
                                            </button>
                                            <!-- رسالة تاكيد رفض الطلب مربوط في المودل تاكيد رفض الطلب  -->
                                            <button class="btn btn-sm btn-outline-danger rejectBtn" data-id="1"
                                                data-action="reject">
                                                <i class="bi bi-x"></i>
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
                                    <a class="page-link" href="/applications?page=1">
                                        السابق
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="/applications?page=1">1</a>
                                </li>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="/applications?page=2">
                                        التالي
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- رسالة تاكيد القبول -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">قبول الطلب</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="/applications/approve">
                    <div class="modal-body">
                        <input type="hidden" name="application_id" id="approveApplicationId">
                        <label class="form-label fw-semibold">
                            الرسالة التي سيتم إرسالها:
                        </label>
                        <textarea name="message" class="form-control" rows="6">
                        عزيزي الطالب،
                        يسعدنا إبلاغك بأنه تم قبول طلبك في الفرصة التي تقدمت لها بنجاح.
                        نتمنى لك التوفيق والاستفادة من هذه التجربة، وسيتم التواصل معك قريبًا.
                        مع تمنياتنا لك بالنجاح،
                        </textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            إلغاء
                        </button>
                        <button type="submit" class="btn btn-success">
                            تأكيد القبول
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- رسالة تاكيد الرفض -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">رفض الطلب</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="/applications/reject">
                    <div class="modal-body">
                        <input type="hidden" name="application_id" id="rejectApplicationId">
                        <label class="form-label fw-semibold">
                            سبب الرفض / الرسالة:
                        </label>
                        <textarea name="message" class="form-control" rows="6">
                        عزيزي الطالب،
                        نشكر اهتمامك وتقديمك لهذه الفرصة، ولكن نأسف لإبلاغك بأنه لم يتم قبول طلبك في هذه المرة.
                        نتمنى لك التوفيق في الفرص القادمة.
                        </textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            إلغاء
                        </button>
                        <button type="submit" class="btn btn-danger">
                            تأكيد الرفض
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
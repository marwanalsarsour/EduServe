<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة طلبات الطلاب | EduServe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/public/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">


    <div class="container my-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-text ms-2 text-primary"></i>إدارة طلبات الطلاب</h4>
                <p class="text-muted mb-0">متابعة طلبات المتقدمين لفرص التدريب والتطوع الخاصة بك.</p>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form class="row g-2" method="GET" action="/external/applications">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="بحث باسم الطالب..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> بحث</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm mb-4 d-none" id="viewCard">
            <div class="card-body p-4 border-start border-primary border-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-primary">تفاصيل الطلب المختارة</h5>
                    <button class="btn btn-sm btn-outline-secondary" onclick="closeView()">إغلاق <i class="bi bi-x-lg"></i></button>
                </div>
                <div class="row g-3">
                    <div class="col-md-4"><strong>الطالب:</strong> <span id="det-name"></span></div>
                    <div class="col-md-4"><strong>التخصص:</strong> <span id="det-major"></span></div>
                    <div class="col-md-4"><strong>البريد:</strong> <span id="det-email"></span></div>
                    <div class="col-12"><hr></div>
                    <div class="col-md-12">
                        <label class="fw-bold mb-2">رسالة التقديم (Motivation):</label>
                        <p id="det-motivation" class="p-3 bg-light rounded border small"></p>
                    </div>
                    <div class="col-md-4">
                        <a id="det-cv-link" href="#" class="btn btn-sm btn-success w-100" target="_blank">
                            <i class="bi bi-download"></i> تحميل السيرة الذاتية
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th>#</th>
                            <th>الطالب</th>
                            <th>الفرصة</th>
                            <th>تاريخ التقديم</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($applications)): ?>
                            <tr><td colspan="6" class="py-5 text-muted">لا توجد طلبات حالياً.</td></tr>
                        <?php else: ?>
                            <?php foreach ($applications as $idx => $app): ?>
                            <tr>
                                <td><?= $idx + 1 ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($app['student_name']) ?></td>
                                <td><?= htmlspecialchars($app['opportunity_title']) ?></td>
                                <td><?= date('Y/m/d', strtotime($app['created_at'])) ?></td>
                                <td>
                                    <?php 
                                        $badge = ['pending' => 'bg-warning text-dark', 'accepted' => 'bg-success', 'rejected' => 'bg-danger'];
                                        $text = ['pending' => 'قيد الانتظار', 'accepted' => 'مقبول', 'rejected' => 'مرفوض'];
                                    ?>
                                    <span class="badge <?= $badge[$app['status']] ?>"><?= $text[$app['status']] ?></span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" onclick='showDetails(<?= json_encode($app) ?>)' title="عرض"><i class="bi bi-eye"></i></button>
                                        <?php if ($app['status'] === 'pending'): ?>
                                            <button class="btn btn-sm btn-outline-success" onclick="openModal('approveModal', <?= $app['id'] ?>)"><i class="bi bi-check-lg"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="openModal('rejectModal', <?= $app['id'] ?>)"><i class="bi bi-x-lg"></i></button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="/applications/approve" method="POST" class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">تأكيد قبول الطلب</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="application_id" id="approve_id">
                    <p>سيتم إرسال رسالة القبول التالية للطالب:</p>
                    <textarea name="message" class="form-control" rows="5">عزيزي الطالب، يسعدنا إبلاغك بقبول طلبك. سيتم التواصل معك قريباً لتحديد موعد المقابلة.</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success">تأكيد القبول</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="/applications/reject" method="POST" class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">تأكيد رفض الطلب</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="application_id" id="reject_id">
                    <p>سبب الرفض (سيصل للطالب):</p>
                    <textarea name="message" class="form-control" rows="5" required>نعتذر منك، لم يتم اختيارك لهذه الفرصة حالياً. نتمنى لك التوفيق في فرص أخرى.</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">تراجع</button>
                    <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showDetails(app) {
            document.getElementById('viewCard').classList.remove('d-none');
            document.getElementById('det-name').innerText = app.student_name;
            document.getElementById('det-major').innerText = app.major;
            document.getElementById('det-email').innerText = app.email;
            document.getElementById('det-motivation').innerText = app.motivation || 'لا يوجد نص توضيحي.';
            document.getElementById('det-cv-link').href = '/public/uploads/cv/' + app.cv_path;
            window.scrollTo({ top: 100, behavior: 'smooth' });
        }

        function closeView() {
            document.getElementById('viewCard').classList.add('d-none');
        }

        function openModal(modalId, appId) {
            if (modalId === 'approveModal') document.getElementById('approve_id').value = appId;
            if (modalId === 'rejectModal') document.getElementById('reject_id').value = appId;
            new bootstrap.Modal(document.getElementById(modalId)).show();
        }
    </script>
</body>
</html>
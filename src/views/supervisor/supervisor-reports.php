<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مراجعة التقارير الأسبوعية</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php require_once '../layout/header.php'; ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-file-earmark-text ms-2 text-primary"></i>طلبات مراجعة التقارير</h4>
        <span class="badge bg-danger rounded-pill">4 تقارير جديدة</span>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>الطالب</th>
                        <th>الأسبوع</th>
                        <th>تاريخ الرفع</th>
                        <th>التقرير (PDF)</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>تامر زيدان القاضي</td>
                        <td>الأسبوع الرابع</td>
                        <td>2024/05/12</td>
                        <td><a href="#" class="text-danger border-bottom border-danger text-decoration-none"><i class="bi bi-file-pdf"></i> report_v4.pdf</a></td>
                        <td><span class="badge bg-warning text-dark">قيد الانتظار</span></td>
                        <td>
                            <button class="btn btn-sm btn-success" title="قبول"><i class="bi bi-check-lg"></i></button>
                            <button class="btn btn-sm btn-danger" title="رفض"><i class="bi bi-x-lg"></i></button>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal">ملاحظات</button>
                        </td>
                    </tr>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="feedbackModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">إرسال ملاحظات للطالب</h5>
        <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" rows="4" placeholder="اكتب ملاحظاتك هنا..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">إرسال وتنبيه الطالب</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php require_once VIEW_PATH . '/layout/header.php'; ?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقارير جهات التدريب - EduServe</title>

    <link rel="icon" type="image/png" href="/public/images/logo.png">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
        rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-clipboard-data-fill text-primary"></i>
                تقارير جهات التدريب
            </h3>
            <p class="text-muted mb-0">
                جميع التقارير المرسلة من جهات التدريب للطلاب
            </p>
        </div>
    </div>

    <?php if(!empty($data['reports'])): ?>

        <div class="row">

            <?php foreach($data['reports'] as $report): ?>

                <div class="col-lg-6 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white border-bottom">

                            <div class="d-flex justify-content-between align-items-center">

                                <h6 class="mb-0 fw-bold">
                                    <?= htmlspecialchars($report['student_name']) ?>
                                </h6>

                                <span class="badge bg-primary">
                                    <?= htmlspecialchars($report['company_name']) ?>
                                </span>

                            </div>

                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <span class="text-muted">
                                    فترة التقرير:
                                </span>

                                <strong>
                                    <?= htmlspecialchars($report['period']) ?>
                                </strong>
                            </div>

                            <div class="mb-3">

                                <span class="text-muted d-block mb-1">
                                    التقييم:
                                </span>

                                <div class="text-warning fs-5">

                                    <?php
                                    $rating = (int)$report['rating'];

                                    for($i = 1; $i <= 5; $i++):
                                    ?>
                                        <i class="bi <?= $i <= $rating ? 'bi-star-fill' : 'bi-star' ?>"></i>
                                    <?php endfor; ?>

                                    <span class="text-dark fs-6">
                                        (<?= $rating ?>/5)
                                    </span>

                                </div>

                            </div>

                            <div class="mb-3">

                                <span class="text-muted d-block mb-2">
                                    التقرير:
                                </span>

                                <div class="bg-light p-3 rounded">

                                    <?= nl2br(htmlspecialchars($report['content'])) ?>

                                </div>

                            </div>

                        </div>

                        <div class="card-footer bg-white">

                            <small class="text-muted">
                                <i class="bi bi-calendar-event"></i>
                                <?= date('Y-m-d', strtotime($report['report_date'])) ?>
                            </small>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i class="bi bi-file-earmark-x display-4 text-muted"></i>

                <h5 class="mt-3">
                    لا توجد تقارير حالياً
                </h5>

                <p class="text-muted mb-0">
                    لم تقم جهات التدريب بإرسال أي تقارير بعد.
                </p>

            </div>

        </div>

    <?php endif; ?>
    <hr class="my-5">

<div class="mb-4">

    <h3 class="fw-bold text-success">
        <i class="bi bi-award-fill"></i>
        التقييمات النهائية للشركات
    </h3>

    <p class="text-muted">
        التقييم النهائي المفصل لكل طالب
    </p>

</div>

<?php if(!empty($data['finalEvaluations'])): ?>

<div class="row">

<?php foreach($data['finalEvaluations'] as $evaluation): ?>

<div class="col-lg-6 mb-4">

<div class="card shadow-sm border-0 h-100">

    <div class="card-header bg-success text-white">

        <div class="d-flex justify-content-between">

            <strong>
                <?= htmlspecialchars($evaluation['student_name']) ?>
            </strong>

            <span>
                <?= htmlspecialchars($evaluation['company_name']) ?>
            </span>

        </div>

    </div>

    <div class="card-body">

        <div class="row mb-3">

            <div class="col-6">

                <div class="border rounded p-3 text-center">

                    <small class="text-muted">
                        الساعات المنجزة
                    </small>

                    <h4 class="mb-0 text-primary">
                        <?= $evaluation['totalHours'] ?>
                    </h4>

                </div>

            </div>

            <div class="col-6">

                <div class="border rounded p-3 text-center">

                    <small class="text-muted">
                        المتوسط
                    </small>

                    <h4 class="mb-0 text-success">
                        <?= $evaluation['average_score'] ?>
                    </h4>

                </div>

            </div>

        </div>

        <h6 class="fw-bold mb-3">
            درجات المعايير
        </h6>

        <div class="table-responsive">

            <table class="table table-sm table-bordered">

                <thead class="table-light">

                <tr>
                    <th>المعيار</th>
                    <th width="120">الدرجة</th>
                </tr>

                </thead>

                <tbody>

                <?php foreach($evaluation['scores'] as $score): ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($score['criterionName']) ?>
                    </td>

                    <td class="text-center">

                        <?= $score['score'] ?>

                        /

                        <?= $score['maxScore'] ?>

                    </td>

                </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <?php if(!empty($evaluation['feedback'])): ?>

        <div class="mt-3">

            <h6 class="fw-bold">
                ملاحظات الشركة
            </h6>

            <div class="bg-light p-3 rounded">

                <?= nl2br(htmlspecialchars($evaluation['feedback'])) ?>

            </div>

        </div>

        <?php endif; ?>

    </div>

    <div class="card-footer bg-white">

        <small class="text-muted">

            <i class="bi bi-calendar-event"></i>

            <?= date('Y-m-d', strtotime($evaluation['createdAt'])) ?>

        </small>

    </div>

</div>

</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<div class="card shadow-sm border-0">

    <div class="card-body text-center py-5">

        <i class="bi bi-award display-4 text-muted"></i>

        <h5 class="mt-3">
            لا توجد تقييمات نهائية
        </h5>

    </div>

</div>

<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
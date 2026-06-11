<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>الملف الرقمي للطالب</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="/assets/img/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: white;
        }

        .card {
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div class="card border-0 shadow-sm mb-5 bg-primary text-white">
        <div class="card-body p-4">

            <div class="d-flex align-items-center gap-4">

                <div>
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                         style="width:120px;height:120px;">
                        <i class="bi bi-person-fill text-primary"
                           style="font-size:60px;"></i>
                    </div>
                </div>

                <div>
                    <h3 class="fw-bold">
                        <?= htmlspecialchars($student['fullName']) ?>
                    </h3>

                    <p class="mb-1">
                        <?= htmlspecialchars($student['majorName'] ?? 'طالب') ?>
                    </p>

                    <small>
                        <?= htmlspecialchars($student['email']) ?>
                    </small>
                </div>

            </div>

        </div>
    </div>
    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-award text-primary fs-1"></i>
                    <h2 class="fw-bold mt-3">
                        <?= $certsCount ?>
                    </h2>
                    <p class="text-muted mb-0">
                        عدد الشهادات
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-building text-success fs-1"></i>
                    <h2 class="fw-bold mt-3">
                        <?= $trainingCount ?>
                    </h2>
                    <p class="text-muted mb-0">
                        التدريبات المنجزة
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-heart text-danger fs-1"></i>
                    <h2 class="fw-bold mt-3">
                        <?= $volunteerCount ?>
                    </h2>
                    <p class="text-muted mb-0">
                        الأعمال التطوعية
                    </p>
                </div>
            </div>
        </div>

    </div>
    <div class="mb-4">
        <h3 class="section-title">
            <i class="bi bi-award text-warning"></i>
            الشهادات
        </h3>
    </div>

    <div class="row g-4">

        <?php if(empty($certificates)): ?>

            <div class="col-12">
                <div class="alert alert-info text-center">
                    لا توجد شهادات حتى الآن
                </div>
            </div>

        <?php else: ?>

            <?php foreach($certificates as $cert): ?>

                <div class="col-lg-6">

                    <div class="card shadow-sm border-0 h-100">

                        <div class="card-body">

                            <h5 class="fw-bold">
                                <?= htmlspecialchars($cert['entityName']) ?>
                            </h5>

                            <hr>

                            <p>
                                <strong>تاريخ الإصدار:</strong>
                                <?= date('Y-m-d', strtotime($cert['issueDate'])) ?>
                            </p>

                            <div class="d-flex gap-2">

                                <button
                                    class="btn btn-outline-primary"
                                    onclick="viewCertificate('<?= $cert['FilePath'] ?>')">

                                    <i class="bi bi-eye"></i>
                                    عرض

                                </button>

                                <a
                                    href="<?= $cert['FilePath'] ?>"
                                    download
                                    class="btn btn-primary">

                                    <i class="bi bi-download"></i>
                                    تحميل

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>
    <div class="mt-5 mb-4">
        <h3 class="section-title">
            <i class="bi bi-heart text-danger"></i>
            الأعمال التطوعية
        </h3>
    </div>

    <div class="row g-4">

        <?php if(empty($volunteerWorks)): ?>

            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    لا توجد أعمال تطوعية منجزة
                </div>
            </div>

        <?php else: ?>

            <?php foreach($volunteerWorks as $work): ?>

                <div class="col-lg-6">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <h5 class="fw-bold">
                                <?= htmlspecialchars($work['title']) ?>
                            </h5>

                            <p class="text-muted">
                                <?= htmlspecialchars($work['OrganizationName']) ?>
                            </p>

                            <hr>

                            <p>
                                <strong>عدد الساعات:</strong>
                                <?= $work['hours'] ?>
                            </p>

                            <p class="mb-0">
                                <strong>تاريخ الإنجاز:</strong>
                                <?= date('Y-m-d', strtotime($work['completionDate'])) ?>
                            </p>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>
<div class="mt-5 mb-4">
    <h3 class="section-title">
        <i class="bi bi-building text-success"></i>
        التدريبات المنجزة
    </h3>
</div>

<div class="row g-4">

    <?php if(empty($trainings)): ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                لا توجد تدريبات منجزة حتى الآن
            </div>
        </div>
    <?php else: ?>
        <?php foreach($trainings as $training): ?>
            <div class="col-lg-6">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <h5 class="fw-bold">
                            <?= htmlspecialchars($training['title']) ?>
                        </h5>

                        <p class="text-muted">
                            <?= htmlspecialchars($training['OrganizationName']) ?>
                        </p>

                        <hr>

                        <p>
                            <strong>عدد الساعات:</strong> غير متوفر
                        </p>

                        <p class="mb-0">
                            <strong>تاريخ الإنجاز:</strong>
                            <?= date('Y-m-d', strtotime($training['completionDate'])) ?>
                        </p>

                    </div>

                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

</div>
<div class="modal fade" id="viewCertificateModal" tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    عرض الشهادة
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body p-0 text-center">

                <div id="modalContentArea"></div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

function viewCertificate(fileUrl)
{
    const contentArea =
        document.getElementById('modalContentArea');

    contentArea.innerHTML = '';

    let ext =
        fileUrl.split('.').pop().toLowerCase();

    if(ext === 'pdf')
    {
        contentArea.innerHTML =
            `<iframe src="${fileUrl}"
            width="100%"
            height="700"
            style="border:none;"></iframe>`;
    }
    else
    {
        contentArea.innerHTML =
            `<img src="${fileUrl}"
            class="img-fluid">`;
    }

    new bootstrap.Modal(
        document.getElementById('viewCertificateModal')
    ).show();
}

</script>

</body>
</html>
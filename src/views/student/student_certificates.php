<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>الشهادات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/assets/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card { transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="mb-5 text-start">
            <h4 class="fw-bold mb-2">
                <i class="bi bi-award text-muted" style="font-size:20px;"></i>
                الشهادات
            </h4>
            <p class="text-muted mb-0">
                في هذه الصفحة يتم عرض الشهادات التي حصلت عليها بعد إتمام متطلبات التدريب الميداني أو العمل التطوعي.
            </p>
        </div>

        <div class="row justify-content-start g-4" id="certificatesContainer">
            
            <?php if (empty($certificates)): ?>
                <div id="noCertificates" class="text-center py-5">
                    <i class="bi bi-award text-muted" style="font-size:60px; opacity: 0.3;"></i>
                    <h5 class="mt-4 fw-bold text-muted">لم تحصل على أي شهادة حتى الآن</h5>
                    <p class="text-muted">عند إتمام متطلبات التدريب أو العمل التطوعي ستظهر شهادتك هنا.</p>
                </div>
            <?php else: ?>
                <?php foreach ($certificates as $cert): 
                    
                    $isTraining = ($cert['Type'] == 'Training');
                    $themeColor = $isTraining ? 'primary' : 'success';
                    $badgeText = $isTraining ? 'تدريب ميداني' : 'العمل التطوعي';
                ?>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-<?= $themeColor ?> fs-6"><?= $badgeText ?></span>
                                    <i class="bi bi-award text-warning fs-3"></i>
                                </div>

                                <h5 class="fw-bold mb-3">شهادة إتمام <?= $badgeText ?></h5>

                                <p class="mb-2">
                                    <strong>الشركة/ المؤسسة:</strong> <?= htmlspecialchars($cert['Organization']) ?>
                                </p>

                                <p class="mb-2">
                                    <strong>المجال:</strong> <?= htmlspecialchars($cert['Field']) ?>
                                </p>

                                <p class="mb-2">
                                    <strong>عدد الساعات:</strong> <?= $cert['Hours'] ?> ساعة
                                </p>

                                <p class="mb-4">
                                    <strong>تاريخ الإصدار:</strong> <?= date('Y-m-d', strtotime($cert['IssueDate'])) ?>
                                </p>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-<?= $themeColor ?>"
                                        onclick="viewCertificate('<?= $cert['FilePath'] ?>')">
                                        <i class="bi bi-eye ms-1"></i>
                                        عرض الشهادة
                                    </button>

                                    <a href="<?= $cert['FilePath'] ?>" download class="btn btn-<?= $themeColor ?>">
                                        <i class="bi bi-download ms-1"></i>
                                        تحميل
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>

    <div class="modal fade" id="viewCertificateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">عرض الشهادة</h5>
                    <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center bg-dark">
                    <div id="modalContentArea">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <a id="modalDownloadBtn" href="#" class="btn btn-primary" download>
                        <i class="bi bi-download ms-1"></i> تحميل الشهادة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewCertificate(fileUrl) {
            const contentArea = document.getElementById('modalContentArea');
            const downloadBtn = document.getElementById('modalDownloadBtn');
            const fileExtension = fileUrl.split('.').pop().toLowerCase();
            
            downloadBtn.href = fileUrl;
            contentArea.innerHTML = ''; 

            if (fileExtension === 'pdf') {
                
                contentArea.innerHTML = `<iframe src="${fileUrl}" width="100%" height="600px" style="border:none;"></iframe>`;
            } else {
                
                contentArea.innerHTML = `<img src="${fileUrl}" class="img-fluid p-2" alt="Certificate">`;
            }

            const myModal = new bootstrap.Modal(document.getElementById('viewCertificateModal'));
            myModal.show();
        }
    </script>

</body>
</html>
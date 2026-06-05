<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف الطالب الأكاديمي - EduServe</title>
    <link rel="icon" type="image/png" href="/public/images/logo.png">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">


    <div class="container my-5 flex-grow-1">
        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 text-center p-4 mb-4 rounded-4">
                    <div class="mb-3">
                        <i class="bi bi-person-circle display-1 text-secondary opacity-50"></i>
                    </div>
                    <h4 class="fw-bold"><?= htmlspecialchars($data['student']['name']) ?></h4>
                    <p class="text-muted small">الرقم الجامعي: <?= htmlspecialchars($data['student']['university_id']) ?></p>
                    <span class="badge bg-primary px-3 py-2 rounded-pill"><?= htmlspecialchars($data['student']['major']) ?></span>
                    
                    <div class="mt-4 pt-3 border-top text-start">
                        <h6 class="fw-bold mb-3 small">معلومات التواصل</h6>
                        <p class="small mb-2"><i class="bi bi-envelope ms-2 text-primary"></i><?= htmlspecialchars($data['student']['email']) ?></p>
                        <p class="small mb-0"><i class="bi bi-telephone ms-2 text-primary"></i><?= htmlspecialchars($data['student']['phone']) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4 rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">الملف الرقمي والوثائق (Portfolio)</h5>
                        
                        <div class="mb-4">
                            <label class="text-muted small mb-2">رابط أعمال الطالب / LinkedIn:</label>
                            <a href="<?= htmlspecialchars($data['student']['portfolio_link']) ?>" target="_blank" class="btn btn-outline-primary w-100 text-start rounded-3">
                                <i class="bi bi-linkedin ms-2"></i> زيارة الملف الشخصي المهني
                            </a>
                        </div>

                        <div>
                            <label class="text-muted small mb-2">السجل الأكاديمي الأحدث (PDF):</label>
                            <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                                <i class="bi bi-file-earmark-pdf text-danger fs-2 ms-3"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold small">Academic_Transcript.pdf</div>
                                    <div class="text-muted" style="font-size: 11px;">متوفر للمراجعة والتحميل</div>
                                </div>
                                <a href="/uploads/transcripts/<?= $data['student']['academic_transcript'] ?>" target="_blank" class="btn btn-sm btn-dark rounded-pill px-3">عرض الملف</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 fw-bold border-bottom">
                        <i class="bi bi-clock-history ms-2 text-primary"></i>سجل التقارير الأسبوعية
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php if(!empty($data['student_reports'])): ?>
                                <?php foreach($data['student_reports'] as $report): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <span class="small fw-bold"><?= htmlspecialchars($report['title']) ?></span>
                                    <span class="badge bg-<?= $report['status_color'] ?> rounded-pill px-3">
                                        <?= $report['status'] ?>
                                    </span>
                                </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-center p-4 text-muted small">لا يوجد تقارير مرفوعة بعد.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
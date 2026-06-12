<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الفرص المتاحة</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .opportunity-card { transition: transform 0.2s; border: none; }
        .opportunity-card:hover { transform: translateY(-5px); }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <div class="container my-4 flex-fill">

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">الفرص المتاحة</h3>
                <p class="text-muted mb-0">استكشف فرص التدريب الميداني والعمل التطوعي المتاحة حالياً</p>
            </div>

            <div class="input-group" style="max-width: 420px;">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input id="searchInput" type="text" class="form-control border-start-0" placeholder="ابحث حسب العنوان...">
            </div>
        </div>

        <div class="row g-2 mb-4">
            <div class="col-12 col-md-4">
                <select id="typeFilter" class="form-select shadow-sm">
                    <option value="all" selected>جميع أنواع الفرص</option>
                    <option value="تدريب">تدريب ميداني</option>
                    <option value="تطوع">عمل تطوعي</option>
                </select>
            </div>
        </div>

        <div id="opportunitiesList" class="row g-4">
            <?php if (!empty($opportunities)): ?>
                <?php foreach ($opportunities as $op): 
                    $opType = $op['type'] ?? '';
                    $isTraining = ($opType === 'تدريب');
                    $badgeClass = $isTraining ? 'bg-info text-dark' : 'bg-success text-white';
                    $btnClass = $isTraining ? 'btn-outline-primary' : 'btn-outline-success';
                    
                    $title = htmlspecialchars($op['title'] ?? 'بدون عنوان');
                    $descRaw = $op['description'] ?? 'لا يوجد وصف متاح لهذه الفرصة.';
                    $desc = htmlspecialchars($descRaw);
                    $oppID = $op['opportunityID'] ?? 0;
                    $seats = htmlspecialchars($op['seats'] ?? 0);
                    // جلب اسم المؤسسة من الكويري (OrganizationName)
                    $orgName = htmlspecialchars($op['OrganizationName'] ?? 'جهة غير محددة');
                ?>
                    <div class="col-12 col-md-6 opportunity-item" data-type="<?php echo $opType; ?>">
                        <div class="card h-100 shadow-sm opportunity-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h5 class="card-title op-title fw-bold mb-0"><?php echo $title; ?></h5>
                                    <span class="badge <?php echo $badgeClass; ?> op-type">
                                        <?php echo htmlspecialchars($opType); ?>
                                    </span>
                                </div>

                                <h6 class="text-primary mb-3">عدد المقاعد المتاحة: <?php echo $seats; ?></h6>

                                <div class="small text-muted mb-3">
                                    <span class="op-location me-3 d-block mb-1">
                                        <i class="bi bi-building me-1"></i><?php echo $orgName; ?>
                                    </span>
                                    <span class="op-status">
                                        <i class="bi bi-info-circle me-1"></i>الحالة: <?php echo htmlspecialchars($op['status'] ?? 'نشط'); ?>
                                    </span>
                                </div>

                                <p class="op-desc text-secondary mb-4">
                                    <?php 
                                        echo (mb_strlen($desc) > 120) ? mb_substr($desc, 0, 120) . '...' : $desc; 
                                    ?>
                                </p>

                                <div class="mt-auto">
                                    <a href="/student_opportunity-details?id=<?php echo $oppID; ?>" class="btn <?php echo $btnClass; ?> btn-sm w-100">
                                        عرض التفاصيل والتقديم
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-info-circle display-4 text-muted"></i>
                    <p class="lead text-muted mt-3">لا توجد فرص متاحة في الوقت الحالي.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="mt-5 py-3 bg-primary text-white text-center">
        <div class="container">
            <small>© 2026 EduServe - جامعة بوليتكنك فلسطين</small>
        </div>
    </footer>

    <script>
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const items = document.querySelectorAll('.opportunity-item');

        function filterOpportunities() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedType = typeFilter.value;

            items.forEach(item => {
                const title = item.querySelector('.op-title').textContent.toLowerCase();
                const type = item.getAttribute('data-type');

                const matchesSearch = title.includes(searchTerm);
                const matchesType = (selectedType === 'all' || type === selectedType);

                if (matchesSearch && matchesType) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterOpportunities);
        typeFilter.addEventListener('change', filterOpportunities);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
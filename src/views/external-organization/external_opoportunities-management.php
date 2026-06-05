<?php 
require_once VIEW_PATH . '/layout/header.php'; 
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الفرص | EduServe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .form-label { fw-bold;color: dimgray; }
        .card-header-custom { background: white; border-bottom: 2px solid blue; }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">


    <div class="container my-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-briefcase-fill ms-2"></i>إدارة الفرص المنشورة</h4>
                    <a href="/external/opportunities/add" class="btn btn-primary"><i class="bi bi-plus-lg"></i> إضافة فرصة جديدة</a>
                </div>
                <form class="row g-2" method="GET">
                    <div class="col-md-9">
                        <input type="text" name="search" class="form-control" placeholder="بحث عن فرصة بالاسم..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-outline-primary w-100">بحث</button>
                    </div>
                </form>
            </div>
        </div>

        <form id="opportunityCard" action="/external/opportunities/update" method="POST" class="card shadow-sm mb-4 d-none border-0 overflow-hidden">
            <div class="card-header card-header-custom d-flex justify-content-between align-items-center p-3">
                <h5 id="cardTitle" class="mb-0 fw-bold"></h5>
                <button type="button" class="btn-close" onclick="closeCard()"></button>
            </div>
            <div class="card-body p-4">
                <input type="hidden" name="id" id="fieldId">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">اسم الفرصة</label><input name="title" id="fieldTitle" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">عدد المقاعد</label><input name="seats" id="fieldSeats" type="number" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">الموعد النهائي</label><input name="deadline" id="fieldDeadline" type="date" class="form-control" required></div>
                    <div class="col-md-4">
                        <label class="form-label">الحالة</label>
                        <select name="status" id="fieldStatus" class="form-select">
                            <option value="open">مفتوحة</option>
                            <option value="closed">مغلقة</option>
                        </select>
                    </div>
                    <div class="col-md-4"><label class="form-label">النوع (مثلاً: تدريب ميداني)</label><input name="type" id="fieldType" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">الموقع</label><input name="location" id="fieldLocation" class="form-control"></div>
                    <div class="col-12"><label class="form-label">الوصف التفصيلي</label><textarea name="description" id="fieldDescription" class="form-control" rows="3"></textarea></div>
                    <div class="col-12"><label class="form-label">المتطلبات الأساسية</label><textarea name="requirements" id="fieldRequirements" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="mt-4" id="saveContainer">
                    <button type="submit" class="btn btn-success px-4"><i class="bi bi-save"></i> حفظ التعديلات</button>
                </div>
            </div>
        </form>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>الفرصة</th>
                            <th>المقاعد</th>
                            <th>الموعد</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($opportunities)): ?>
                            <tr><td colspan="6" class="py-4 text-muted">لم تقم بنشر أي فرص بعد أو لا توجد نتائج للبحث.</td></tr>
                        <?php else: ?>
                            <?php foreach ($opportunities as $idx => $opp): ?>
                            <tr>
                                <td><?= $idx + 1 ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($opp['title']) ?></td>
                                <td><?= $opp['seats'] ?></td>
                                <td><?= date('Y-m-d', strtotime($opp['deadline'])) ?></td>
                                <td>
                                    <span class="badge <?= $opp['status'] == 'open' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $opp['status'] == 'open' ? 'مفتوحة' : 'مغلقة' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" onclick='fillCard(<?= json_encode($opp) ?>, false)' title="عرض"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-outline-warning" onclick='fillCard(<?= json_encode($opp) ?>, true)' title="تعديل"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?= $opp['id'] ?>)" title="حذف"><i class="bi bi-trash"></i></button>
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

    <form action="/external/opportunities/delete" method="POST" class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">تأكيد الحذف</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="mb-0">هل أنت متأكد من حذف هذه الفرصة؟<br><small class="text-muted">لا يمكن التراجع عن هذا الإجراء.</small></p>
                    <input type="hidden" name="id" id="deleteId">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger px-4">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function fillCard(opp, editable) {
            const card = document.getElementById('opportunityCard');
            card.classList.remove('d-none');
            
            document.getElementById('fieldId').value = opp.id;
            document.getElementById('fieldTitle').value = opp.title;
            document.getElementById('fieldSeats').value = opp.seats;
            document.getElementById('fieldDeadline').value = opp.deadline;
            document.getElementById('fieldStatus').value = opp.status;
            document.getElementById('fieldType').value = opp.type;
            document.getElementById('fieldLocation').value = opp.location;
            document.getElementById('fieldDescription').value = opp.description;
            document.getElementById('fieldRequirements').value = opp.requirements;


            const inputs = card.querySelectorAll('input, textarea, select');
            inputs.forEach(el => { if(el.id !== 'fieldId') el.readOnly = !editable; if(el.tagName === 'SELECT') el.disabled = !editable; });
            
            document.getElementById('saveContainer').classList.toggle('d-none', !editable);
            document.getElementById('cardTitle').innerText = editable ? "تعديل الفرصة" : "تفاصيل الفرصة";
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function closeCard() { document.getElementById('opportunityCard').classList.add('d-none'); }

        function confirmDelete(id) {
            document.getElementById('deleteId').value = id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
</body>
</html>
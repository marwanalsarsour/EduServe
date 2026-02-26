<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقديم طلب</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <main class="flex-grow-1">
        <div class="container my-4">

            <div class="mb-3">
                <a id="backToDetails" href="opportunity-details.html?id=101" class="text-decoration-none">
                    <i class="bi bi-arrow-right"></i> العودة 
                </a>
            </div>

            <div class="row g-4 justify-content-center">

                <div class="col-12 col-lg-8">

                    <div class="card shadow-sm mb-3">
                        <div class="card-body p-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                                <div>
                                    <h4 class="fw-bold mb-1" id="opTitle">التقديم للفرصة</h4>
                                    <p class="text-muted mb-0">
                                        <span id="opOrg">اسم المؤسسة</span>
                                        <span class="mx-2">•</span>
                                        <span id="opLocation">الموقع</span>
                                        <span class="mx-2">•</span>
                                        <span id="opDuration">المدة</span>
                                    </p>
                                </div>

                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge bg-info" id="opType">النوع</span>
                                    <span class="badge bg-info" id="opStatus">الحالة</span>
                                </div>
                            </div>

                            <div id="closedAlert" class="alert alert-danger mt-3 mb-0 d-none">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                هذه الفرصة مغلقة. لا يمكنك التقديم في الوقت الحالي.
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">نموذج التقديم</h5>

                            <form id="applyForm" enctype="multipart/form-data">

                                <input type="hidden" name="opportunity_id" id="opportunityId" value="">

                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">البريد الإلكتروني الجامعي</label>
                                        <input type="email" class="form-control" name="student_email"
                                            placeholder=" number@ppu.edu.ps" required>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label">التخصص</label>
                                        <input type="text" class="form-control" name="major"
                                            placeholder="مثال: هندسة أنظمة حاسوب" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">رقم التواصل</label>
                                        <input type="tel" class="form-control" name="phone" placeholder="+970..."
                                            required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">لماذا تتقدم لهذه الفرصة؟</label>
                                        <textarea class="form-control" name="motivation" rows="4"
                                            placeholder="اكتب نبذة قصيرة عن دوافعك..." required></textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">رفع السيرة الذاتية (CV)</label>
                                        <input type="file" class="form-control" name="cv_file" accept=".pdf,.doc,.docx">
                                        <div class="form-text">الملفات المسموحة: PDF, DOC, DOCX</div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button id="submitBtn" type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-1"></i> إرسال الطلب
                                    </button>

                                    <button type="reset" class="btn btn-outline-secondary">
                                        إلغاء
                                    </button>
                                </div>

                                <div id="successMsg" class="alert mt-3 d-none" role="alert">
                                    <i id="formMsgIcon" class="bi me-1"></i>
                                    <span id="formMsgText">تمت العملية بنجاح.</span>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
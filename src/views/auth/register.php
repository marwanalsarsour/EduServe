<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد - EduServe</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body class="login-bg text-end">

    <div class="login-overlay">
        <div class="container py-5">
            <div class="text-center mb-4 text-white">
                <img src="/images/logo.png" alt="EduServe Logo" style="width: 120px;" class="mb-2">
                <h2 class="fw-bold mb-0">EduServe</h2>
                <p class="small opacity-75">جامعة بوليتكنك فلسطين</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-5">
                    <div class="card login-card shadow-lg">
                        <div class="card-body p-4 p-md-5">
                            <h4 class="text-center fw-bold mb-4">إنشاء حساب جديد</h4>

                            <form action="/register_process.php" method="POST" id="mainRegisterForm">
                                <div class="mb-3">
                                    <label class="small fw-bold mb-1">الاسم الكامل (رباعي)</label>
                                    <input type="text" name="fullname" class="form-control" placeholder="أدخل اسمك الكامل" required>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold mb-1">البريد الإلكتروني</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@domain.com" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="small fw-bold mb-1">كلمة المرور</label>
                                        <input type="password" name="password" class="form-control" placeholder="********" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="small fw-bold mb-1">رقم الهاتف</label>
                                        <input type="text" name="phoneNumber" class="form-control" placeholder="059xxxxxxx" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="small fw-bold mb-1">نوع الحساب (الرتبة)</label>
                                    <select name="role" id="roleSelect" class="form-select text-dark" required>
                                        <option value="" selected disabled>اختر دورك في النظام...</option>
                                        <option value="student">طالب (متدرب/متطوع)</option>
                                        <option value="academic_supervisor">مشرف أكاديمي (جامعة)</option>
                                        <option value="external_entity">جهة خارجية (مؤسسة/شركة)</option>
                                        <option value="college_admin">إدارة الكلية</option>
                                    </select>
                                </div>

                                <div id="extraFieldsContainer"></div>

                                <button type="submit" class="btn btn-danger w-100 fw-bold py-2 shadow-sm rounded-pill">إنشاء الحساب</button>

                                <div class="text-center pt-3 border-top border-white-20 mt-3">
                                    <span class="small opacity-75">لديك حساب بالفعل؟</span>
                                    <a href="login.php" class="text-white fw-bold text-decoration-none small ms-1">تسجيل الدخول</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-dark" id="modal_student" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="fw-bold text-danger mb-0">بيانات الطالب</h5>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold mb-2">التخصص الأكاديمي</label>
                        <input type="text" id="input_majorName" class="form-control" placeholder="مثال: هندسة أنظمة حاسوب">
                    </div>
                    <div class="mb-0">
                        <label class="small fw-bold mb-2">السنة الدراسية</label>
                        <select id="input_academicYear" class="form-select">
                            <option value="1">السنة الأولى</option>
                            <option value="2">السنة الثانية</option>
                            <option value="3">السنة الثالثة</option>
                            <option value="4">السنة الرابعة</option>
                            <option value="5">السنة الخامسة</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-dark w-100 rounded-pill" onclick="saveExtraData('student')">حفظ واكمال</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-dark" id="modal_academic_supervisor" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="fw-bold text-danger mb-0">إشراف أكاديمي</h5>
                </div>
                <div class="modal-body p-4">
                    <label class="small fw-bold mb-3 d-block">نطاق الإشراف (يمكنك اختيار الاثنين):</label>
                    <div class="d-flex gap-4 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="training" id="checkTraining">
                            <label class="form-check-label ms-2" for="checkTraining">تدريب ميداني</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="volunteering" id="checkVolunteering">
                            <label class="form-check-label ms-2" for="checkVolunteering">تطوع</label>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="small fw-bold mb-2">اسم القسم</label>
                        <input type="text" id="input_deptName_sup" class="form-control" placeholder="مثال: قسم تكنولوجيا المعلومات">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-dark w-100 rounded-pill" onclick="saveExtraData('academic_supervisor')">حفظ واكمال</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-dark" id="modal_external_entity" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 text-end">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="fw-bold text-danger mb-0">بيانات المؤسسة</h5>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small mb-1 fw-bold">اسم الجهة المستضيفة</label>
                        <input type="text" id="input_entityName" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 fw-bold">الموقع</label>
                        <input type="text" id="input_location" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="small mb-1 fw-bold">اسم المسؤول</label>
                            <input type="text" id="input_empName" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="small mb-1 fw-bold">ايميل المسؤول</label>
                            <input type="email" id="input_empEmail" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-dark w-100 rounded-pill" onclick="saveExtraData('external_entity')">حفظ واكمال</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-dark" id="modal_college_admin" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered text-end">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="fw-bold text-danger mb-0">إدارة الكلية</h5>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small mb-1 fw-bold">اسم المسؤول</label>
                        <input type="text" id="input_adminName" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 fw-bold">المسمى الوظيفي</label>
                        <input type="text" id="input_adminPosition" class="form-control">
                    </div>
                    <div class="mb-0">
                        <label class="small mb-1 fw-bold">اسم القسم</label>
                        <input type="text" id="input_deptName_admin" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-dark w-100 rounded-pill" onclick="saveExtraData('college_admin')">حفظ واكمال</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const roleSelect = document.getElementById('roleSelect');
        const extraFieldsContainer = document.getElementById('extraFieldsContainer');

        roleSelect.addEventListener('change', function() {
            const role = this.value;
            let modalId = '';
            if (role === 'student') modalId = 'modal_student';
            else if (role === 'academic_supervisor') modalId = 'modal_academic_supervisor';
            else if (role === 'external_entity') modalId = 'modal_external_entity';
            else if (role === 'college_admin') modalId = 'modal_college_admin';

            if (modalId) {
                const myModal = new bootstrap.Modal(document.getElementById(modalId));
                myModal.show();
            }
        });

        function saveExtraData(role) {
            extraFieldsContainer.innerHTML = ''; 

            if (role === 'student') {
                createHiddenInput('majorName', document.getElementById('input_majorName').value);
                createHiddenInput('academicYear', document.getElementById('input_academicYear').value);
                closeModal('modal_student');
            } 
            else if (role === 'academic_supervisor') {
                const isTraining = document.getElementById('checkTraining').checked;
                const isVolunteering = document.getElementById('checkVolunteering').checked;
                if (!isTraining && !isVolunteering) { alert("يرجى اختيار تخصص واحد!"); return; }
                if (isTraining) createHiddenInput('supervision_type[]', 'training');
                if (isVolunteering) createHiddenInput('supervision_type[]', 'volunteering');
                createHiddenInput('departmentName', document.getElementById('input_deptName_sup').value);
                closeModal('modal_academic_supervisor');
            }
            else if (role === 'external_entity') {
                createHiddenInput('entityName', document.getElementById('input_entityName').value);
                createHiddenInput('location', document.getElementById('input_location').value);
                createHiddenInput('employeeName', document.getElementById('input_empName').value);
                createHiddenInput('employeeEmail', document.getElementById('input_empEmail').value);
                closeModal('modal_external_entity');
            }
            else if (role === 'college_admin') {
                createHiddenInput('adminName', document.getElementById('input_adminName').value);
                createHiddenInput('adminPosition', document.getElementById('input_adminPosition').value);
                createHiddenInput('departmentName', document.getElementById('input_deptName_admin').value);
                closeModal('modal_college_admin');
            }
        }

        function createHiddenInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            extraFieldsContainer.appendChild(input);
        }

        function closeModal(id) {
            bootstrap.Modal.getInstance(document.getElementById(id)).hide();
        }
    </script>
</body>
</html>
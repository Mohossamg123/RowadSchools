<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>طلب تسجيل طالب جديد</title>
</head>

<body style="margin:0; padding:0; background-color:#FCFAF8; font-family:'Tahoma','Segoe UI',Arial,sans-serif; color:#1F1528;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#FCFAF8; padding:40px 12px;">
<tr>
<td align="center">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
       style="max-width:600px; background:#FFFFFF; border-radius:20px; overflow:hidden; box-shadow:0 4px 24px rgba(76,21,121,0.08);">

  <!-- Logo -->
<tr>
    <td align="center" style="padding:40px 24px 24px 24px;">
        <img
            src="https://backend.rowadschool.com/storage/images/rowad-alnjah-logo.png"
            alt="مدارس رواد النجاح الأهلية"
            width="144"
            style="display:block; width:144px; max-width:144px; height:auto; margin:0 auto; border:0;"
        >
    </td>
</tr>

    <!-- Gold hairline -->
    <tr>
        <td style="padding:0 24px;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="height:2px; line-height:2px; font-size:2px; background:#DBAF39;">
                        &nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Heading -->
    <tr>
        <td align="center" style="padding:28px 24px 4px 24px; direction:rtl;">
            <div style="font-size:22px; font-weight:700; color:#4B1579;">
                طلب تسجيل طالب جديد
            </div>

            <div style="font-size:14px; color:#6C5B7B; margin-top:8px;">
                تم استلام طلب تسجيل جديد عبر الموقع الإلكتروني
            </div>
        </td>
    </tr>

    <!-- Registration ID -->
    <tr>
        <td align="center" style="padding:20px 24px 8px 24px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="background:#F3EDF7; border-radius:999px; padding:8px 22px; direction:rtl;">

                        <span style="font-size:12px; color:#6C5B7B;">
                            رقم الطلب
                        </span>

                        <span style="font-size:14px; font-weight:700; color:#4B1579; direction:ltr; display:inline-block; margin-right:6px;">
                            #{{ $registration->id }}
                        </span>

                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Student Information -->
    <tr>
        <td style="padding:28px 24px 8px 24px;">

            <div style="font-size:14px; font-weight:700; color:#4B1579; margin-bottom:12px; letter-spacing:0.3px; text-align:right; direction:rtl;">
                بيانات الطالب وولي الأمر
            </div>

            <!--
                dir="ltr" هنا متعمد حتى نضمن ترتيب الخلايا:
                القيمة ← ثم العنوان
                وبالتالي العنوان يظهر في اليمين والقيمة في الشمال
            -->
            <table
                role="presentation"
                width="100%"
                cellpadding="0"
                cellspacing="0"
                border="0"
                dir="ltr"
                style="border:1px solid #E6E2E9; border-radius:14px; overflow:hidden;"
            >

                <!-- Student Name -->
                <tr>

                    <!-- Value -->
                    <td
                        width="62%"
                        dir="rtl"
                        style="padding:14px 16px; font-size:14px; color:#1F1528; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                    >
                        {{ $registration->student_name }}
                    </td>

                    <!-- Label -->
                    <td
                        width="38%"
                        dir="rtl"
                        style="background:#F9F7FB; padding:14px 16px; font-size:13px; font-weight:700; color:#4B1579; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                    >
                        اسم الطالب
                    </td>

                </tr>

                <!-- Parent Name -->
                <tr>

                    <!-- Value -->
                    <td
                        dir="rtl"
                        style="padding:14px 16px; font-size:14px; color:#1F1528; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                    >
                        {{ $registration->parent_name }}
                    </td>

                    <!-- Label -->
                    <td
                        dir="rtl"
                        style="background:#F9F7FB; padding:14px 16px; font-size:13px; font-weight:700; color:#4B1579; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                    >
                        ولي الأمر
                    </td>

                </tr>

                <!-- Phone -->
                <tr>

                    <!-- Value -->
                    <td
                        dir="ltr"
                        style="padding:14px 16px; font-size:14px; color:#1F1528; text-align:right; direction:ltr; border-bottom:1px solid #E6E2E9;"
                    >
                        {{ $registration->phone }}
                    </td>

                    <!-- Label -->
                    <td
                        dir="rtl"
                        style="background:#F9F7FB; padding:14px 16px; font-size:13px; font-weight:700; color:#4B1579; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                    >
                        رقم الجوال
                    </td>

                </tr>

                <!-- Email -->
                <tr>

                    <!-- Value -->
                    <td
                        dir="ltr"
                        style="padding:14px 16px; font-size:14px; color:#1F1528; text-align:right; direction:ltr; word-break:break-word; border-bottom:1px solid #E6E2E9;"
                    >
                        <a
                            href="mailto:{{ $registration->email }}"
                            style="color:#1266D6; text-decoration:underline;"
                        >
                            {{ $registration->email }}
                        </a>
                    </td>

                    <!-- Label -->
                    <td
                        dir="rtl"
                        style="background:#F9F7FB; padding:14px 16px; font-size:13px; font-weight:700; color:#4B1579; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                    >
                        البريد الإلكتروني
                    </td>

                </tr>

                <!-- Gender -->
                <tr>

                    <!-- Value -->
                    <td
                        dir="rtl"
                        style="padding:14px 16px; font-size:14px; color:#1F1528; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                    >
                        @if($registration->gender === 'male')
                            ذكر
                        @elseif($registration->gender === 'female')
                            أنثى
                        @else
                            {{ $registration->gender }}
                        @endif
                    </td>

                    <!-- Label -->
                    <td
                        dir="rtl"
                        style="background:#F9F7FB; padding:14px 16px; font-size:13px; font-weight:700; color:#4B1579; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                    >
                        الجنس
                    </td>

                </tr>

                <!-- Educational Stage -->
                @if($registration->educationalStage)
                    <tr>

                        <!-- Value -->
                        <td
                            dir="rtl"
                            style="padding:14px 16px; font-size:14px; color:#1F1528; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                        >
                            {{ $registration->educationalStage->name }}
                        </td>

                        <!-- Label -->
                        <td
                            dir="rtl"
                            style="background:#F9F7FB; padding:14px 16px; font-size:13px; font-weight:700; color:#4B1579; text-align:right; direction:rtl; border-bottom:1px solid #E6E2E9;"
                        >
                            المرحلة التعليمية
                        </td>

                    </tr>
                @endif

                <!-- Grade -->
                @if($registration->grade)
                    <tr>

                        <!-- Value -->
                        <td
                            dir="rtl"
                            style="padding:14px 16px; font-size:14px; color:#1F1528; text-align:right; direction:rtl;"
                        >
                            {{ $registration->grade->name }}
                        </td>

                        <!-- Label -->
                        <td
                            dir="rtl"
                            style="background:#F9F7FB; padding:14px 16px; font-size:13px; font-weight:700; color:#4B1579; text-align:right; direction:rtl;"
                        >
                            الصف الدراسي
                        </td>

                    </tr>
                @endif

            </table>

        </td>
    </tr>



    <!-- Divider -->
    <tr>
        <td style="padding:28px 24px 0 24px;">

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="height:1px; line-height:1px; font-size:1px; background:#E6E2E9;">
                        &nbsp;
                    </td>
                </tr>
            </table>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td align="center" style="padding:24px 24px 36px 24px; direction:rtl;">

            <div style="font-size:14px; font-weight:700; color:#4B1579;">
                مدارس رواد النجاح الأهلية
            </div>

            <div style="font-size:12px; color:#6C5B7B; margin-top:8px; line-height:1.8;">
                تم إرسال هذا البريد تلقائيًا من نظام التسجيل الإلكتروني.<br>
                يرجى مراجعة بيانات الطلب واتخاذ الإجراء المناسب.
            </div>

            <div style="margin-top:16px; font-size:11px; color:#9A8CA8;">
                © {{ date('Y') }} مدارس رواد النجاح الأهلية
            </div>

        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
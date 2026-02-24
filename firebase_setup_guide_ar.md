# دليل إعداد Firebase في مشاريع Laravel (FCM & Realtime)

هذا الدليل يلخص الخطوات الأساسية لربط مشروع Laravel بـ Firebase لإرسال الإشعارات (Push Notifications) أو استخدام الـ Realtime Database.

---

### 1. من داخل Firebase Console (موقع جوجل)
هذه أهم خطوة للحصول على ملف "تصريح الدخول":
1. أدخل على [Firebase Console](https://console.firebase.google.com/).
2. أنشئ مشروعاً جديداً (أو اختر مشروعك الحالي).
3. اضغط على أيقونة **الترس (Settings)** بجانب "Project Overview" ثم اختر **Project Settings**.
4. انتقل إلى تبويب **Service Accounts**.
5. اضغط على زر **Generate new private key**.
6. سيتم تحميل ملف بصيغة `.json`. هذا الملف هو "مفتاح" سيرفرك للدخول على Firebase.
   * **تنبيه:** لا ترفع هذا الملف أبداً على GitHub (أضفه لملف `.gitignore`).

---

### 2. إعدادات المشروع (Laravel)
بعد تحميل الملف، اتبع الخطوات التالية في الكود:

#### أ. وضع الملف في المشروع:
ضع ملف الـ JSON اللي حملته في المجلد الرئيسي للمشروع (Root).

#### ب. تحديث ملف الـ `.env`:
أضف السطور التالية لربط المكتبة بالملف:
```env
# اسم ملف الـ JSON اللي حملته
FIREBASE_CREDENTIALS=اسم_الملف_بتاعك.json

# (اختياري) لو هتستخدم الـ Realtime Database
FIREBASE_DATABASE_URL=https://your-project-id.firebaseio.com
```

#### ج. تثبيت المكتبة (لو مشروع جديد):
نستخدم المكتبة الأكثر استقراراً لـ Laravel:
```bash
composer require kreait/laravel-firebase
```

#### د. نشر ملف الإعدادات (Config):
عشان تقدر تتحكم في إعدادات Firebase من داخل `config/firebase.php`:
```bash
php artisan vendor:publish --provider="Kreait\Laravel\Firebase\ServiceProvider" --tag=config
```

---

### 3. تفعيل الخدمات في Firebase
بدون هذه الخطوات، لارافل سيعطيك "Success" لكن الإشعار لن يصل:
1. **Cloud Messaging:** في إعدادات المشروع (Project Settings)، اذهب لتبويب **Cloud Messaging** وتأكد أن "Firebase Cloud Messaging API (V1)" مفعل (Enabled).
2. **Realtime Database:** لو هتستخدم التتبع اللحظي، ادخل على قسم **Realtime Database** في القائمة الجانبية واضغط **Create Database** واختار الموقع (بفضل القريب منك).

---

### 4. كود الإرسال السريع (مثال)
بمجرد عمل الإعدادات، تقدر تبعت إشعار بأبسط شكل كدا:

```php
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;

$messaging = Firebase::messaging();
$message = CloudMessage::fromArray([
    'token' => 'FCM_TOKEN_HERE',
    'notification' => [
        'title' => 'عنوان الإشعار',
        'body' => 'محتوى الرسالة'
    ],
]);

$messaging->send($message);
```

---

---

### 5. هيكلية الملفات المطلوبة (Project Structure)
لضمان نظام إشعارات احترافي، يفضل تقسيم الكود على هذه الملفات:

| نوع الملف | المسار (Path) | الوظيفة |
| :--- | :--- | :--- |
| **Model** | `app/Models/UserFcmToken.php` | تخزين الـ FCM Tokens الخاصة بكل مستخدم وأجهزته. |
| **Service** | `app/Service/FcmService.php` | العقل المدبر: يقرر من سيستلم الإشعار ويقوم بتوزيع المهام. |
| **Job** | `app/Jobs/SendFcmNotificationJob.php` | المسؤول عن الإرسال الفعلي لـ Firebase في الخلفية (Queue). |
| **Controller** | `app/Http/Controllers/API/NotificationController.php` | API للعميل لعرض قائمة إشعاراته السابقة. |
| **Resource** | `app/Http/Resources/API/NotificationResource.php` | تنسيق شكل البيانات الراجع للموبايل (JSON). |
| **Observer** | `app/Observers/OrderObserver.php` | (مثال) يراقب تغير حالة الأوردر ويطلق الإشعار أوتوماتيكياً. |

---

### 6. تسلسل الملفات عند حدوث طلب (Detailed Request Flow)
إليك ما يحدث بالتفصيل من لحظة ضغط العميل على "إتمام الطلب" حتى وصول الإشعار:

1. **`routes/api.php`**: العميل يرسل طلب إنشاء أوردر.
2. **`OrderController.php`**: يتم استلام الطلب وتمريره للخدمة.
3. **`OrderService.php`**: ينفذ منطق العمل (Business Logic) ويحفظ الأوردر في الداتابيز.
4. **`OrderObserver.php`**: بمجرد حفظ الأوردر، يكتشف الـ Observer الحدث ويستدعي الـ `FcmService`.
5. **`FcmService.php`**: يبحث عن كل الـ `FCM Tokens` الخاصة بالمستخدم ويقوم بتوزيعها على الـ `Jobs`.
6. **`SendFcmNotificationJob.php`**: يتم وضع المهمة في الـ `Queue` لتعمل في الخلفية (عشان العميل ما يستناش).
7. **`Firebase SDK`**: المهمة (Job) تستخدم ملف الـ JSON للاتصال بـ Google وإرسال الإشعار.
8. **جهاز العميل**: استلام الإشعار في ثوانٍ معدودة.

---

### 7. استكشاف الأخطاء وإصلاحها (Troubleshooting)
* **مشكلة "File not found":** تأكد من أن اسم الملف في `.env` مطابق تماماً لاسم ملف الـ JSON في المجلد الرئيسي.
* **مشكلة "Unauthorized":** تأكد من تفعيل "Cloud Messaging API" في كونسول Firebase.
* **الإشعارات لا تصل:** تأكد من تشغيل الـ Queue (`php artisan queue:work`) ومن أن التوكن (FCM Token) الخاص بالموبايل صحيح وحديث.

---

**تم إعداد هذا الدليل ليكون مرجعاً كاملاً لك وللفريق لضمان توحيد العمل.** 🚀

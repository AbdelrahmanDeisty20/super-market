# دليل إعداد التتبع اللحظي (Real-time Tracking) باستخدام Laravel Reverb

هذا الدليل يشرح كيفية عمل نظام التتبع اللحظي في مشروعك، سواء لتحديث حالة الطلب أو تتبع موقع المندوب على الخريطة (GPS).

---

### 1. المتطلبات الأساسية (Server Setup)
النظام يعتمد على **Laravel Reverb** (محرك WebSockets). للتشغيل:
1. تأكد من وجود إعدادات Reverb في ملف `.env` (App ID, Key, Secret).
2. تشغيل سيرفر البث في الخلفية:
   ```bash
   php artisan reverb:start
   ```
3. (في الإنتاج) يجب التأكد من ضبط `BROADCAST_CONNECTION=reverb`.

---

### 2. هيكلية الملفات (Project Structure)

| نوع الملف | المسار (Path) | الوظيفة |
| :--- | :--- | :--- |
| **Event** | `app/Events/OrderStatusUpdated.php` | يحمل بيانات حالة الطلب الجديدة لإرسالها للعميل. |
| **Event** | `app/Events/DriverLocationUpdated.php` | يحمل إحداثيات المندوب (Lat/Long) لبثها لحظياً. |
| **Controller** | `app/Http/Controllers/API/DriverController.php` | يستقبل "Ping" الموقع من المندوب ويطلق حدث البث. |
| **Observer** | `app/Observers/OrderObserver.php` | يراقب تغير الحالة في الداتابيز ويطلق حدث البث أوتوماتيكياً. |
| **Route** | `routes/api.php` | يحتوي على رابط تحديث الموقع للمندوب. |
| **Channel** | `routes/channels.php` | حارس الأمن: يحدد من يملك صلاحية دخول قناة تتبع الأوردر. |

---

### 3. تسلسل الملفات عند التتبع (GPS Flow)
إليك ما يحدث من لحظة تحرك المندوب حتى ظهور حركته عند العميل:

1. **المندوب (Mobile App)**: يرسل الموقع كل 5 ثوانٍ لـ `API/DriverController`.
2. **`DriverController.php`**: يحدث الموقع في جدول `orders` ويطلق حدث `DriverLocationUpdated`.
3. **`DriverLocationUpdated.php`**: الحدث يحدد القناة الخاصة بالأوردر (`orders.{id}`) ويرسل الإحداثيات.
4. **`channels.php`**: يتأكد أن اللي بيسمع القناة هو صاحب الأوردر فقط.
5. **العميل (Frontend)**: يستلم الإحداثيات عبر **Laravel Echo** ويحرك الماركر على الخريطة فوراً بدون ريفريش.

---

### 4. تسلسل تحديث حالة الطلب (Status Flow)
1. **الأدمن (Dashboard)**: يغير الحالة من "قيد التنفيذ" إلى "تم الشحن".
2. **`OrderObserver.php`**: يكتشف التغيير ويطلق حدث `OrderStatusUpdated`.
3. **`OrderStatusUpdated.php`**: يرسل الحالة الجديدة والرسالة المترجمة للعميل.
4. **العميل (Frontend)**: تتغير حالة الطلب في الواجهة أمام عينه فوراً.

### 5. نقطة البداية (The Initial State)
بما أن الـ WebSockets ترسل التحديثات "أثناء" حدوثها، يحتاج العميل لمعرفة "أين المندوب الآن؟" عند فتح الصفحة لأول مرة.
لذلك أضفنا هذا الـ API:
*   **Method:** `GET`
*   **URL:** `/api/orders/{orderId}/tracking`
*   **النتيجة:** يرجع لك الـ `status` وآخر `lat` و `long` متسجلين في الداتابيز.

---

### 6. كيفية الاستماع من الفرونت إند (Frontend Listening)
المطور يحتاج فقط لفتح قناة استماع (Subscription):
```javascript
Echo.private(`orders.${orderId}`)
    .listen('DriverLocationUpdated', (data) => {
        // تحريك المندوب: data.lat, data.long
    })
    .listen('OrderStatusUpdated', (data) => {
        // تحديث الحالة: data.status, data.message
    });
```

---

### 6. استكشاف الأخطاء (Troubleshooting)
* **مشكلة "Connection Refused":** تأكد من تشغيل `php artisan reverb:start`.
* **مشكلة "403 Forbidden":** تأكد أن اليوزر مسجل دخول وأنه هو صاحب الأوردر (راجع `channels.php`).
* **البيانات لا تظهر:** تأكد أن الـ Event ينفذ واجهة `ShouldBroadcast`.

---

**تم إعداد هذا الدليل لضمان احترافية العمل وتسهيل الربط مع فريق الموبايل والفرونت إند.** 🚀

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معمل تتبع الشحنات (Real-time Lab)</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS (Map) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #map {
            height: 500px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .control-panel {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            height: 100%;
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 5px 12px;
            border-radius: 20px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold">معمل تتبع الشحنة رقم #{{ $order->id }} 🚀</h2>
                <p class="text-muted">نظام محاكاة حركة المندوب الفعلي (Data Persistence + Private Channels)</p>
                <div class="alert alert-info d-inline-block">
                    👤 العميل المستهدف: <strong>{{ $order->user->name }}</strong> (يجب أن يكون الـ Socket مفعل له)
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- لوحة التحكم (محاكاة المندوب) -->
            <div class="col-md-4">
                <div class="control-panel border shadow-sm">
                    <h5 class="mb-4 text-primary">📱 لوحة تحكم المندوب (Driver)</h5>

                    <input type="hidden" id="order_id" value="{{ $order->id }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold">خط العرض (Latitude)</label>
                        <input type="number" id="lat" class="form-control"
                            value="{{ $order->last_lat ?? 30.0444 }}" step="0.0001">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">خط الطول (Longitude)</label>
                        <input type="number" id="lng" class="form-control"
                            value="{{ $order->last_long ?? 31.2357 }}" step="0.0001">
                    </div>

                    <div class="d-grid gap-2">
                        <button id="sendBtn" class="btn btn-primary btn-lg shadow-sm">إرسال وتحديث الداتابيز</button>
                        <button id="autoMoveBtn" class="btn btn-outline-success">بدء تحرك تلقائي (LIVE)</button>
                        <button id="stopBtn" class="btn btn-outline-danger d-none">إيقاف التحرك</button>
                    </div>

                    <hr>
                    <div class="mt-3">
                        <p class="mb-1 fw-bold text-secondary small">حالة الاتصال (Private Channel):</p>
                        <span id="socketStatus" class="status-badge bg-secondary text-white">جاري الاتصال...</span>
                    </div>

                    <div class="mt-3 p-3 bg-white border rounded">
                        <h6>💡 معلومة تقنية:</h6>
                        <p class="small text-muted mb-0">هذا الزر يقوم بتحديث حقول <code>last_lat</code> و
                            <code>last_long</code> في جدول <code>orders</code> للأوردر رقم 6، ثم يبعث الحدث عبر Reverb.
                        </p>
                    </div>
                </div>
            </div>

            <!-- الخريطة (شاشة العميل) -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div
                        class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="mb-0">🗺️ شاشة تتبع العميل (Private Order Channel)</h5>
                        <span id="lastUpdate" class="badge bg-light text-dark border">في انتظار البيانات...</span>
                    </div>
                    <div class="card-body p-0">
                        <div id="map"></div>
                    </div>
                    <div class="card-footer bg-light py-2 px-3 small text-muted">
                        الوضع الحالي: قناة خاصة <code>orders.{{ $order->id }}</code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.3.0/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Loaded. Lab for Order #{{ $order->id }}');

            // 1. إعداد الخريطة
            const initialPos = [{{ $order->last_lat ?? 30.0444 }}, {{ $order->last_long ?? 31.2357 }}];
            const map = L.map('map').setView(initialPos, 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            const driverIcon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/854/854878.png',
                iconSize: [40, 40],
                iconAnchor: [20, 20]
            });

            let driverMarker = L.marker(initialPos, {
                icon: driverIcon
            }).addTo(map).bindPopup('الموقع الحالي للمندوب').openPopup();

            // 2. إعدادات Reverb
            const reverbConfig = {
                key: '{{ config('broadcasting.connections.reverb.key') }}',
                host: '{{ config('broadcasting.connections.reverb.options.host') }}',
                port: {{ config('broadcasting.connections.reverb.options.port', 8080) }},
                scheme: '{{ config('broadcasting.connections.reverb.options.scheme', 'http') }}'
            };

            // محاكاة تسجيل الدخول لليوزر صاحب الأوردر (Authentication Simulation)
            // في العادي العميل بيكون مسجل دخول بـ Cookie أو Token والـ Echo بيفهم ده
            window.Pusher = Pusher;
            const echo = new Echo({
                broadcaster: 'reverb',
                key: reverbConfig.key,
                wsHost: reverbConfig.host || window.location.hostname,
                wsPort: reverbConfig.port,
                wssPort: reverbConfig.port,
                forceTLS: reverbConfig.scheme === 'https',
                enabledTransports: ['ws', 'wss'],
                // ملاحظة: بما أننا في Blade وبنفتح الصفحة من المتصفح مباشرة،
                // الـ Echo هيستخدم الـ Session الموجودة في Laravel لعمل Auth للقناة الخاصة
            });

            // مراقبة حالة الاتصال
            if (echo.connector && echo.connector.pusher) {
                echo.connector.pusher.connection.bind('state_change', function(states) {
                    const badge = $('#socketStatus');
                    badge.text(states.current);
                    if (states.current === 'connected') badge.removeClass('bg-secondary bg-danger')
                        .addClass('bg-success');
                    else if (states.current === 'unavailable' || states.current === 'failed') badge
                        .removeClass('bg-success bg-secondary').addClass('bg-danger');
                });
            }

            // 3. الاستماع للقناة الخاصة بالأوردر (Production Logic)
            const orderId = {{ $order->id }};
            echo.private(`orders.${orderId}`)
                .listen('.App\\Events\\DriverLocationUpdated', (data) => {
                    console.log('Real Location Received (Private):', data);
                    const newPos = [data.lat, data.long];

                    driverMarker.setLatLng(newPos);
                    map.panTo(newPos);

                    $('#lastUpdate').text('تحديث لحظي من السيرفر: ' + new Date().toLocaleTimeString());

                    // مزامنة لوحة التحكم (اختياري)
                    $('#lat').val(data.lat);
                    $('#lng').val(data.long);
                })
                .error((err) => {
                    console.error('Private Channel Auth Error:', err);
                    $('#socketStatus').text('خطأ في تصريح القناة (Auth Error)').addClass('bg-danger');
                });

            // 4. وظائف الإرسال
            $('#sendBtn').click(function() {
                const lat = $('#lat').val();
                const lng = $('#lng').val();
                const order_id = $('#order_id').val();

                $(this).prop('disabled', true).text('جاري الإرسال...');

                $.post('/test/tracking/update', {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    lat: lat,
                    lng: lng
                }).done(function() {
                    console.log('Order Updated & Broadcast Sent!');
                }).always(function() {
                    $('#sendBtn').prop('disabled', false).text('إرسال وتحديث الداتابيز');
                });
            });

            let moveInterval;
            $('#autoMoveBtn').click(function() {
                $(this).addClass('d-none');
                $('#stopBtn').removeClass('d-none');

                moveInterval = setInterval(() => {
                    let currentLat = parseFloat($('#lat').val());
                    let currentLng = parseFloat($('#lng').val());

                    $('#lat').val((currentLat + 0.0001).toFixed(6));
                    $('#lng').val((currentLng + 0.0001).toFixed(6));

                    $('#sendBtn').click();
                }, 4000);
            });

            $('#stopBtn').click(function() {
                $(this).addClass('d-none');
                $('#autoMoveBtn').removeClass('d-none');
                clearInterval(moveInterval);
            });
        });
    </script>

</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('Email Verified') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4F46E5;
            --success: #10B981;
            --bg: #F8FAFC;
        }
        body { 
            font-family: 'Inter', 'Outfit', sans-serif; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0; 
            background: radial-gradient(circle at top right, #EEF2FF 0%, #F8FAFC 100%);
        }
        .card { 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(12px);
            padding: 3rem 2rem; 
            border-radius: 2rem; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            text-align: center; 
            max-width: 440px; 
            width: 90%; 
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .icon-wrapper {
            width: 80px;
            height: 80px;
            background: #ECFDF5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .icon { font-size: 2.5rem; color: var(--success); }
        h1 { 
            color: #1E293B; 
            margin: 0 0 1rem; 
            font-weight: 700;
            font-size: 1.875rem;
            letter-spacing: -0.025em;
        }
        p { 
            color: #64748B; 
            line-height: 1.6; 
            font-size: 1.125rem;
            margin-bottom: 2rem;
        }
        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.75rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
            filter: brightness(1.1);
        }
        @keyframes scaleIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        [dir="rtl"] body { font-family: 'Outfit', 'Inter', sans-serif; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrapper">
            <div class="icon">✓</div>
        </div>
        <h1>{{ $title ?? __('Email Verified!') }}</h1>
        <p>{{ $message ?? __('Your email has been successfully verified. You can now close this window and return to the app.') }}</p>
        <!-- <a href="#" class="btn">{{ __('Back to App') }}</a> -->
    </div>
</body>
</html>

{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Enterprise') }} | Secure Login</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-blue: #00d4ff;
            --primary-violet: #b829dd;
            --deep-black: #050508;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-highlight: rgba(255, 255, 255, 0.15);
            --neon-glow-blue: 0 0 20px rgba(0, 212, 255, 0.5), 0 0 40px rgba(0, 212, 255, 0.3), 0 0 60px rgba(0, 212, 255, 0.1);
            --neon-glow-violet: 0 0 20px rgba(184, 41, 221, 0.4), 0 0 40px rgba(184, 41, 221, 0.2);
            --depth-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotateX(0deg); }
            50% { transform: translateY(-20px) rotateX(2deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        @keyframes glowPulse {
            0%, 100% { box-shadow: var(--neon-glow-blue); }
            50% { box-shadow: 0 0 30px rgba(0, 212, 255, 0.8), 0 0 60px rgba(0, 212, 255, 0.5), 0 0 90px rgba(0, 212, 255, 0.3); }
        }

        @keyframes rotate3d {
            0% { transform: rotateY(0deg) rotateX(0deg); }
            25% { transform: rotateY(5deg) rotateX(5deg); }
            50% { transform: rotateY(0deg) rotateX(0deg); }
            75% { transform: rotateY(-5deg) rotateX(5deg); }
            100% { transform: rotateY(0deg) rotateX(0deg); }
        }

        @keyframes particleFloat {
            0%, 100% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        @keyframes lightRay {
            0% { transform: translateX(-100%) rotate(15deg); opacity: 0; }
            50% { opacity: 0.3; }
            100% { transform: translateX(200%) rotate(15deg); opacity: 0; }
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--deep-black);
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 2000px;
        }

        /* Deep layered background */
        .universe {
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(ellipse at 20% 80%, rgba(0, 212, 255, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(184, 41, 221, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(10, 10, 20, 1) 0%, rgba(5, 5, 8, 1) 100%);
            z-index: -3;
        }

        /* Animated gradient mesh */
        .gradient-mesh {
            position: fixed;
            inset: 0;
            background: 
                linear-gradient(135deg, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                linear-gradient(225deg, rgba(184, 41, 221, 0.1) 0%, transparent 50%);
            background-size: 200% 200%;
            animation: gradientShift 15s ease infinite;
            z-index: -2;
        }

        /* Volumetric light rays */
        .light-rays {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: -1;
        }

        .light-ray {
            position: absolute;
            width: 200%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.4), rgba(184, 41, 221, 0.4), transparent);
            filter: blur(20px);
            animation: lightRay 8s ease-in-out infinite;
        }

        .light-ray:nth-child(1) { top: 20%; animation-delay: 0s; }
        .light-ray:nth-child(2) { top: 40%; animation-delay: 2s; }
        .light-ray:nth-child(3) { top: 60%; animation-delay: 4s; }
        .light-ray:nth-child(4) { top: 80%; animation-delay: 6s; }

        /* Floating particles */
        .particles {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(0, 212, 255, 0.6);
            border-radius: 50%;
            box-shadow: 0 0 6px rgba(0, 212, 255, 0.8);
            animation: particleFloat 20s linear infinite;
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; animation-duration: 25s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 5s; animation-duration: 30s; width: 3px; height: 3px; }
        .particle:nth-child(3) { left: 30%; animation-delay: 10s; animation-duration: 22s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 2s; animation-duration: 28s; width: 1px; height: 1px; }
        .particle:nth-child(5) { left: 50%; animation-delay: 7s; animation-duration: 24s; background: rgba(184, 41, 221, 0.6); box-shadow: 0 0 6px rgba(184, 41, 221, 0.8); }
        .particle:nth-child(6) { left: 60%; animation-delay: 12s; animation-duration: 26s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 3s; animation-duration: 32s; width: 2px; height: 2px; background: rgba(184, 41, 221, 0.6); }
        .particle:nth-child(8) { left: 80%; animation-delay: 8s; animation-duration: 20s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 15s; animation-duration: 27s; width: 3px; height: 3px; }

        /* Glass layers behind card */
        .glass-layer {
            position: absolute;
            border-radius: 24px;
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            box-shadow: var(--depth-shadow);
        }

        .glass-layer-1 {
            width: 420px;
            height: 580px;
            transform: translateZ(-100px) rotateY(-5deg);
            opacity: 0.3;
            filter: blur(2px);
        }

        .glass-layer-2 {
            width: 400px;
            height: 560px;
            transform: translateZ(-50px) rotateY(3deg);
            opacity: 0.5;
            filter: blur(1px);
        }

        /* Main container with 3D perspective */
        .login-container {
            position: relative;
            width: 100%;
            max-width: 440px;
            padding: 20px;
            transform-style: preserve-3d;
            animation: rotate3d 20s ease-in-out infinite;
        }

        /* Floating animation wrapper */
        .float-wrapper {
            animation: float 6s ease-in-out infinite;
            transform-style: preserve-3d;
        }

        /* Main glass card */
        .glass-card {
            position: relative;
            background: rgba(20, 20, 30, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-top: 1px solid var(--glass-highlight);
            border-left: 1px solid var(--glass-highlight);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.8),
                inset 0 1px 1px rgba(255, 255, 255, 0.1),
                var(--neon-glow-blue);
            transform-style: preserve-3d;
            overflow: hidden;
        }

        /* Glass reflection effect */
        .glass-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.05) 40%,
                transparent 60%,
                transparent 100%
            );
            border-radius: 24px;
            pointer-events: none;
        }

        /* Inner glow border */
        .glass-card::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 24px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(184, 41, 221, 0.3), transparent);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Logo section */
        .logo-section {
            text-align: center;
            margin-bottom: 40px;
            transform: translateZ(30px);
        }

        .logo-container {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* 3D Logo construction */
        .logo-ring {
            position: absolute;
            border-radius: 50%;
            border: 2px solid transparent;
            background: linear-gradient(var(--deep-black), var(--deep-black)) padding-box,
                        linear-gradient(135deg, var(--primary-blue), var(--primary-violet)) border-box;
            box-shadow: var(--neon-glow-blue);
        }

        .logo-ring-outer {
            width: 80px;
            height: 80px;
            animation: pulse 4s ease-in-out infinite;
        }

        .logo-ring-inner {
            width: 60px;
            height: 60px;
            border-width: 2px;
            animation: pulse 4s ease-in-out infinite reverse;
        }

        .logo-core {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        /* SVG Lock icon */
        .lock-icon {
            width: 20px;
            height: 20px;
            fill: white;
            filter: drop-shadow(0 0 4px rgba(255, 255, 255, 0.8));
        }

        .company-name {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.7) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
        }

        .tagline {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 24px;
            transform: translateZ(20px);
            position: relative;
        }

        .input-wrapper {
            position: relative;
        }

        .input-field {
            width: 100%;
            padding: 16px 20px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .input-field:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1), var(--neon-glow-blue);
            background: rgba(0, 0, 0, 0.5);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            opacity: 0.4;
            transition: opacity 0.3s ease;
        }

        .input-field:focus + .input-icon {
            opacity: 1;
            filter: drop-shadow(0 0 4px var(--primary-blue));
        }

        /* Checkbox styling */
        .remember-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            transform: translateZ(20px);
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .checkbox-input {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            background: rgba(0, 0, 0, 0.3);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .checkbox-input:checked {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            border-color: transparent;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        .checkbox-input:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .checkbox-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            user-select: none;
        }

        .forgot-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--primary-blue);
            transition: width 0.3s ease;
            box-shadow: 0 0 8px var(--primary-blue);
        }

        .forgot-link:hover::after {
            width: 100%;
        }

        /* Submit button */
        .submit-btn {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(184, 41, 221, 0.1));
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            transform: translateZ(40px);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .submit-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(255, 255, 255, 0.1) 50%,
                transparent 70%
            );
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .submit-btn:hover {
            border-color: rgba(0, 212, 255, 0.6);
            box-shadow: var(--neon-glow-blue), 0 10px 30px rgba(0, 0, 0, 0.5);
            transform: translateZ(50px) translateY(-2px);
        }

        .submit-btn:hover::before {
            opacity: 0.2;
        }

        .submit-btn:hover::after {
            animation: shine 0.6s ease;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); opacity: 0; }
        }

        .submit-btn:active {
            transform: translateZ(40px) translateY(0);
        }

        /* Security badges */
        .security-badges {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-top: 32px;
            transform: translateZ(10px);
        }

        .badge {
            display: flex;
            align-items: center;
            gap: 6px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .badge-icon {
            width: 14px;
            height: 14px;
            fill: rgba(0, 212, 255, 0.6);
        }

        /* Error message styling */
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: rgba(239, 68, 68, 0.9);
            font-size: 13px;
            backdrop-filter: blur(10px);
            transform: translateZ(20px);
        }

        /* Status indicator */
        .status-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
            animation: pulse 2s infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .glass-card {
                padding: 36px 24px;
            }
            
            .glass-layer-1, .glass-layer-2 {
                display: none;
            }
            
            .login-container {
                animation: none;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>

    <!-- Deep space background layers -->
    <div class="universe"></div>
    <div class="gradient-mesh"></div>
    
    <!-- Volumetric light rays -->
    <div class="light-rays">
        <div class="light-ray"></div>
        <div class="light-ray"></div>
        <div class="light-ray"></div>
        <div class="light-ray"></div>
    </div>

    <!-- Floating particles -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Main login container -->
    <div class="login-container">
        <div class="glass-layer glass-layer-1"></div>
        <div class="glass-layer glass-layer-2"></div>
        
        <div class="float-wrapper">
            <div class="glass-card">
                <div class="status-indicator"></div>
                
                <!-- Logo Section -->
                <div class="logo-section">
                    <div class="logo-container">
                        <div class="logo-ring logo-ring-outer"></div>
                        <div class="logo-ring logo-ring-inner"></div>
                        <div class="logo-core">
                            <svg class="lock-icon" viewBox="0 0 24 24">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                            </svg>
                        </div>
                    </div>
                    <h1 class="company-name">Nexus</h1>
                    <p class="tagline">Secure Enterprise Access</p>
                </div>

                <!-- Laravel Breeze Compatible Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="error-message">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Email Field -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="input-field" 
                                placeholder="Corporate Email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                autocomplete="username"
                            >
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="input-field" 
                                placeholder="Secure Password" 
                                required
                                autocomplete="current-password"
                            >
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="remember-section">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="remember" id="remember" class="checkbox-input">
                            <span class="checkbox-label">Remember Session</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Forgot Access?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn">
                        Authenticate
                    </button>
                </form>

                <!-- Security Indicators -->
                <div class="security-badges">
                    <div class="badge">
                        <svg class="badge-icon" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        <span>256-bit TLS</span>
                    </div>
                    <div class="badge">
                        <svg class="badge-icon" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span>Verified</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
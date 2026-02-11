{{-- resources/views/admin/command-center.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Nexus') }} | Enterprise Command Center</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-blue: #00d4ff;
            --primary-violet: #b829dd;
            --accent-cyan: #00f0ff;
            --accent-purple: #d946ef;
            --deep-black: #010102;
            --panel-bg: rgba(12, 12, 20, 0.7);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.06);
            --glass-highlight: rgba(255, 255, 255, 0.12);
            --neon-glow-blue: 0 0 30px rgba(0, 212, 255, 0.3), 0 0 60px rgba(0, 212, 255, 0.1);
            --neon-glow-violet: 0 0 30px rgba(184, 41, 221, 0.3), 0 0 60px rgba(184, 41, 221, 0.1);
            --depth-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.9);
            --text-primary: rgba(255, 255, 255, 0.95);
            --text-secondary: rgba(255, 255, 255, 0.65);
            --text-muted: rgba(255, 255, 255, 0.4);
            --success: #00d9a3;
            --warning: #ffb800;
            --danger: #ff4757;
            --info: #00d4ff;
        }

        @keyframes universeShift {
            0%, 100% { 
                background-position: 0% 0%, 100% 100%, 50% 50%; 
            }
            50% { 
                background-position: 100% 100%, 0% 0%, 50% 50%; 
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotateX(0deg); }
            50% { transform: translateY(-15px) rotateX(2deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.4; filter: blur(40px); }
            50% { opacity: 0.8; filter: blur(60px); }
        }

        @keyframes scanline {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100vh); }
        }

        @keyframes dataStream {
            0% { stroke-dashoffset: 1000; opacity: 0; }
            50% { opacity: 1; }
            100% { stroke-dashoffset: 0; opacity: 0; }
        }

        @keyframes hologram {
            0%, 100% { opacity: 0.8; transform: translateY(0); }
            50% { opacity: 1; transform: translateY(-2px); }
        }

        @keyframes particleDrift {
            0%, 100% { 
                transform: translateY(100vh) translateX(0) scale(0); 
                opacity: 0; 
            }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { 
                transform: translateY(-10vh) translateX(20px) scale(1); 
                opacity: 0; 
            }
        }

        @keyframes lightSweep {
            0% { transform: translateX(-150%) rotate(25deg); opacity: 0; }
            50% { opacity: 0.3; }
            100% { transform: translateX(150%) rotate(25deg); opacity: 0; }
        }

        @keyframes borderFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes chartFill {
            0% { height: 0%; opacity: 0; }
            100% { height: var(--fill-height); opacity: 1; }
        }

        @keyframes numberCount {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--deep-black);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.5;
            font-size: 14px;
        }

        /* Deep Universe Background */
        .universe {
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(ellipse at 20% 80%, rgba(0, 212, 255, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(184, 41, 221, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(5, 5, 15, 1) 0%, rgba(1, 1, 2, 1) 100%);
            z-index: -4;
            animation: universeShift 30s ease infinite;
        }

        /* Ambient Glow Orbs */
        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -3;
            animation: pulse-glow 8s ease-in-out infinite;
        }

        .glow-orb-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, transparent 70%);
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .glow-orb-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(184, 41, 221, 0.15) 0%, transparent 70%);
            bottom: -150px;
            right: -100px;
            animation-delay: 4s;
        }

        .glow-orb-3 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 240, 255, 0.1) 0%, transparent 70%);
            top: 40%;
            left: 30%;
            animation-delay: 2s;
        }

        /* Light Rays */
        .light-rays {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: -2;
            pointer-events: none;
        }

        .light-ray {
            position: absolute;
            width: 200%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.4), rgba(184, 41, 221, 0.4), transparent);
            filter: blur(15px);
            animation: lightSweep 12s ease-in-out infinite;
        }

        .light-ray:nth-child(1) { top: 15%; animation-delay: 0s; }
        .light-ray:nth-child(2) { top: 35%; animation-delay: 3s; }
        .light-ray:nth-child(3) { top: 55%; animation-delay: 6s; }
        .light-ray:nth-child(4) { top: 75%; animation-delay: 9s; }

        /* Particle System */
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
            box-shadow: 0 0 8px rgba(0, 212, 255, 0.8);
            animation: particleDrift 20s linear infinite;
        }

        .particle:nth-child(1) { left: 5%; animation-delay: 0s; animation-duration: 25s; }
        .particle:nth-child(2) { left: 15%; animation-delay: 5s; width: 3px; height: 3px; background: rgba(184, 41, 221, 0.6); }
        .particle:nth-child(3) { left: 25%; animation-delay: 10s; animation-duration: 30s; }
        .particle:nth-child(4) { left: 35%; animation-delay: 2s; width: 1px; height: 1px; }
        .particle:nth-child(5) { left: 45%; animation-delay: 8s; background: rgba(0, 240, 255, 0.6); }
        .particle:nth-child(6) { left: 55%; animation-delay: 12s; animation-duration: 22s; }
        .particle:nth-child(7) { left: 65%; animation-delay: 15s; width: 2px; height: 2px; background: rgba(184, 41, 221, 0.6); }
        .particle:nth-child(8) { left: 75%; animation-delay: 3s; animation-duration: 28s; }
        .particle:nth-child(9) { left: 85%; animation-delay: 18s; width: 3px; height: 3px; }
        .particle:nth-child(10) { left: 95%; animation-delay: 7s; animation-duration: 24s; }

        /* Scanline Overlay */
        .scanlines {
            position: fixed;
            inset: 0;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0, 0, 0, 0.03) 2px,
                rgba(0, 0, 0, 0.03) 4px
            );
            z-index: 9999;
            pointer-events: none;
            opacity: 0.4;
        }

        /* Layout Architecture */
        .command-center {
            display: grid;
            grid-template-columns: 300px 1fr;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Glass Morphism Base */
        .glass-panel {
            background: var(--panel-bg);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid var(--glass-border);
            border-top: 1px solid var(--glass-highlight);
            border-left: 1px solid var(--glass-highlight);
            border-radius: 20px;
            box-shadow: var(--depth-shadow);
            position: relative;
            overflow: hidden;
        }

        .glass-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, transparent 40%, transparent 100%);
            border-radius: 20px;
            pointer-events: none;
        }

        .glass-panel::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 20px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(184, 41, 221, 0.3), transparent 60%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Sidebar Navigation */
        .sidebar {
            padding: 40px 28px;
            display: flex;
            flex-direction: column;
            gap: 40px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            border-right: 1px solid var(--glass-border);
        }

        .brand-identity {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 32px;
            border-bottom: 1px solid var(--glass-border);
        }

        .brand-hologram {
            width: 56px;
            height: 56px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            transform-style: preserve-3d;
            animation: float 6s ease-in-out infinite;
        }

        .hologram-ring {
            position: absolute;
            border-radius: 50%;
            border: 2px solid transparent;
            background: linear-gradient(var(--deep-black), var(--deep-black)) padding-box,
                        linear-gradient(135deg, var(--primary-blue), var(--primary-violet)) border-box;
            box-shadow: var(--neon-glow-blue);
        }

        .hologram-ring-outer {
            width: 56px;
            height: 56px;
            animation: pulse-glow 4s ease-in-out infinite;
        }

        .hologram-ring-middle {
            width: 42px;
            height: 42px;
            opacity: 0.7;
        }

        .hologram-core {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            border-radius: 50%;
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .brand-text-group {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.7) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .brand-subtitle {
            font-size: 10px;
            color: var(--text-muted);
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Navigation Structure */
        .nav-section {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-category {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 3px;
            padding: 0 16px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border-radius: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(184, 41, 221, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .nav-item:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(0, 212, 255, 0.2);
            transform: translateX(4px);
        }

        .nav-item:hover::before {
            opacity: 1;
        }

        .nav-item.active {
            color: var(--text-primary);
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.15), rgba(184, 41, 221, 0.15));
            border: 1px solid rgba(0, 212, 255, 0.4);
            box-shadow: var(--neon-glow-blue);
        }

        .nav-item.active::before {
            opacity: 1;
        }

        .nav-icon {
            width: 22px;
            height: 22px;
            fill: currentColor;
            transition: all 0.3s ease;
        }

        .nav-item:hover .nav-icon {
            filter: drop-shadow(0 0 8px currentColor);
            transform: scale(1.1);
        }

        .nav-badge {
            margin-left: auto;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.5);
            animation: hologram 2s ease-in-out infinite;
        }

        /* User Command Profile */
        .commander-profile {
            margin-top: auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 16px;
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            overflow: hidden;
        }

        .commander-profile::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary-blue), var(--primary-violet), transparent);
            animation: borderFlow 3s linear infinite;
            background-size: 200% 200%;
        }

        .commander-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 18px;
            box-shadow: var(--neon-glow-blue);
            position: relative;
            overflow: hidden;
        }

        .commander-avatar::after {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            border-radius: 50%;
            z-index: -1;
            filter: blur(8px);
            opacity: 0.6;
        }

        .commander-info {
            flex: 1;
        }

        .commander-name {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: 0.5px;
        }

        .commander-rank {
            font-size: 11px;
            color: var(--primary-blue);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 2px;
            font-weight: 600;
        }

        .commander-status {
            width: 10px;
            height: 10px;
            background: var(--success);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--success);
            animation: hologram 2s infinite;
        }

        /* Main Operations Area */
        .operations-theater {
            padding: 40px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            overflow-y: auto;
            max-height: 100vh;
        }

        /* Theater Header */
        .theater-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--glass-border);
        }

        .mission-title {
            font-size: 36px;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.8) 50%, rgba(0, 212, 255, 0.9) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
            line-height: 1.2;
        }

        .mission-subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 8px;
            letter-spacing: 1px;
        }

        .theater-controls {
            display: flex;
            gap: 16px;
        }

        .control-btn {
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .control-btn-primary {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.15), rgba(184, 41, 221, 0.15));
            border: 1px solid rgba(0, 212, 255, 0.4);
            color: var(--text-primary);
            box-shadow: var(--neon-glow-blue);
        }

        .control-btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .control-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 40px rgba(0, 212, 255, 0.5);
        }

        .control-btn-primary:hover::before {
            opacity: 0.2;
        }

        .control-btn-secondary {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            color: var(--text-secondary);
        }

        .control-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(0, 212, 255, 0.3);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        /* Strategic Overview Grid */
        .strategic-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .kpi-card {
            padding: 28px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
            transition: all 0.4s ease;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.9), var(--neon-glow-blue);
        }

        .kpi-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .kpi-meta {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .kpi-label {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .kpi-value {
            font-size: 36px;
            font-weight: 800;
            color: var(--text-primary);
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
            animation: numberCount 0.8s ease-out;
        }

        .kpi-delta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.3);
        }

        .kpi-delta.positive {
            color: var(--success);
            border: 1px solid rgba(0, 217, 163, 0.3);
            box-shadow: 0 0 15px rgba(0, 217, 163, 0.2);
        }

        .kpi-delta.negative {
            color: var(--danger);
            border: 1px solid rgba(255, 71, 87, 0.3);
        }

        .kpi-icon-container {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(184, 41, 221, 0.1));
            border: 1px solid rgba(0, 212, 255, 0.2);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.1);
        }

        .kpi-icon-container svg {
            width: 26px;
            height: 26px;
            fill: var(--primary-blue);
            filter: drop-shadow(0 0 8px currentColor);
        }

        .kpi-footer {
            font-size: 12px;
            color: var(--text-muted);
            padding-top: 16px;
            border-top: 1px solid var(--glass-border);
        }

        /* Command Modules Layout */
        .command-modules {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }

        .module-large {
            grid-column: span 2;
        }

        .module-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--glass-border);
        }

        .module-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .module-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(to bottom, var(--primary-blue), var(--primary-violet));
            border-radius: 2px;
            box-shadow: 0 0 10px var(--primary-blue);
        }

        .module-actions {
            display: flex;
            gap: 10px;
        }

        .module-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .module-btn:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.3);
            color: var(--text-primary);
        }

        /* User Management Interface */
        .user-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .user-card {
            padding: 24px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 16px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--primary-violet));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .user-card:hover {
            transform: translateY(-3px);
            border-color: rgba(0, 212, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .user-card:hover::before {
            opacity: 1;
        }

        .user-avatar-large {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 16px;
            box-shadow: var(--neon-glow-blue);
        }

        .user-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .user-role {
            font-size: 12px;
            color: var(--primary-blue);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .user-stats {
            display: flex;
            gap: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--glass-border);
        }

        .user-stat {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .user-stat-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .user-stat-label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Financial Analytics */
        .financial-chart {
            height: 320px;
            position: relative;
        }

        .chart-svg-container {
            width: 100%;
            height: 100%;
        }

        .chart-line {
            fill: none;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
            filter: drop-shadow(0 0 10px currentColor);
        }

        .chart-area {
            fill-opacity: 0.2;
        }

        .chart-grid {
            stroke: rgba(255, 255, 255, 0.05);
            stroke-width: 1;
        }

        /* Data Tables */
        .data-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .data-grid th {
            text-align: left;
            padding: 16px;
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            border-bottom: 1px solid var(--glass-border);
        }

        .data-grid td {
            padding: 20px 16px;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
            font-size: 14px;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .data-grid tr:hover td {
            background: rgba(0, 212, 255, 0.05);
            color: var(--text-primary);
            border-color: rgba(0, 212, 255, 0.2);
        }

        .data-grid td:first-child {
            border-left: 1px solid var(--glass-border);
            border-radius: 12px 0 0 12px;
        }

        .data-grid td:last-child {
            border-right: 1px solid var(--glass-border);
            border-radius: 0 12px 12px 0;
        }

        .entity-cell {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .entity-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 14px;
        }

        .entity-info {
            display: flex;
            flex-direction: column;
        }

        .entity-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .entity-meta {
            font-size: 12px;
            color: var(--text-muted);
        }

        .token-value {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-blue);
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pill::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-pill.active {
            background: rgba(0, 217, 163, 0.1);
            color: var(--success);
            border: 1px solid rgba(0, 217, 163, 0.3);
        }

        .status-pill.active::before {
            background: var(--success);
            box-shadow: 0 0 10px var(--success);
        }

        .status-pill.pending {
            background: rgba(255, 184, 0, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 184, 0, 0.3);
        }

        .status-pill.pending::before {
            background: var(--warning);
            box-shadow: 0 0 10px var(--warning);
            animation: hologram 2s infinite;
        }

        .status-pill.suspended {
            background: rgba(255, 71, 87, 0.1);
            color: var(--danger);
            border: 1px solid rgba(255, 71, 87, 0.3);
        }

        .status-pill.suspended::before {
            background: var(--danger);
        }

        .action-group {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--glass-border);
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.4);
            color: var(--primary-blue);
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Inventory Visualization */
        .inventory-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .inventory-card {
            padding: 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .inventory-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--primary-violet));
            opacity: 0.5;
        }

        .inventory-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 16px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(184, 41, 221, 0.1));
            border: 1px solid rgba(0, 212, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .inventory-icon svg {
            width: 32px;
            height: 32px;
            fill: var(--primary-blue);
            filter: drop-shadow(0 0 8px currentColor);
        }

        .inventory-count {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .inventory-label {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 12px;
        }

        .inventory-bar {
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            overflow: hidden;
            margin-top: 12px;
        }

        .inventory-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-blue), var(--primary-violet));
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
            transition: width 1s ease-out;
        }

        /* Approval Queue */
        .approval-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .approval-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 16px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .approval-item:hover {
            border-color: rgba(0, 212, 255, 0.3);
            transform: translateX(5px);
            background: rgba(0, 212, 255, 0.05);
        }

        .approval-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(255, 184, 0, 0.1), rgba(255, 71, 87, 0.1));
            border: 1px solid rgba(255, 184, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .approval-icon svg {
            width: 24px;
            height: 24px;
            fill: var(--warning);
        }

        .approval-content {
            flex: 1;
        }

        .approval-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .approval-meta {
            font-size: 13px;
            color: var(--text-muted);
        }

        .approval-amount {
            font-family: 'Courier New', monospace;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-blue);
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
            margin-right: 20px;
        }

        .approval-actions {
            display: flex;
            gap: 10px;
        }

        .approval-btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .approval-btn-approve {
            background: linear-gradient(135deg, rgba(0, 217, 163, 0.2), rgba(0, 217, 163, 0.1));
            border: 1px solid rgba(0, 217, 163, 0.4);
            color: var(--success);
        }

        .approval-btn-approve:hover {
            background: rgba(0, 217, 163, 0.3);
            box-shadow: 0 0 20px rgba(0, 217, 163, 0.4);
            transform: translateY(-2px);
        }

        .approval-btn-deny {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            color: var(--text-muted);
        }

        .approval-btn-deny:hover {
            background: rgba(255, 71, 87, 0.1);
            border-color: rgba(255, 71, 87, 0.4);
            color: var(--danger);
        }

        /* Responsive Architecture */
        @media (max-width: 1600px) {
            .strategic-grid { grid-template-columns: repeat(2, 1fr); }
            .command-modules { grid-template-columns: 1fr; }
            .module-large { grid-column: span 1; }
            .user-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 1200px) {
            .command-center { grid-template-columns: 80px 1fr; }
            .sidebar { padding: 20px 12px; }
            .brand-text-group, .nav-category, .commander-info { display: none; }
            .nav-item { justify-content: center; padding: 16px; }
            .nav-icon { margin: 0; }
            .nav-badge { position: absolute; top: 8px; right: 8px; }
        }

        @media (max-width: 768px) {
            .strategic-grid { grid-template-columns: 1fr; }
            .inventory-grid { grid-template-columns: repeat(2, 1fr); }
            .operations-theater { padding: 20px; }
            .theater-header { flex-direction: column; align-items: flex-start; gap: 20px; }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary-blue), var(--primary-violet));
            border-radius: 4px;
            opacity: 0.5;
        }

        ::-webkit-scrollbar-thumb:hover {
            opacity: 1;
            box-shadow: 0 0 10px var(--primary-blue);
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>

    <div class="universe"></div>
    
    <div class="glow-orb glow-orb-1"></div>
    <div class="glow-orb glow-orb-2"></div>
    <div class="glow-orb glow-orb-3"></div>

    <div class="light-rays">
        <div class="light-ray"></div>
        <div class="light-ray"></div>
        <div class="light-ray"></div>
        <div class="light-ray"></div>
    </div>

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
        <div class="particle"></div>
    </div>

    <div class="scanlines"></div>

    <div class="command-center">
        <!-- Sidebar Command -->
        <aside class="sidebar glass-panel">
            <div class="brand-identity">
                <div class="brand-hologram">
                    <div class="hologram-ring hologram-ring-outer"></div>
                    <div class="hologram-ring hologram-ring-middle"></div>
                    <div class="hologram-core">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                </div>
                <div class="brand-text-group">
                    <div class="brand-title">Nexus</div>
                    <div class="brand-subtitle">Enterprise Command</div>
                </div>
            </div>

            <nav class="nav-section">
                <div class="nav-category">Command</div>
                <a href="#" class="nav-item active">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    <span>User Management</span>
                    <span class="nav-badge">12</span>
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.73 1.36 4.73 4.04c-.01 2.04-1.66 3.13-3.67 3.48z"/></svg>
                    <span>Token Control</span>
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    <span>Inventory</span>
                </a>
            </nav>

            <nav class="nav-section">
                <div class="nav-category">Finance</div>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    <span>Allocations</span>
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                    <span>Analytics</span>
                    <span class="nav-badge">3</span>
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    <span>Approvals</span>
                    <span class="nav-badge">8</span>
                </a>
            </nav>

            <div class="commander-profile">
                <div class="commander-avatar">AS</div>
                <div class="commander-info">
                    <div class="commander-name">Alex Sterling</div>
                    <div class="commander-rank">Chief Administrator</div>
                </div>
                <div class="commander-status"></div>
            </div>
        </aside>

        <!-- Main Operations Theater -->
        <main class="operations-theater">
            
            <!-- Theater Header -->
            <header class="theater-header">
                <div>
                    <h1 class="mission-title">Command Center</h1>
                    <p class="mission-subtitle">Centralized governance for user management, token allocation, and financial oversight</p>
                </div>
                <div class="theater-controls">
                    <button class="control-btn control-btn-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                        </svg>
                        System Status
                    </button>
                    <button class="control-btn control-btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                        </svg>
                        Create User
                    </button>
                </div>
            </header>

            <!-- Strategic KPI Grid -->
            <div class="strategic-grid">
                <div class="glass-panel kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-meta">
                            <div class="kpi-label">Total System Tokens</div>
                            <div class="kpi-value">₮ 4.2M</div>
                            <div class="kpi-delta positive">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14l5-5 5 5z"/></svg>
                                +18.4% MoM
                            </div>
                        </div>
                        <div class="kpi-icon-container">
                            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.73 1.36 4.73 4.04c-.01 2.04-1.66 3.13-3.67 3.48z"/></svg>
                        </div>
                    </div>
                    <div class="kpi-footer">Distributed across 8 departments</div>
                </div>

                <div class="glass-panel kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-meta">
                            <div class="kpi-label">Active Personnel</div>
                            <div class="kpi-value">247</div>
                            <div class="kpi-delta positive">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14l5-5 5 5z"/></svg>
                                +12 this week
                            </div>
                        </div>
                        <div class="kpi-icon-container" style="background: linear-gradient(135deg, rgba(0, 217, 163, 0.1), rgba(0, 217, 163, 0.05)); border-color: rgba(0, 217, 163, 0.3);">
                            <svg viewBox="0 0 24 24" fill="#00d9a3"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        </div>
                    </div>
                    <div class="kpi-footer">24 pending onboarding</div>
                </div>

                <div class="glass-panel kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-meta">
                            <div class="kpi-label">Monthly Burn Rate</div>
                            <div class="kpi-value">₮ 485K</div>
                            <div class="kpi-delta negative">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                                -5.2% efficiency
                            </div>
                        </div>
                        <div class="kpi-icon-container" style="background: linear-gradient(135deg, rgba(255, 71, 87, 0.1), rgba(255, 71, 87, 0.05)); border-color: rgba(255, 71, 87, 0.3);">
                            <svg viewBox="0 0 24 24" fill="#ff4757"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                        </div>
                    </div>
                    <div class="kpi-footer">82% of quarterly budget</div>
                </div>

                <div class="glass-panel kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-meta">
                            <div class="kpi-label">Pending Approvals</div>
                            <div class="kpi-value">18</div>
                            <div class="kpi-delta positive" style="color: var(--warning); border-color: rgba(255, 184, 0, 0.3);">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                Action required
                            </div>
                        </div>
                        <div class="kpi-icon-container" style="background: linear-gradient(135deg, rgba(255, 184, 0, 0.1), rgba(255, 184, 0, 0.05)); border-color: rgba(255, 184, 0, 0.3);">
                            <svg viewBox="0 0 24 24" fill="#ffb800"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </div>
                    </div>
                    <div class="kpi-footer">₮ 2.4M total value</div>
                </div>
            </div>

            <!-- Command Modules -->
            <div class="command-modules">
                
                <!-- User Management Module -->
                <div class="glass-panel module-large">
                    <div class="module-header">
                        <div class="module-title">Personnel Management</div>
                        <div class="module-actions">
                            <button class="module-btn">Filter</button>
                            <button class="module-btn">Export</button>
                            <button class="module-btn" style="background: rgba(0, 212, 255, 0.1); color: var(--primary-blue);">+ Add User</button>
                        </div>
                    </div>
                    
                    <table class="data-grid">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Monthly Tokens</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="entity-cell">
                                        <div class="entity-avatar">JD</div>
                                        <div class="entity-info">
                                            <div class="entity-name">John Doe</div>
                                            <div class="entity-meta">john.doe@corp.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Engineering</td>
                                <td>Senior Developer</td>
                                <td class="token-value">₮ 5,000</td>
                                <td><span class="status-pill active">Active</span></td>
                                <td>
                                    <div class="action-group">
                                        <button class="action-btn">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        </button>
                                        <button class="action-btn">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="entity-cell">
                                        <div class="entity-avatar" style="background: linear-gradient(135deg, var(--primary-violet), var(--accent-purple));">SM</div>
                                        <div class="entity-info">
                                            <div class="entity-name">Sarah Mitchell</div>
                                            <div class="entity-meta">sarah.m@corp.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Finance</td>
                                <td>Finance Manager</td>
                                <td class="token-value">₮ 8,000</td>
                                <td><span class="status-pill active">Active</span></td>
                                <td>
                                    <div class="action-group">
                                        <button class="action-btn">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        </button>
                                        <button class="action-btn">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="entity-cell">
                                        <div class="entity-avatar" style="background: linear-gradient(135deg, var(--success), #00b894);">MK</div>
                                        <div class="entity-info">
                                            <div class="entity-name">Michael Chen</div>
                                            <div class="entity-meta">m.chen@corp.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Marketing</td>
                                <td>Team Lead</td>
                                <td class="token-value">₮ 6,500</td>
                                <td><span class="status-pill pending">Pending</span></td>
                                <td>
                                    <div class="action-group">
                                        <button class="action-btn">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        </button>
                                        <button class="action-btn">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="entity-cell">
                                        <div class="entity-avatar" style="background: linear-gradient(135deg, var(--danger), #ff6b81);">EW</div>
                                        <div class="entity-info">
                                            <div class="entity-name">Emma Wilson</div>
                                            <div class="entity-meta">emma.w@corp.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Operations</td>
                                <td>Admin</td>
                                <td class="token-value">₮ 4,000</td>
                                <td><span class="status-pill suspended">Suspended</span></td>
                                <td>
                                    <div class="action-group">
                                        <button class="action-btn">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        </button>
                                        <button class="action-btn">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Financial Analytics Module -->
                <div class="glass-panel">
                    <div class="module-header">
                        <div class="module-title">Token Flow Analytics</div>
                        <div class="module-actions">
                            <button class="module-btn">Q1 2024</button>
                        </div>
                    </div>
                    <div class="financial-chart">
                        <svg class="chart-svg-container" viewBox="0 0 600 300" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="areaGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:0.3" />
                                    <stop offset="100%" style="stop-color:#00d4ff;stop-opacity:0" />
                                </linearGradient>
                                <linearGradient id="lineGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#00d4ff;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#b829dd;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            
                            <!-- Grid -->
                            <line class="chart-grid" x1="0" y1="75" x2="600" y2="75"/>
                            <line class="chart-grid" x1="0" y1="150" x2="600" y2="150"/>
                            <line class="chart-grid" x1="0" y1="225" x2="600" y2="225"/>
                            
                            <!-- Area -->
                            <path class="chart-area" fill="url(#areaGradient)" d="M0,250 C50,230 100,200 150,180 C200,160 250,140 300,120 C350,100 400,90 450,80 C500,70 550,60 600,50 L600,300 L0,300 Z"/>
                            
                            <!-- Line -->
                            <path class="chart-line" stroke="url(#lineGradient)" d="M0,250 C50,230 100,200 150,180 C200,160 250,140 300,120 C350,100 400,90 450,80 C500,70 550,60 600,50" filter="drop-shadow(0 0 10px #00d4ff)"/>
                            
                            <!-- Data Points -->
                            <circle cx="0" cy="250" r="5" fill="#00d4ff" filter="drop-shadow(0 0 8px #00d4ff)"/>
                            <circle cx="150" cy="180" r="5" fill="#00d4ff" filter="drop-shadow(0 0 8px #00d4ff)"/>
                            <circle cx="300" cy="120" r="5" fill="#b829dd" filter="drop-shadow(0 0 8px #b829dd)"/>
                            <circle cx="450" cy="80" r="5" fill="#b829dd" filter="drop-shadow(0 0 8px #b829dd)"/>
                            <circle cx="600" cy="50" r="5" fill="#b829dd" filter="drop-shadow(0 0 8px #b829dd)"/>
                        </svg>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--glass-border);">
                        <div>
                            <div style="font-size: 24px; font-weight: 700; color: var(--text-primary);">₮ 1.8M</div>
                            <div style="font-size: 12px; color: var(--text-muted);">Total Allocated</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 24px; font-weight: 700; color: var(--success);">92%</div>
                            <div style="font-size: 12px; color: var(--text-muted);">Utilization</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 24px; font-weight: 700; color: var(--primary-blue);">₮ 145K</div>
                            <div style="font-size: 12px; color: var(--text-muted);">Avg. per User</div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Control Module -->
                <div class="glass-panel">
                    <div class="module-header">
                        <div class="module-title">Inventory Status</div>
                        <div class="module-actions">
                            <button class="module-btn">Restock</button>
                        </div>
                    </div>
                    <div class="inventory-grid">
                        <div class="inventory-card">
                            <div class="inventory-icon">
                                <svg viewBox="0 0 24 24"><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2H0c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2h-4zM4 5h16v11H4V5z"/></svg>
                            </div>
                            <div class="inventory-count">842</div>
                            <div class="inventory-label">Workstations</div>
                            <div class="inventory-bar">
                                <div class="inventory-fill" style="width: 85%;"></div>
                            </div>
                        </div>
                        <div class="inventory-card">
                            <div class="inventory-icon" style="border-color: rgba(184, 41, 221, 0.3);">
                                <svg viewBox="0 0 24 24" fill="#b829dd"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            </div>
                            <div class="inventory-count">1,240</div>
                            <div class="inventory-label">Peripherals</div>
                            <div class="inventory-bar">
                                <div class="inventory-fill" style="width: 92%; background: linear-gradient(90deg, var(--primary-violet), var(--accent-purple));"></div>
                            </div>
                        </div>
                        <div class="inventory-card">
                            <div class="inventory-icon">
                                <svg viewBox="0 0 24 24"><path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0l4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/></svg>
                            </div>
                            <div class="inventory-count">156</div>
                            <div class="inventory-label">Dev Licenses</div>
                            <div class="inventory-bar">
                                <div class="inventory-fill" style="width: 45%; background: linear-gradient(90deg, var(--warning), var(--danger));"></div>
                            </div>
                        </div>
                        <div class="inventory-card">
                            <div class="inventory-icon" style="border-color: rgba(0, 217, 163, 0.3);">
                                <svg viewBox="0 0 24 24" fill="#00d9a3"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            </div>
                            <div class="inventory-count">64</div>
                            <div class="inventory-label">Premium Items</div>
                            <div class="inventory-bar">
                                <div class="inventory-fill" style="width: 78%; background: linear-gradient(90deg, var(--success), #00b894);"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approval Workflow Module -->
                <div class="glass-panel module-large">
                    <div class="module-header">
                        <div class="module-title">Premium Approval Queue</div>
                        <div class="module-actions">
                            <button class="module-btn">View All</button>
                            <button class="module-btn" style="background: rgba(0, 212, 255, 0.1); color: var(--primary-blue);">Auto-Approve</button>
                        </div>
                    </div>
                    <div class="approval-list">
                        <div class="approval-item">
                            <div class="approval-icon">
                                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            </div>
                            <div class="approval-content">
                                <div class="approval-title">Executive Standing Desk Request</div>
                                <div class="approval-meta">Engineering • John Doe • 2 hours ago</div>
                            </div>
                            <div class="approval-amount">₮ 12,000</div>
                            <div class="approval-actions">
                                <button class="approval-btn approval-btn-approve">Approve</button>
                                <button class="approval-btn approval-btn-deny">Deny</button>
                            </div>
                        </div>
                        <div class="approval-item">
                            <div class="approval-icon">
                                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            </div>
                            <div class="approval-content">
                                <div class="approval-title">4K Monitor Array (3 units)</div>
                                <div class="approval-meta">Design • Sarah Mitchell • 5 hours ago</div>
                            </div>
                            <div class="approval-amount">₮ 8,500</div>
                            <div class="approval-actions">
                                <button class="approval-btn approval-btn-approve">Approve</button>
                                <button class="approval-btn approval-btn-deny">Deny</button>
                            </div>
                        </div>
                        <div class="approval-item">
                            <div class="approval-icon">
                                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            </div>
                            <div class="approval-content">
                                <div class="approval-title">Ergonomic Chair Upgrade</div>
                                <div class="approval-meta">HR • Michael Chen • 1 day ago</div>
                            </div>
                            <div class="approval-amount">₮ 4,200</div>
                            <div class="approval-actions">
                                <button class="approval-btn approval-btn-approve">Approve</button>
                                <button class="approval-btn approval-btn-deny">Deny</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Department Spending Module -->
                <div class="glass-panel module-large">
                    <div class="module-header">
                        <div class="module-title">Department Spending Transparency</div>
                        <div class="module-actions">
                            <button class="module-btn">Export Report</button>
                        </div>
                    </div>
                    <table class="data-grid">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Budget</th>
                                <th>Spent</th>
                                <th>Remaining</th>
                                <th>Utilization</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="entity-cell">
                                        <div class="entity-avatar" style="background: linear-gradient(135deg, #00d4ff, #0099cc);">IT</div>
                                        <div class="entity-info">
                                            <div class="entity-name">Information Technology</div>
                                            <div class="entity-meta">42 employees</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="token-value">₮ 600,000</td>
                                <td>₮ 485,000</td>
                                <td style="color: var(--success); font-weight: 600;">₮ 115,000</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                                            <div style="width: 81%; height: 100%; background: linear-gradient(90deg, var(--primary-blue), var(--primary-violet)); border-radius: 4px; box-shadow: 0 0 10px rgba(0, 212, 255, 0.5);"></div>
                                        </div>
                                        <span style="font-size: 12px; color: var(--text-muted);">81%</span>
                                    </div>
                                </td>
                                <td class="trend-indicator" style="color: var(--success);">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14l5-5 5 5z"/></svg>
                                    +12%
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="entity-cell">
                                        <div class="entity-avatar" style="background: linear-gradient(135deg, var(--primary-violet), #9932cc);">HR</div>
                                        <div class="entity-info">
                                            <div class="entity-name">Human Resources</div>
                                            <div class="entity-meta">18 employees</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="token-value">₮ 250,000</td>
                                <td>₮ 195,000</td>
                                <td style="color: var(--success); font-weight: 600;">₮ 55,000</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                                            <div style="width: 78%; height: 100%; background: linear-gradient(90deg, var(--primary-violet), var(--accent-purple)); border-radius: 4px;"></div>
                                        </div>
                                        <span style="font-size: 12px; color: var(--text-muted);">78%</span>
                                    </div>
                                </td>
                                <td class="trend-indicator" style="color: var(--success);">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14l5-5 5 5z"/></svg>
                                    +5%
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="entity-cell">
                                        <div class="entity-avatar" style="background: linear-gradient(135deg, var(--warning), #ff8c00);">MK</div>
                                        <div class="entity-info">
                                            <div class="entity-name">Marketing</div>
                                            <div class="entity-meta">24 employees</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="token-value">₮ 400,000</td>
                                <td>₮ 368,000</td>
                                <td style="color: var(--warning); font-weight: 600;">₮ 32,000</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                                            <div style="width: 92%; height: 100%; background: linear-gradient(90deg, var(--warning), var(--danger)); border-radius: 4px;"></div>
                                        </div>
                                        <span style="font-size: 12px; color: var(--text-muted);">92%</span>
                                    </div>
                                </td>
                                <td class="trend-indicator" style="color: var(--danger);">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                                    -3%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </main>
    </div>
{{-- Add this at the bottom of your Blade file, before closing </body> tag --}}

<script>
    /**
     * Enterprise Command Center - Interactive Behaviors
     * Pure Vanilla JavaScript implementation for UI interactions
     */

    // ==========================================
    // UTILITY FUNCTIONS
    // ==========================================

    /**
     * Creates a modal element dynamically
     * @param {string} title - Modal header title
     * @param {string} content - HTML content for modal body
     * @returns {HTMLElement} The created modal element
     */
    function createModal(title, content) {
        // Create modal backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop';
        backdrop.style.cssText = `
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;

        // Create modal container
        const modal = document.createElement('div');
        modal.className = 'glass-panel modal-container';
        modal.style.cssText = `
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            transform: scale(0.9) translateY(20px);
            transition: transform 0.3s ease;
            padding: 32px;
        `;

        // Modal header
        const header = document.createElement('div');
        header.style.cssText = `
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        `;
        
        const headerTitle = document.createElement('h2');
        headerTitle.textContent = title;
        headerTitle.style.cssText = `
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        `;

        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.cssText = `
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 28px;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s ease;
        `;
        closeBtn.onmouseover = () => {
            closeBtn.style.background = 'rgba(255, 255, 255, 0.1)';
            closeBtn.style.color = '#fff';
        };
        closeBtn.onmouseout = () => {
            closeBtn.style.background = 'none';
            closeBtn.style.color = 'var(--text-muted)';
        };

        header.appendChild(headerTitle);
        header.appendChild(closeBtn);

        // Modal body
        const body = document.createElement('div');
        body.innerHTML = content;
        body.style.color = 'var(--text-secondary)';

        // Modal footer with action buttons
        const footer = document.createElement('div');
        footer.style.cssText = `
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        `;

        const cancelBtn = document.createElement('button');
        cancelBtn.textContent = 'Cancel';
        cancelBtn.className = 'control-btn control-btn-secondary';
        cancelBtn.style.padding = '10px 20px';
        cancelBtn.style.fontSize = '12px';

        const submitBtn = document.createElement('button');
        submitBtn.textContent = 'Create';
        submitBtn.className = 'control-btn control-btn-primary';
        submitBtn.style.padding = '10px 20px';
        submitBtn.style.fontSize = '12px';

        footer.appendChild(cancelBtn);
        footer.appendChild(submitBtn);

        // Assemble modal
        modal.appendChild(header);
        modal.appendChild(body);
        modal.appendChild(footer);
        backdrop.appendChild(modal);

        // Close modal function
        const closeModal = () => {
            backdrop.style.opacity = '0';
            modal.style.transform = 'scale(0.9) translateY(20px)';
            setTimeout(() => backdrop.remove(), 300);
        };

        // Event listeners
        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) closeModal();
        });

        // Submit action
        submitBtn.addEventListener('click', () => {
            // Simulate form submission
            const inputs = modal.querySelectorAll('input');
            let isValid = true;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = 'var(--danger)';
                    isValid = false;
                } else {
                    input.style.borderColor = '';
                }
            });

            if (isValid) {
                submitBtn.textContent = 'Creating...';
                submitBtn.disabled = true;
                setTimeout(() => {
                    alert('User created successfully! (Simulation)');
                    closeModal();
                }, 1000);
            }
        });

        // Animate in
        document.body.appendChild(backdrop);
        requestAnimationFrame(() => {
            backdrop.style.opacity = '1';
            modal.style.transform = 'scale(1) translateY(0)';
        });

        return backdrop;
    }

    /**
     * Shows a confirmation dialog
     * @param {string} message - Confirmation message
     * @param {Function} onConfirm - Callback when confirmed
     */
    function showConfirm(message, onConfirm) {
        if (confirm(message)) {
            onConfirm();
        }
    }

    /**
     * Shows a temporary notification toast
     * @param {string} message - Message to display
     * @param {string} type - 'success', 'error', or 'info'
     */
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        const colors = {
            success: '#00d9a3',
            error: '#ff4757',
            info: '#00d4ff'
        };
        
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(12, 12, 20, 0.95);
            border: 1px solid ${colors[type]};
            color: #fff;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px ${colors[type]}40;
            z-index: 10001;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        `;

        const icon = type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ';
        toast.innerHTML = `<span style="color: ${colors[type]}; font-weight: bold;">${icon}</span> ${message}`;

        document.body.appendChild(toast);
        
        // Animate in
        requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
        });

        // Remove after delay
        setTimeout(() => {
            toast.style.transform = 'translateX(400px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // ==========================================
    // INITIALIZATION
    // ==========================================

    document.addEventListener('DOMContentLoaded', function() {
        
        // --------------------------------------
        // 1. NAVIGATION ACTIVE STATE SWITCHING
        // --------------------------------------
        
        // Get all navigation items
        const navItems = document.querySelectorAll('.nav-item');
        
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Prevent default only for demo (remove in production)
                if (this.getAttribute('href') === '#') {
                    e.preventDefault();
                }
                
                // Remove active class from all items
                navItems.forEach(nav => nav.classList.remove('active'));
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Optional: Show which section was selected
                const sectionName = this.querySelector('span')?.textContent || 'Section';
                console.log(`Navigated to: ${sectionName}`);
            });
        });

        // --------------------------------------
        // 2. CREATE USER BUTTON (Modal)
        // --------------------------------------
        
        // Find "Create User" button by its text content and primary styling
        const createUserBtn = Array.from(document.querySelectorAll('.control-btn')).find(
            btn => btn.textContent.includes('Create User')
        );

        if (createUserBtn) {
            createUserBtn.addEventListener('click', function() {
                // Modal content HTML
                const modalContent = `
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Full Name</label>
                            <input type="text" placeholder="Enter full name" style="
                                width: 100%;
                                padding: 12px 16px;
                                background: rgba(0, 0, 0, 0.3);
                                border: 1px solid rgba(255, 255, 255, 0.1);
                                border-radius: 8px;
                                color: #fff;
                                font-size: 14px;
                                outline: none;
                                transition: all 0.3s ease;
                            ">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Email Address</label>
                            <input type="email" placeholder="name@company.com" style="
                                width: 100%;
                                padding: 12px 16px;
                                background: rgba(0, 0, 0, 0.3);
                                border: 1px solid rgba(255, 255, 255, 0.1);
                                border-radius: 8px;
                                color: #fff;
                                font-size: 14px;
                                outline: none;
                            ">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <label style="display: block; font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Department</label>
                                <select style="
                                    width: 100%;
                                    padding: 12px 16px;
                                    background: rgba(0, 0, 0, 0.3);
                                    border: 1px solid rgba(255, 255, 255, 0.1);
                                    border-radius: 8px;
                                    color: #fff;
                                    font-size: 14px;
                                    outline: none;
                                ">
                                    <option value="">Select...</option>
                                    <option>Engineering</option>
                                    <option>Finance</option>
                                    <option>Marketing</option>
                                    <option>Operations</option>
                                    <option>HR</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Role</label>
                                <select style="
                                    width: 100%;
                                    padding: 12px 16px;
                                    background: rgba(0, 0, 0, 0.3);
                                    border: 1px solid rgba(255, 255, 255, 0.1);
                                    border-radius: 8px;
                                    color: #fff;
                                    font-size: 14px;
                                    outline: none;
                                ">
                                    <option value="">Select...</option>
                                    <option>Employee</option>
                                    <option>Manager</option>
                                    <option>Finance</option>
                                    <option>Administrator</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Monthly Token Allocation</label>
                            <input type="number" placeholder="5000" style="
                                width: 100%;
                                padding: 12px 16px;
                                background: rgba(0, 0, 0, 0.3);
                                border: 1px solid rgba(255, 255, 255, 0.1);
                                border-radius: 8px;
                                color: #fff;
                                font-size: 14px;
                                outline: none;
                            ">
                        </div>
                    </div>
                `;

                // Open the modal
                createModal('Create New User', modalContent);
            });
        }

        // Also bind to "+ Add User" button in User Management module
        const addUserBtn = Array.from(document.querySelectorAll('.module-btn')).find(
            btn => btn.textContent.includes('Add User')
        );
        
        if (addUserBtn) {
            addUserBtn.addEventListener('click', function() {
                // Trigger same modal as Create User button
                if (createUserBtn) createUserBtn.click();
            });
        }

        // --------------------------------------
        // 3. APPROVE / DENY BUTTONS
        // --------------------------------------
        
        // Get all approval buttons
        const approveButtons = document.querySelectorAll('.approval-btn-approve');
        const denyButtons = document.querySelectorAll('.approval-btn-deny');

        approveButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const approvalItem = this.closest('.approval-item');
                const title = approvalItem.querySelector('.approval-title')?.textContent || 'this request';
                
                showConfirm(`Approve "${title}"?`, () => {
                    // Simulate processing
                    this.textContent = 'Processing...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        // Visual feedback - fade out and remove
                        approvalItem.style.transition = 'all 0.5s ease';
                        approvalItem.style.opacity = '0';
                        approvalItem.style.transform = 'translateX(50px)';
                        
                        setTimeout(() => {
                            approvalItem.remove();
                            showToast(`Approved: ${title}`, 'success');
                            
                            // Update badge count
                            updateApprovalBadge(-1);
                        }, 500);
                    }, 800);
                });
            });
        });

        denyButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const approvalItem = this.closest('.approval-item');
                const title = approvalItem.querySelector('.approval-title')?.textContent || 'this request';
                
                showConfirm(`Deny "${title}"? This action cannot be undone.`, () => {
                    // Simulate processing
                    this.textContent = 'Processing...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        // Visual feedback
                        approvalItem.style.transition = 'all 0.5s ease';
                        approvalItem.style.opacity = '0';
                        approvalItem.style.transform = 'translateX(-50px)';
                        
                        setTimeout(() => {
                            approvalItem.remove();
                            showToast(`Denied: ${title}`, 'error');
                            
                            // Update badge count
                            updateApprovalBadge(-1);
                        }, 500);
                    }, 800);
                });
            });
        });

        /**
         * Updates the approval badge count in sidebar
         */
        function updateApprovalBadge(change) {
            const badge = document.querySelector('.nav-item:nth-child(5) .nav-badge');
            if (badge) {
                let current = parseInt(badge.textContent) || 0;
                current += change;
                if (current < 0) current = 0;
                badge.textContent = current;
                
                // Visual pulse effect
                badge.style.transform = 'scale(1.2)';
                setTimeout(() => badge.style.transform = 'scale(1)', 200);
            }
        }

        // --------------------------------------
        // 4. FILTER / EXPORT BUTTONS
        // --------------------------------------
        
        // Filter buttons
        const filterButtons = Array.from(document.querySelectorAll('.module-btn, .table-btn')).filter(
            btn => btn.textContent.includes('Filter')
        );

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Simulate filter panel opening
                console.log('Filter panel opened');
                showToast('Filter options displayed (Simulation)', 'info');
                
                // Visual feedback
                this.style.background = 'rgba(0, 212, 255, 0.2)';
                setTimeout(() => {
                    this.style.background = '';
                }, 300);
            });
        });

        // Export buttons
        const exportButtons = Array.from(document.querySelectorAll('.module-btn, .table-btn, .control-btn')).filter(
            btn => btn.textContent.includes('Export') || btn.textContent.includes('Export Report') || btn.textContent.includes('Export CSV')
        );

        exportButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Simulate export process
                const originalText = this.textContent;
                this.textContent = 'Exporting...';
                this.disabled = true;
                
                console.log(`Exporting data: ${originalText}`);
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.disabled = false;
                    showToast(`Export completed: ${originalText}`, 'success');
                }, 1500);
            });
        });

        // --------------------------------------
        // 5. EDIT / DELETE USER ACTIONS
        // --------------------------------------
        
        // Edit buttons (pencil icon)
        const editButtons = document.querySelectorAll('.action-btn:first-child');
        editButtons.forEach(btn => {
            // Check if it's an edit button by looking at the SVG path
            const svg = btn.querySelector('svg');
            if (svg && svg.querySelector('path')?.getAttribute('d').includes('17.25')) {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const userName = row.querySelector('.entity-name')?.textContent || 'User';
                    
                    showToast(`Edit mode activated for: ${userName}`, 'info');
                    
                    // Visual feedback on row
                    row.style.background = 'rgba(0, 212, 255, 0.1)';
                    setTimeout(() => {
                        row.style.background = '';
                    }, 1000);
                });
            }
        });

        // Delete buttons (trash icon)
        const deleteButtons = document.querySelectorAll('.action-btn:last-child');
        deleteButtons.forEach(btn => {
            const svg = btn.querySelector('svg');
            if (svg && svg.querySelector('path')?.getAttribute('d').includes('19c0')) {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const userName = row.querySelector('.entity-name')?.textContent || 'this user';
                    
                    showConfirm(`Delete user "${userName}"? This action cannot be undone.`, () => {
                        // Animate row removal
                        row.style.transition = 'all 0.5s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(-100%)';
                        
                        setTimeout(() => {
                            row.remove();
                            showToast(`User deleted: ${userName}`, 'success');
                        }, 500);
                    });
                });
            }
        });

        // --------------------------------------
        // 6. SYSTEM STATUS BUTTON
        // --------------------------------------
        
        const systemStatusBtn = Array.from(document.querySelectorAll('.control-btn')).find(
            btn => btn.textContent.includes('System Status')
        );

        if (systemStatusBtn) {
            systemStatusBtn.addEventListener('click', function() {
                const statuses = [
                    { name: 'Database', status: 'Operational', color: '#00d9a3' },
                    { name: 'Token Service', status: 'Operational', color: '#00d9a3' },
                    { name: 'Inventory API', status: 'Degraded', color: '#ffb800' },
                    { name: 'Auth Service', status: 'Operational', color: '#00d9a3' }
                ];

                const content = `
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        ${statuses.map(s => `
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; background: rgba(0,0,0,0.3); border-radius: 8px;">
                                <span style="color: var(--text-primary); font-weight: 500;">${s.name}</span>
                                <span style="color: ${s.color}; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 8px; height: 8px; background: ${s.color}; border-radius: 50%; box-shadow: 0 0 8px ${s.color};"></span>
                                    ${s.status}
                                </span>
                            </div>
                        `).join('')}
                        <div style="margin-top: 8px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 12px; color: var(--text-muted); text-align: center;">
                            Last updated: Just now
                        </div>
                    </div>
                `;

                createModal('System Status Overview', content);
            });
        }

        // --------------------------------------
        // 7. RESTOCK BUTTON
        // --------------------------------------
        
        const restockBtn = Array.from(document.querySelectorAll('.module-btn')).find(
            btn => btn.textContent.includes('Restock')
        );

        if (restockBtn) {
            restockBtn.addEventListener('click', function() {
                showConfirm('Initiate automatic restocking for low inventory items?', () => {
                    this.textContent = 'Processing...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        this.textContent = 'Restock';
                        this.disabled = false;
                        showToast('Restock orders initiated successfully', 'success');
                    }, 2000);
                });
            });
        }

        // --------------------------------------
        // 8. AUTO-APPROVE BUTTON
        // --------------------------------------
        
        const autoApproveBtn = Array.from(document.querySelectorAll('.module-btn')).find(
            btn => btn.textContent.includes('Auto-Approve')
        );

        if (autoApproveBtn) {
            autoApproveBtn.addEventListener('click', function() {
                const pendingCount = document.querySelectorAll('.approval-item').length;
                
                if (pendingCount === 0) {
                    showToast('No pending approvals', 'info');
                    return;
                }

                showConfirm(`Auto-approve all ${pendingCount} pending requests?`, () => {
                    const items = document.querySelectorAll('.approval-item');
                    let processed = 0;
                    
                    items.forEach((item, index) => {
                        setTimeout(() => {
                            item.style.transition = 'all 0.5s ease';
                            item.style.opacity = '0';
                            item.style.transform = 'translateX(50px)';
                            
                            setTimeout(() => {
                                item.remove();
                                processed++;
                                
                                if (processed === items.length) {
                                    showToast(`Auto-approved ${pendingCount} requests`, 'success');
                                    updateApprovalBadge(-pendingCount);
                                }
                            }, 500);
                        }, index * 200);
                    });
                });
            });
        }

        // --------------------------------------
        // 9. VIEW ALL BUTTONS
        // --------------------------------------
        
        const viewAllButtons = Array.from(document.querySelectorAll('.module-btn')).filter(
            btn => btn.textContent.includes('View All')
        );

        viewAllButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                showToast('Loading full list view... (Simulation)', 'info');
            });
        });

        // --------------------------------------
        // 10. QUARTER SELECTOR
        // --------------------------------------
        
        const quarterBtn = Array.from(document.querySelectorAll('.module-btn')).find(
            btn => btn.textContent.includes('Q1 2024')
        );

        if (quarterBtn) {
            quarterBtn.addEventListener('click', function() {
                const quarters = ['Q1 2024', 'Q2 2024', 'Q3 2024', 'Q4 2024', 'FY 2024'];
                const current = this.textContent;
                const nextIndex = (quarters.indexOf(current) + 1) % quarters.length;
                this.textContent = quarters[nextIndex];
                showToast(`Switched to ${quarters[nextIndex]}`, 'info');
            });
        }

        console.log('Enterprise Command Center: Interactive behaviors initialized');
    });
</script>
</body>
</html>
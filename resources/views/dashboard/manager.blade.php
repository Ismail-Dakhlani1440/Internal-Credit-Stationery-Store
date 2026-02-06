{{-- resources/views/manager/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Nexus') }} | Manager Command</title>
    
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
            --deep-black: #050508;
            --panel-bg: rgba(18, 18, 28, 0.65);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.06);
            --glass-highlight: rgba(255, 255, 255, 0.12);
            --neon-glow-blue: 0 0 30px rgba(0, 212, 255, 0.15);
            --neon-glow-violet: 0 0 30px rgba(184, 41, 221, 0.15);
            --depth-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.8);
            --text-primary: rgba(255, 255, 255, 0.95);
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.45);
            --success: #00d9a3;
            --warning: #ffb800;
            --danger: #ff4757;
            --info: #00d4ff;
        }

        @keyframes ambientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        @keyframes scanline {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100vh); }
        }

        @keyframes borderGlow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
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

        /* Deep Space Background */
        .universe {
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(ellipse at 0% 100%, rgba(0, 212, 255, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 100% 0%, rgba(184, 41, 221, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(8, 8, 16, 1) 0%, rgba(5, 5, 8, 1) 100%);
            z-index: -3;
        }

        .ambient-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -2;
            animation: pulse-glow 8s ease-in-out infinite;
        }

        .ambient-orb-1 {
            width: 500px;
            height: 500px;
            background: rgba(0, 212, 255, 0.08);
            top: -100px;
            right: -100px;
        }

        .ambient-orb-2 {
            width: 400px;
            height: 400px;
            background: rgba(184, 41, 221, 0.08);
            bottom: -100px;
            left: -100px;
            animation-delay: 4s;
        }

        /* Scanline Effect */
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
            z-index: 1000;
            pointer-events: none;
            opacity: 0.3;
        }

        /* Layout */
        .command-center {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }

        /* Glass Panel Base */
        .glass-panel {
            background: var(--panel-bg);
            backdrop-filter: blur(20px) saturate(150%);
            -webkit-backdrop-filter: blur(20px) saturate(150%);
            border: 1px solid var(--glass-border);
            border-top: 1px solid var(--glass-highlight);
            border-left: 1px solid var(--glass-highlight);
            border-radius: 16px;
            box-shadow: var(--depth-shadow);
            position: relative;
            overflow: hidden;
        }

        .glass-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.06) 0%, transparent 50%);
            border-radius: 16px;
            pointer-events: none;
        }

        .glass-panel::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 16px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(184, 41, 221, 0.15), transparent);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Sidebar */
        .sidebar {
            padding: 32px 20px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            position: sticky;
            top: 0;
            height: 100vh;
            border-right: 1px solid var(--glass-border);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--glass-border);
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-ring {
            position: absolute;
            border-radius: 50%;
            border: 2px solid transparent;
            background: linear-gradient(var(--deep-black), var(--deep-black)) padding-box,
                        linear-gradient(135deg, var(--primary-blue), var(--primary-violet)) border-box;
        }

        .brand-ring-outer {
            width: 44px;
            height: 44px;
            animation: pulse-glow 4s ease-in-out infinite;
        }

        .brand-ring-inner {
            width: 32px;
            height: 32px;
        }

        .brand-core {
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .brand-text {
            font-size: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
        }

        .brand-sub {
            font-size: 10px;
            color: var(--text-muted);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Navigation */
        .nav-section {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 0 12px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.25s ease;
            position: relative;
            border: 1px solid transparent;
        }

        .nav-item:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(0, 212, 255, 0.2);
        }

        .nav-item.active {
            color: var(--text-primary);
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.12), rgba(184, 41, 221, 0.08));
            border: 1px solid rgba(0, 212, 255, 0.35);
            box-shadow: var(--neon-glow-blue);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        .nav-badge {
            margin-left: auto;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 212, 255, 0.4);
        }

        /* User Profile */
        .user-profile {
            margin-top: auto;
            padding: 16px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 15px;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.4);
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 11px;
            color: var(--primary-blue);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        /* Main Content */
        .main-content {
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            overflow-y: auto;
        }

        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--glass-border);
        }

        .page-title {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.85) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 6px;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.15), rgba(184, 41, 221, 0.1));
            border: 1px solid rgba(0, 212, 255, 0.4);
            color: var(--text-primary);
            box-shadow: var(--neon-glow-blue);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            color: var(--text-secondary);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.3);
            color: var(--text-primary);
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .stat-card {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .stat-label {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(184, 41, 221, 0.05));
            border: 1px solid rgba(0, 212, 255, 0.2);
        }

        .stat-icon svg {
            width: 22px;
            height: 22px;
            fill: var(--primary-blue);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .stat-change {
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .stat-change.positive { color: var(--success); }
        .stat-change.negative { color: var(--danger); }
        .stat-change.warning { color: var(--warning); }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 24px;
        }

        .module-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--glass-border);
        }

        .module-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .module-title::before {
            content: '';
            width: 3px;
            height: 20px;
            background: linear-gradient(to bottom, var(--primary-blue), var(--primary-violet));
            border-radius: 2px;
        }

        .module-actions {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 11px;
            border-radius: 6px;
        }

        /* Approval Queue */
        .approval-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .approval-card {
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
            position: relative;
        }

        .approval-card:hover {
            border-color: rgba(0, 212, 255, 0.25);
            transform: translateX(4px);
            background: rgba(0, 212, 255, 0.03);
        }

        .approval-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--warning), var(--danger));
            border-radius: 12px 0 0 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .approval-card:hover::before {
            opacity: 1;
        }

        .approval-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .approval-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .approval-meta {
            font-size: 12px;
            color: var(--text-muted);
        }

        .approval-amount {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-blue);
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.4);
        }

        .approval-details {
            display: flex;
            gap: 20px;
            padding: 12px 0;
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
            margin-bottom: 16px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .detail-value {
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .approval-actions {
            display: flex;
            gap: 10px;
        }

        .btn-approve {
            flex: 1;
            padding: 10px;
            background: linear-gradient(135deg, rgba(0, 217, 163, 0.15), rgba(0, 217, 163, 0.05));
            border: 1px solid rgba(0, 217, 163, 0.4);
            color: var(--success);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-approve:hover {
            background: rgba(0, 217, 163, 0.25);
            box-shadow: 0 0 20px rgba(0, 217, 163, 0.3);
            transform: translateY(-1px);
        }

        .btn-deny {
            flex: 1;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            color: var(--text-muted);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-deny:hover {
            background: rgba(255, 71, 87, 0.1);
            border-color: rgba(255, 71, 87, 0.4);
            color: var(--danger);
        }

        /* Team Overview */
        .team-stats {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .team-card {
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            border: 1px solid var(--glass-border);
        }

        .team-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .team-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .team-count {
            font-size: 12px;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.05);
            padding: 4px 10px;
            border-radius: 12px;
        }

        .budget-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .budget-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 1s ease;
            position: relative;
        }

        .budget-fill::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .budget-fill.safe { background: linear-gradient(90deg, var(--success), #00b894); }
        .budget-fill.warning { background: linear-gradient(90deg, var(--warning), #ff9500); }
        .budget-fill.danger { background: linear-gradient(90deg, var(--danger), #ff6b81); }

        .budget-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .budget-used {
            color: var(--text-secondary);
        }

        .budget-remaining {
            color: var(--text-muted);
        }

        /* Recent Orders Table */
        .orders-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .orders-table th {
            text-align: left;
            padding: 12px 16px;
            font-size: 10px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            border-bottom: 1px solid var(--glass-border);
        }

        .orders-table td {
            padding: 16px;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
            font-size: 13px;
            color: var(--text-secondary);
        }

        .orders-table tr:hover td {
            background: rgba(0, 212, 255, 0.03);
            color: var(--text-primary);
        }

        .orders-table td:first-child {
            border-left: 1px solid var(--glass-border);
            border-radius: 10px 0 0 10px;
        }

        .orders-table td:last-child {
            border-right: 1px solid var(--glass-border);
            border-radius: 0 10px 10px 0;
        }

        .order-id {
            font-family: 'Courier New', monospace;
            color: var(--primary-blue);
            font-weight: 600;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-badge.approved {
            background: rgba(0, 217, 163, 0.1);
            color: var(--success);
            border: 1px solid rgba(0, 217, 163, 0.3);
        }

        .status-badge.approved::before {
            background: var(--success);
            box-shadow: 0 0 8px var(--success);
        }

        .status-badge.pending {
            background: rgba(255, 184, 0, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 184, 0, 0.3);
        }

        .status-badge.pending::before {
            background: var(--warning);
            box-shadow: 0 0 8px var(--warning);
            animation: pulse 2s infinite;
        }

        .status-badge.rejected {
            background: rgba(255, 71, 87, 0.1);
            color: var(--danger);
            border: 1px solid rgba(255, 71, 87, 0.3);
        }

        .status-badge.rejected::before {
            background: var(--danger);
        }

        /* Activity Feed */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .activity-item {
            display: flex;
            gap: 12px;
            padding: 14px;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.15);
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            border-color: rgba(0, 212, 255, 0.2);
            background: rgba(0, 212, 255, 0.05);
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-icon.approve { background: rgba(0, 217, 163, 0.1); color: var(--success); }
        .activity-icon.reject { background: rgba(255, 71, 87, 0.1); color: var(--danger); }
        .activity-icon.system { background: rgba(0, 212, 255, 0.1); color: var(--primary-blue); }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            font-size: 13px;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .activity-text strong {
            color: var(--primary-blue);
            font-weight: 600;
        }

        .activity-time {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .content-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 1024px) {
            .command-center { grid-template-columns: 1fr; }
            .sidebar { display: none; }
        }

        @media (max-width: 768px) {
            .stats-row { grid-template-columns: 1fr; }
            .main-content { padding: 20px; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary-blue), var(--primary-violet));
            border-radius: 3px;
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * { animation-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>

    <div class="universe"></div>
    <div class="ambient-orb ambient-orb-1"></div>
    <div class="ambient-orb ambient-orb-2"></div>
    <div class="scanlines"></div>

    <div class="command-center">
        <!-- Sidebar -->
        <aside class="sidebar glass-panel">
            <div class="brand">
                <div class="brand-icon">
                    <div class="brand-ring brand-ring-outer"></div>
                    <div class="brand-ring brand-ring-inner"></div>
                    <div class="brand-core">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="white">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="brand-text">NEXUS</div>
                    <div class="brand-sub">Manager Portal</div>
                </div>
            </div>

            <nav class="nav-section">
                <div class="nav-label">Operations</div>
                <a href="#" class="nav-item active">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    Approvals
                    <span class="nav-badge">5</span>
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    My Team
                </a>
            </nav>

            <nav class="nav-section">
                <div class="nav-label">Analytics</div>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                    Spending
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4zm2 2H5V5h14v14zm0-16H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
                    Reports
                </a>
            </nav>

            <div class="user-profile">
                <div class="user-avatar">MK</div>
                <div class="user-info">
                    <div class="user-name">Michael Chen</div>
                    <div class="user-role">Engineering Manager</div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            
            <!-- Header -->
            <header class="page-header">
                <div>
                    <h1 class="page-title">Manager Command</h1>
                    <p class="page-subtitle">Team oversight, approvals, and budget control</p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                        </svg>
                        Export
                    </button>
                    <button class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                        Review Queue
                    </button>
                </div>
            </header>

            <!-- Stats -->
            <div class="stats-row">
                <div class="glass-panel stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-label">Pending Approvals</div>
                            <div class="stat-value">5</div>
                            <div class="stat-change warning">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                Needs action
                            </div>
                        </div>
                        <div class="stat-icon" style="background: rgba(255, 184, 0, 0.1); border-color: rgba(255, 184, 0, 0.2);">
                            <svg viewBox="0 0 24 24" fill="#ffb800"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="glass-panel stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-label">Team Budget</div>
                            <div class="stat-value">₮ 85K</div>
                            <div class="stat-change positive">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14l5-5 5 5z"/></svg>
                                32% remaining
                            </div>
                        </div>
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="glass-panel stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-label">Team Size</div>
                            <div class="stat-value">12</div>
                            <div class="stat-change positive">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14l5-5 5 5z"/></svg>
                                +2 this month
                            </div>
                        </div>
                        <div class="stat-icon" style="background: rgba(0, 217, 163, 0.1); border-color: rgba(0, 217, 163, 0.2);">
                            <svg viewBox="0 0 24 24" fill="#00d9a3"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="glass-panel stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-label">Monthly Spend</div>
                            <div class="stat-value">₮ 42K</div>
                            <div class="stat-change negative">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                                +18% vs last
                            </div>
                        </div>
                        <div class="stat-icon" style="background: rgba(255, 71, 87, 0.1); border-color: rgba(255, 71, 87, 0.2);">
                            <svg viewBox="0 0 24 24" fill="#ff4757"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                
                <!-- Approval Queue -->
                <div class="glass-panel">
                    <div class="module-header">
                        <div class="module-title">Pending Approvals</div>
                        <div class="module-actions">
                            <button class="btn btn-secondary btn-sm">Filter</button>
                            <button class="btn btn-primary btn-sm">Approve All</button>
                        </div>
                    </div>

                    <div class="approval-list">
                        <div class="approval-card">
                            <div class="approval-header">
                                <div>
                                    <div class="approval-title">Standing Desk - Fully Jarvis</div>
                                    <div class="approval-meta">Requested by Sarah Johnson • 2 hours ago</div>
                                </div>
                                <div class="approval-amount">₮ 8,500</div>
                            </div>
                            <div class="approval-details">
                                <div class="detail-item">
                                    <div class="detail-label">Category</div>
                                    <div class="detail-value">Furniture</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Priority</div>
                                    <div class="detail-value">High</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Justification</div>
                                    <div class="detail-value">Ergonomics upgrade</div>
                                </div>
                            </div>
                            <div class="approval-actions">
                                <button class="btn-approve">Approve</button>
                                <button class="btn-deny">Deny</button>
                            </div>
                        </div>

                        <div class="approval-card">
                            <div class="approval-header">
                                <div>
                                    <div class="approval-title">4K Monitor - LG UltraFine</div>
                                    <div class="approval-meta">Requested by David Park • 5 hours ago</div>
                                </div>
                                <div class="approval-amount">₮ 6,200</div>
                            </div>
                            <div class="approval-details">
                                <div class="detail-item">
                                    <div class="detail-label">Category</div>
                                    <div class="detail-value">Electronics</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Priority</div>
                                    <div class="detail-value">Normal</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Justification</div>
                                    <div class="detail-value">Design work requirements</div>
                                </div>
                            </div>
                            <div class="approval-actions">
                                <button class="btn-approve">Approve</button>
                                <button class="btn-deny">Deny</button>
                            </div>
                        </div>

                        <div class="approval-card">
                            <div class="approval-header">
                                <div>
                                    <div class="approval-title">Ergonomic Chair - Herman Miller</div>
                                    <div class="approval-meta">Requested by Emma Wilson • 1 day ago</div>
                                </div>
                                <div class="approval-amount">₮ 12,000</div>
                            </div>
                            <div class="approval-details">
                                <div class="detail-item">
                                    <div class="detail-label">Category</div>
                                    <div class="detail-value">Furniture</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Priority</div>
                                    <div class="detail-value">Normal</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Justification</div>
                                    <div class="detail-value">Back pain prevention</div>
                                </div>
                            </div>
                            <div class="approval-actions">
                                <button class="btn-approve">Approve</button>
                                <button class="btn-deny">Deny</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    
                    <!-- Team Budget Overview -->
                    <div class="glass-panel">
                        <div class="module-header">
                            <div class="module-title">Team Budget Status</div>
                        </div>
                        <div class="team-stats">
                            <div class="team-card">
                                <div class="team-header">
                                    <div class="team-name">Engineering</div>
                                    <div class="team-count">12 members</div>
                                </div>
                                <div class="budget-bar">
                                    <div class="budget-fill safe" style="width: 68%;"></div>
                                </div>
                                <div class="budget-info">
                                    <span class="budget-used">₮ 115K used</span>
                                    <span class="budget-remaining">₮ 85K left</span>
                                </div>
                            </div>

                            <div class="team-card">
                                <div class="team-header">
                                    <div class="team-name">Design</div>
                                    <div class="team-count">4 members</div>
                                </div>
                                <div class="budget-bar">
                                    <div class="budget-fill warning" style="width: 85%;"></div>
                                </div>
                                <div class="budget-info">
                                    <span class="budget-used">₮ 42K used</span>
                                    <span class="budget-remaining">₮ 8K left</span>
                                </div>
                            </div>

                            <div class="team-card">
                                <div class="team-header">
                                    <div class="team-name">QA</div>
                                    <div class="team-count">3 members</div>
                                </div>
                                <div class="budget-bar">
                                    <div class="budget-fill safe" style="width: 45%;"></div>
                                </div>
                                <div class="budget-info">
                                    <span class="budget-used">₮ 13K used</span>
                                    <span class="budget-remaining">₮ 22K left</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="glass-panel">
                        <div class="module-header">
                            <div class="module-title">Recent Activity</div>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon approve">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">Approved <strong>MacBook Pro M3</strong> for Alex Chen</div>
                                    <div class="activity-time">2 hours ago</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon reject">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">Denied <strong>Gaming Chair RGB</strong> for Mike Ross</div>
                                    <div class="activity-time">5 hours ago</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon system">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">Budget alert: Design team at <strong>85%</strong></div>
                                    <div class="activity-time">1 day ago</div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="activity-icon approve">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-text">Approved <strong>Monitor Arm</strong> for 3 employees</div>
                                    <div class="activity-time">2 days ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="glass-panel">
                <div class="module-header">
                    <div class="module-title">Order History</div>
                    <div class="module-actions">
                        <button class="btn btn-secondary btn-sm">View All</button>
                    </div>
                </div>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Employee</th>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="order-id">#ORD-7829</td>
                            <td>Sarah Johnson</td>
                            <td>Wireless Keyboard MX Keys</td>
                            <td style="font-family: monospace; color: var(--primary-blue);">₮ 1,200</td>
                            <td>Jan 15, 2024</td>
                            <td><span class="status-badge approved">Approved</span></td>
                        </tr>
                        <tr>
                            <td class="order-id">#ORD-7828</td>
                            <td>David Park</td>
                            <td>USB-C Docking Station</td>
                            <td style="font-family: monospace; color: var(--primary-blue);">₮ 3,400</td>
                            <td>Jan 14, 2024</td>
                            <td><span class="status-badge approved">Approved</span></td>
                        </tr>
                        <tr>
                            <td class="order-id">#ORD-7827</td>
                            <td>Emma Wilson</td>
                            <td>Webcam 4K Pro</td>
                            <td style="font-family: monospace; color: var(--primary-blue);">₮ 2,800</td>
                            <td>Jan 12, 2024</td>
                            <td><span class="status-badge pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td class="order-id">#ORD-7826</td>
                            <td>Alex Chen</td>
                            <td>Headset Noise-Cancel</td>
                            <td style="font-family: monospace; color: var(--primary-blue);">₮ 1,800</td>
                            <td>Jan 10, 2024</td>
                            <td><span class="status-badge rejected">Rejected</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>
    </div>

</body>
</html>
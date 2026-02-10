{{-- resources/views/employee/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Nexus') }} | Employee Portal</title>
    
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
            --deep-black: #060608;
            --panel-bg: rgba(20, 20, 30, 0.6);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.05);
            --glass-highlight: rgba(255, 255, 255, 0.1);
            --neon-glow: 0 0 40px rgba(0, 212, 255, 0.1);
            --depth-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.8);
            --text-primary: rgba(255, 255, 255, 0.95);
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
            --success: #00d9a3;
            --warning: #ffb800;
            --danger: #ff4757;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }

        @keyframes pulse-soft {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.7; }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--deep-black);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Ambient Background */
        .ambient-bg {
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(ellipse at 80% 20%, rgba(0, 212, 255, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 20% 80%, rgba(184, 41, 221, 0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(8, 8, 16, 1) 0%, var(--deep-black) 100%);
            z-index: -2;
        }

        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -1;
            animation: pulse-soft 10s ease-in-out infinite;
        }

        .glow-orb-1 {
            width: 400px;
            height: 400px;
            background: rgba(0, 212, 255, 0.06);
            top: -100px;
            right: 10%;
        }

        .glow-orb-2 {
            width: 300px;
            height: 300px;
            background: rgba(184, 41, 221, 0.05);
            bottom: -50px;
            left: 5%;
            animation-delay: 5s;
        }

        /* Layout */
        .app-container {
            display: grid;
            grid-template-columns: 240px 1fr 320px;
            min-height: 100vh;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* Glass Panel Base */
        .glass-panel {
            background: var(--panel-bg);
            backdrop-filter: blur(20px) saturate(150%);
            -webkit-backdrop-filter: blur(20px) saturate(150%);
            border: 1px solid var(--glass-border);
            border-top: 1px solid var(--glass-highlight);
            border-radius: 16px;
            box-shadow: var(--depth-shadow);
            position: relative;
            overflow: hidden;
        }

        .glass-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Sidebar */
        .sidebar {
            padding: 32px 20px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            border-right: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--glass-border);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
        }

        .brand-icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .brand-text {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 1px;
        }

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
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s ease;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .nav-item:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(0, 212, 255, 0.2);
        }

        .nav-item.active {
            color: var(--text-primary);
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.15), rgba(184, 41, 221, 0.1));
            border: 1px solid rgba(0, 212, 255, 0.3);
            box-shadow: var(--neon-glow);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        .user-card {
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
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 16px;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
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
            color: var(--text-muted);
        }

        /* Main Content */
        .main-content {
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            overflow-y: auto;
        }

        /* Token Balance Card */
        .balance-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 8px;
        }

        .balance-card {
            padding: 28px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .balance-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .balance-label {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .balance-amount {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(0, 212, 255, 0.3);
            font-family: 'Courier New', monospace;
            letter-spacing: -1px;
        }

        .balance-sub {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .balance-sub strong {
            color: var(--success);
        }

        .quick-actions {
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(184, 41, 221, 0.15));
            border: 1px solid rgba(0, 212, 255, 0.4);
            color: var(--text-primary);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.15);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.3);
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

        /* Catalog Section */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 3px;
            height: 20px;
            background: linear-gradient(to bottom, var(--primary-blue), var(--primary-violet));
            border-radius: 2px;
        }

        .search-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .search-input {
            flex: 1;
            padding: 14px 20px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: rgba(0, 212, 255, 0.4);
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .category-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .tab {
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab:hover {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-primary);
        }

        .tab.active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.15), rgba(184, 41, 221, 0.1));
            border-color: rgba(0, 212, 255, 0.4);
            color: var(--text-primary);
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.1);
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .product-card {
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-4px);
            border-color: rgba(0, 212, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(0, 212, 255, 0.1);
        }

        .product-image {
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(184, 41, 221, 0.05));
            border-radius: 8px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(0, 212, 255, 0.1);
        }

        .product-image svg {
            width: 48px;
            height: 48px;
            fill: rgba(0, 212, 255, 0.6);
        }

        .product-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .product-category {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .btn-add {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            background: var(--primary-blue);
            color: white;
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.4);
        }

        /* Right Panel - Cart & Orders */
        .right-panel {
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            border-left: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .panel-section {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .badge {
            padding: 4px 10px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-violet));
            color: white;
            font-size: 11px;
            font-weight: 700;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
        }

        /* Cart Items */
        .cart-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cart-item {
            display: flex;
            gap: 12px;
            padding: 14px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            border-color: rgba(0, 212, 255, 0.2);
            background: rgba(0, 212, 255, 0.03);
        }

        .cart-item-image {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(184, 41, 221, 0.05));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cart-item-image svg {
            width: 24px;
            height: 24px;
            fill: rgba(0, 212, 255, 0.6);
        }

        .cart-item-info {
            flex: 1;
            min-width: 0;
        }

        .cart-item-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-item-price {
            font-size: 13px;
            color: var(--primary-blue);
            font-weight: 600;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 16px;
        }

        .qty-btn:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.3);
            color: var(--primary-blue);
        }

        .cart-item-qty {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            min-width: 20px;
            text-align: center;
        }

        .btn-remove {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid rgba(255, 71, 87, 0.2);
            color: var(--danger);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-left: 4px;
        }

        .btn-remove:hover {
            background: rgba(255, 71, 87, 0.2);
            box-shadow: 0 0 10px rgba(255, 71, 87, 0.2);
        }

        .cart-summary {
            padding-top: 16px;
            border-top: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .summary-row.total {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            padding-top: 12px;
            border-top: 1px solid var(--glass-border);
        }

        .summary-row.total .amount {
            color: var(--primary-blue);
            font-family: 'Courier New', monospace;
        }

        .btn-checkout {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
        }

        /* Order History */
        .order-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .order-item {
            padding: 16px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .order-item:hover {
            border-color: rgba(0, 212, 255, 0.2);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .order-id {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: var(--primary-blue);
            font-weight: 600;
        }

        .order-date {
            font-size: 11px;
            color: var(--text-muted);
        }

        .order-details {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 12px;
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-amount {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-badge.pending {
            background: rgba(255, 184, 0, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 184, 0, 0.3);
        }

        .status-badge.pending::before {
            background: var(--warning);
            box-shadow: 0 0 6px var(--warning);
            animation: pulse-soft 2s infinite;
        }

        .status-badge.approved {
            background: rgba(0, 217, 163, 0.1);
            color: var(--success);
            border: 1px solid rgba(0, 217, 163, 0.3);
        }

        .status-badge.approved::before {
            background: var(--success);
            box-shadow: 0 0 6px var(--success);
        }

        .status-badge.delivered {
            background: rgba(0, 212, 255, 0.1);
            color: var(--primary-blue);
            border: 1px solid rgba(0, 212, 255, 0.3);
        }

        .status-badge.delivered::before {
            background: var(--primary-blue);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            fill: currentColor;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .app-container { grid-template-columns: 220px 1fr 280px; }
        }

        @media (max-width: 1200px) {
            .app-container { grid-template-columns: 1fr; }
            .sidebar, .right-panel { display: none; }
            .main-content { padding: 20px; }
        }

        @media (max-width: 768px) {
            .balance-section { grid-template-columns: 1fr; }
            .product-grid { grid-template-columns: repeat(2, 1fr); }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary-blue), var(--primary-violet));
            border-radius: 3px;
        }
    </style>
</head>
<body>

    <div class="ambient-bg"></div>
    <div class="glow-orb glow-orb-1"></div>
    <div class="glow-orb glow-orb-2"></div>

    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
                <div class="brand-text">NEXUS</div>
            </div>

            <nav class="nav-section">
                <div class="nav-label">Menu</div>
                <a href="#" class="nav-item active">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    Catalog
                </a>
                <a href="#" class="nav-item">
                    <svg class="nav-icon" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    My Orders
                </a>
            </nav>

            <div class="user-card">
                <div class="user-avatar">JD</div>
                <div class="user-info">
                    <div class="user-name">John Doe</div>
                    <div class="user-role">Senior Developer</div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            
            <!-- Balance Section -->
            <div class="balance-section">
                <div class="glass-panel balance-card">
                    <div class="balance-label">Available Balance</div>
                    <div class="balance-amount">₮ 12,450</div>
                    <div class="balance-sub">Resets in <strong>14 days</strong> • Monthly: ₮ 15,000</div>
                </div>

                <div class="glass-panel balance-card" style="display: flex; flex-direction: column; justify-content: center; gap: 16px;">
                    <div class="balance-label">Quick Actions</div>
                    <div class="quick-actions">
                        <button class="btn btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
                            New Order
                        </button>
                        <button class="btn btn-secondary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                            History
                        </button>
                    </div>
                </div>
            </div>

            <!-- Catalog Section -->
            <div>
                <div class="section-header">
                    <div class="section-title">Internal Catalog</div>
                </div>

                <div class="search-bar">
                    <input type="text" class="search-input" placeholder="Search for items...">
                    <button class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    </button>
                </div>

                <div class="category-tabs">
                    <div class="tab active">All Items</div>
                    <div class="tab">Electronics</div>
                    <div class="tab">Furniture</div>
                    <div class="tab">Accessories</div>
                    <div class="tab">Software</div>
                </div>

                <div class="product-grid">
                    <div class="product-card">
                        <div class="product-image">
                            <svg viewBox="0 0 24 24"><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2H0c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2h-4zM4 5h16v11H4V5z"/></svg>
                        </div>
                        <div class="product-name">Wireless Keyboard MX Keys</div>
                        <div class="product-category">Electronics</div>
                        <div class="product-footer">
                            <div class="product-price">₮ 1,200</div>
                            <button class="btn-add">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image">
                            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </div>
                        <div class="product-name">4K Webcam Pro</div>
                        <div class="product-category">Electronics</div>
                        <div class="product-footer">
                            <div class="product-price">₮ 2,800</div>
                            <button class="btn-add">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image">
                            <svg viewBox="0 0 24 24"><path d="M7 14l5-5 5 5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                        </div>
                        <div class="product-name">Ergonomic Chair Pro</div>
                        <div class="product-category">Furniture</div>
                        <div class="product-footer">
                            <div class="product-price">₮ 8,500</div>
                            <button class="btn-add">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image">
                            <svg viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11z"/><circle cx="17.5" cy="17.5" r="4.5"/><path d="M3 13.5h8v8H3z"/></svg>
                        </div>
                        <div class="product-name">Monitor Light Bar</div>
                        <div class="product-category">Accessories</div>
                        <div class="product-footer">
                            <div class="product-price">₮ 850</div>
                            <button class="btn-add">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image">
                            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-5 14H4v-4h11v4zm0-5H4V9h11v4zm5 5h-4V9h4v9z"/></svg>
                        </div>
                        <div class="product-name">USB-C Docking Station</div>
                        <div class="product-category">Electronics</div>
                        <div class="product-footer">
                            <div class="product-price">₮ 3,400</div>
                            <button class="btn-add">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image">
                            <svg viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                        </div>
                        <div class="product-name">Noise-Cancel Headphones</div>
                        <div class="product-category">Electronics</div>
                        <div class="product-footer">
                            <div class="product-price">₮ 4,200</div>
                            <button class="btn-add">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image">
                            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        </div>
                        <div class="product-name">Desk Pad Pro XL</div>
                        <div class="product-category">Accessories</div>
                        <div class="product-footer">
                            <div class="product-price">₮ 450</div>
                            <button class="btn-add">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image">
                            <svg viewBox="0 0 24 24"><path d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7zm2.85 11.1l-.85.6V16h-4v-2.3l-.85-.6C7.8 12.16 7 10.63 7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.63-.8 3.16-2.15 4.1z"/></svg>
                        </div>
                        <div class="product-name">Smart Desk Lamp</div>
                        <div class="product-category">Furniture</div>
                        <div class="product-footer">
                            <div class="product-price">₮ 1,800</div>
                            <button class="btn-add">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <!-- Right Panel -->
        <aside class="right-panel">
            
            <!-- Cart Section -->
            <div class="panel-section">
                <div class="panel-header">
                    <div class="panel-title">Your Cart</div>
                    <span class="badge">3</span>
                </div>

                <div class="cart-list">
                    <div class="cart-item">
                        <div class="cart-item-image">
                            <svg viewBox="0 0 24 24"><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 5c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2H0c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2h-4zM4 5h16v11H4V5z"/></svg>
                        </div>
                        <div class="cart-item-info">
                            <div class="cart-item-name">Wireless Keyboard MX Keys</div>
                            <div class="cart-item-price">₮ 1,200</div>
                        </div>
                        <div class="cart-item-actions">
                            <button class="qty-btn">−</button>
                            <span class="cart-item-qty">1</span>
                            <button class="qty-btn">+</button>
                            <button class="btn-remove">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="cart-item">
                        <div class="cart-item-image">
                            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </div>
                        <div class="cart-item-info">
                            <div class="cart-item-name">4K Webcam Pro</div>
                            <div class="cart-item-price">₮ 2,800</div>
                        </div>
                        <div class="cart-item-actions">
                            <button class="qty-btn">−</button>
                            <span class="cart-item-qty">1</span>
                            <button class="qty-btn">+</button>
                            <button class="btn-remove">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="cart-item">
                        <div class="cart-item-image">
                            <svg viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                        </div>
                        <div class="cart-item-info">
                            <div class="cart-item-name">Noise-Cancel Headphones</div>
                            <div class="cart-item-price">₮ 4,200</div>
                        </div>
                        <div class="cart-item-actions">
                            <button class="qty-btn">−</button>
                            <span class="cart-item-qty">1</span>
                            <button class="qty-btn">+</button>
                            <button class="btn-remove">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>₮ 8,200</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax (0%)</span>
                        <span>₮ 0</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span class="amount">₮ 8,200</span>
                    </div>
                    <button class="btn btn-primary btn-checkout">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        Place Order
                    </button>
                </div>
            </div>

            <!-- Order History -->
            <div class="panel-section">
                <div class="panel-header">
                    <div class="panel-title">Recent Orders</div>
                    <a href="#" style="font-size: 12px; color: var(--primary-blue); text-decoration: none;">View All</a>
                </div>

                <div class="order-list">
                    <div class="order-item">
                        <div class="order-header">
                            <span class="order-id">#ORD-8932</span>
                            <span class="order-date">Jan 18</span>
                        </div>
                        <div class="order-details">Wireless Mouse, Desk Mat</div>
                        <div class="order-footer">
                            <span class="order-amount">₮ 1,650</span>
                            <span class="status-badge delivered">Delivered</span>
                        </div>
                    </div>

                    <div class="order-item">
                        <div class="order-header">
                            <span class="order-id">#ORD-8901</span>
                            <span class="order-date">Jan 15</span>
                        </div>
                        <div class="order-details">Mechanical Keyboard</div>
                        <div class="order-footer">
                            <span class="order-amount">₮ 2,400</span>
                            <span class="status-badge approved">Approved</span>
                        </div>
                    </div>

                    <div class="order-item">
                        <div class="order-header">
                            <span class="order-id">#ORD-8847</span>
                            <span class="order-date">Jan 12</span>
                        </div>
                        <div class="order-details">Monitor Arm, Cable Management</div>
                        <div class="order-footer">
                            <span class="order-amount">₮ 3,100</span>
                            <span class="status-badge pending">Pending</span>
                        </div>
                    </div>
                </div>
            </div>

        </aside>
    </div>

</body>
</html>
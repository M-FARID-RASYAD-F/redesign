{{-- resources/views/partials/crud-skeleton.blade.php --}}
@php
    $currentRoute = Route::currentRouteName() ?? '';
    
    if (str_contains($currentRoute, 'create') || str_contains($currentRoute, 'edit')) {
        $initialType = 'form';
    } elseif (str_contains($currentRoute, 'show')) {
        $initialType = 'detail';
    } elseif (str_contains($currentRoute, 'dashboard')) {
        $initialType = 'dashboard';
    } else {
        $initialType = 'table';
    }
@endphp

<div id="crudSkeletonLoader" class="crud-skeleton-wrapper" data-active-type="{{ $initialType }}" aria-hidden="true" role="status">
    
    {{-- ═══════════════════════════════════════════════════════════
         1. TABLE CRUD SKELETON (Index / List: News, Teachers, PPDB, Majors)
         ═══════════════════════════════════════════════════════════ --}}
    <div class="skeleton-layout skeleton-layout-table {{ $initialType === 'table' ? 'is-active' : '' }}">
        <!-- Header Skeleton -->
        <div class="skeleton-header">
            <div class="skeleton-header-texts">
                <div class="skeleton-shimmer skeleton-title-bar"></div>
                <div class="skeleton-shimmer skeleton-subtitle-bar"></div>
            </div>
            <div class="skeleton-shimmer skeleton-action-btn"></div>
        </div>

        <!-- Table Card Skeleton -->
        <div class="card skeleton-card">
            <div class="table-responsive">
                <table class="skeleton-table">
                    <thead>
                        <tr>
                            <th style="width: 35%;"><div class="skeleton-shimmer skeleton-th-cell" style="width: 120px;"></div></th>
                            <th style="width: 18%;"><div class="skeleton-shimmer skeleton-th-cell" style="width: 80px;"></div></th>
                            <th style="width: 15%;"><div class="skeleton-shimmer skeleton-th-cell" style="width: 70px;"></div></th>
                            <th style="width: 14%;"><div class="skeleton-shimmer skeleton-th-cell" style="width: 65px;"></div></th>
                            <th style="width: 18%; text-align: right;"><div class="skeleton-shimmer skeleton-th-cell" style="width: 75px; margin-left: auto;"></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < 5; $i++)
                        <tr class="skeleton-row-item">
                            <td>
                                <div class="skeleton-cell-identity">
                                    <div class="skeleton-shimmer skeleton-avatar-circle"></div>
                                    <div class="skeleton-identity-texts">
                                        <div class="skeleton-shimmer skeleton-item-title" style="width: {{ [180, 220, 160, 200, 190][$i % 5] }}px;"></div>
                                        <div class="skeleton-shimmer skeleton-item-subtitle" style="width: {{ [110, 95, 120, 105, 100][$i % 5] }}px;"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="skeleton-shimmer skeleton-badge-pill" style="width: {{ [75, 90, 65, 80, 85][$i % 5] }}px;"></div>
                            </td>
                            <td>
                                <div class="skeleton-shimmer skeleton-text-bar" style="width: {{ [100, 85, 110, 95, 90][$i % 5] }}px;"></div>
                            </td>
                            <td>
                                <div class="skeleton-shimmer skeleton-badge-status" style="width: {{ [70, 80, 75, 65, 75][$i % 5] }}px;"></div>
                            </td>
                            <td style="text-align: right;">
                                <div class="skeleton-action-group">
                                    <div class="skeleton-shimmer skeleton-btn-sm" style="width: 52px;"></div>
                                    <div class="skeleton-shimmer skeleton-btn-sm" style="width: 56px;"></div>
                                </div>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         2. FORM CRUD SKELETON (Create / Store, Edit / Update)
         ═══════════════════════════════════════════════════════════ --}}
    <div class="skeleton-layout skeleton-layout-form {{ $initialType === 'form' ? 'is-active' : '' }}">
        <!-- Header Skeleton -->
        <div class="skeleton-header">
            <div class="skeleton-header-texts">
                <div class="skeleton-shimmer skeleton-title-bar" style="width: 260px;"></div>
                <div class="skeleton-shimmer skeleton-subtitle-bar" style="width: 200px;"></div>
            </div>
        </div>

        <!-- Form Card Skeleton -->
        <div class="card skeleton-card" style="max-width: 800px;">
            <!-- Field 1 (Text Input) -->
            <div class="skeleton-form-group">
                <div class="skeleton-shimmer skeleton-form-label" style="width: 140px;"></div>
                <div class="skeleton-shimmer skeleton-form-input"></div>
            </div>

            <!-- Field 2 (Select / Dropdown) -->
            <div class="skeleton-form-group">
                <div class="skeleton-shimmer skeleton-form-label" style="width: 160px;"></div>
                <div class="skeleton-shimmer skeleton-form-input"></div>
            </div>

            <!-- Field 3 (Image / URL / File) -->
            <div class="skeleton-form-group">
                <div class="skeleton-shimmer skeleton-form-label" style="width: 170px;"></div>
                <div class="skeleton-shimmer skeleton-form-input"></div>
                <div class="skeleton-shimmer skeleton-form-hint" style="width: 220px;"></div>
            </div>

            <!-- Field 4 (Date / Status) -->
            <div class="skeleton-form-group">
                <div class="skeleton-shimmer skeleton-form-label" style="width: 150px;"></div>
                <div class="skeleton-shimmer skeleton-form-input"></div>
            </div>

            <!-- Field 5 (Content Textarea) -->
            <div class="skeleton-form-group">
                <div class="skeleton-shimmer skeleton-form-label" style="width: 180px;"></div>
                <div class="skeleton-shimmer skeleton-form-textarea"></div>
            </div>

            <!-- Form Action Buttons -->
            <div class="skeleton-form-actions">
                <div class="skeleton-shimmer skeleton-btn-primary" style="width: 160px;"></div>
                <div class="skeleton-shimmer skeleton-btn-outline" style="width: 90px;"></div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         3. DETAIL CRUD SKELETON (Show: PPDB Detail & Verifikasi)
         ═══════════════════════════════════════════════════════════ --}}
    <div class="skeleton-layout skeleton-layout-detail {{ $initialType === 'detail' ? 'is-active' : '' }}">
        <div class="skeleton-header">
            <div class="skeleton-header-texts">
                <div class="skeleton-shimmer skeleton-title-bar" style="width: 280px;"></div>
                <div class="skeleton-shimmer skeleton-subtitle-bar" style="width: 190px;"></div>
            </div>
        </div>

        <div class="skeleton-detail-grid">
            <div>
                <!-- Info Diri Card -->
                <div class="card skeleton-card">
                    <div class="skeleton-shimmer skeleton-card-heading" style="width: 190px;"></div>
                    <div class="skeleton-kv-table">
                        @for($k = 0; $k < 7; $k++)
                        <div class="skeleton-kv-row">
                            <div class="skeleton-shimmer skeleton-kv-key" style="width: {{ [130, 150, 120, 140, 110, 160, 130][$k % 7] }}px;"></div>
                            <div class="skeleton-shimmer skeleton-kv-val" style="width: {{ [200, 240, 170, 190, 220, 180, 210][$k % 7] }}px;"></div>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Dokumen Card -->
                <div class="card skeleton-card" style="margin-top: 20px;">
                    <div class="skeleton-shimmer skeleton-card-heading" style="width: 210px;"></div>
                    @for($d = 0; $d < 3; $d++)
                    <div class="skeleton-doc-row">
                        <div class="skeleton-shimmer skeleton-doc-name" style="width: 140px;"></div>
                        <div class="skeleton-shimmer skeleton-badge-status" style="width: 90px;"></div>
                        <div class="skeleton-shimmer skeleton-btn-sm" style="width: 110px;"></div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Side Card (Status Verifikasi) -->
            <div>
                <div class="card skeleton-card">
                    <div class="skeleton-shimmer skeleton-card-heading" style="width: 160px;"></div>
                    <div class="skeleton-shimmer skeleton-status-box"></div>
                    <div class="skeleton-shimmer skeleton-form-input" style="margin-top: 14px;"></div>
                    <div class="skeleton-shimmer skeleton-btn-primary" style="width: 100%; margin-top: 16px;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         4. DASHBOARD SKELETON (Overview & Stats)
         ═══════════════════════════════════════════════════════════ --}}
    <div class="skeleton-layout skeleton-layout-dashboard {{ $initialType === 'dashboard' ? 'is-active' : '' }}">
        <!-- Hero Banner Skeleton -->
        <div class="card skeleton-card skeleton-dashboard-hero">
            <div style="flex: 1;">
                <div class="skeleton-shimmer skeleton-badge-pill" style="width: 130px; margin-bottom: 12px;"></div>
                <div class="skeleton-shimmer skeleton-title-bar" style="width: 320px; height: 34px; margin-bottom: 10px;"></div>
                <div class="skeleton-shimmer skeleton-subtitle-bar" style="width: 85%; margin-bottom: 18px;"></div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <div class="skeleton-shimmer skeleton-badge-pill" style="width: 110px;"></div>
                    <div class="skeleton-shimmer skeleton-badge-pill" style="width: 130px;"></div>
                    <div class="skeleton-shimmer skeleton-badge-pill" style="width: 120px;"></div>
                </div>
            </div>
            <div class="skeleton-hero-actions-wrap">
                <div class="skeleton-shimmer skeleton-btn-primary" style="width: 150px;"></div>
                <div class="skeleton-shimmer skeleton-btn-outline" style="width: 150px;"></div>
            </div>
        </div>

        <!-- 4 Stat Cards Skeleton -->
        <div class="skeleton-stat-grid">
            @for($s = 0; $s < 4; $s++)
            <div class="card skeleton-card skeleton-stat-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                    <div class="skeleton-shimmer skeleton-stat-icon"></div>
                    <div class="skeleton-shimmer skeleton-badge-status" style="width: 60px;"></div>
                </div>
                <div class="skeleton-shimmer skeleton-title-bar" style="width: 90px; height: 36px; margin-bottom: 6px;"></div>
                <div class="skeleton-shimmer skeleton-subtitle-bar" style="width: 130px;"></div>
            </div>
            @endfor
        </div>

        <!-- Charts & Activity Grid Skeleton -->
        <div class="skeleton-dash-content-grid">
            <div class="card skeleton-card" style="height: 380px;">
                <div class="skeleton-shimmer skeleton-card-heading" style="width: 220px; margin-bottom: 20px;"></div>
                <div class="skeleton-shimmer" style="width: 100%; height: 280px; border-radius: 12px;"></div>
            </div>
            <div class="card skeleton-card" style="height: 380px;">
                <div class="skeleton-shimmer skeleton-card-heading" style="width: 180px; margin-bottom: 20px;"></div>
                @for($a = 0; $a < 4; $a++)
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--adm-table-border);">
                    <div class="skeleton-shimmer skeleton-avatar-circle" style="width: 36px; height: 36px;"></div>
                    <div style="flex: 1;">
                        <div class="skeleton-shimmer skeleton-item-title" style="width: 140px;"></div>
                        <div class="skeleton-shimmer skeleton-item-subtitle" style="width: 90px; margin-top: 4px;"></div>
                    </div>
                    <div class="skeleton-shimmer skeleton-badge-status" style="width: 50px;"></div>
                </div>
                @endfor
            </div>
        </div>
    </div>

</div>

<noscript>
    <style>
        #crudSkeletonLoader { display: none !important; }
        #crudPageContent { opacity: 1 !important; transform: none !important; position: static !important; visibility: visible !important; }
    </style>
</noscript>

{{-- resources/views/components/crud-skeleton.blade.php --}}
@props([
    'type' => 'table', // table, form, detail, dashboard
    'rows' => 5,
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'skeleton-layout skeleton-layout-' . $type . ' is-active ' . $class]) }}>
    @if($type === 'table')
        <!-- Header Skeleton -->
        <div class="skeleton-header">
            <div class="skeleton-header-texts">
                <div class="skeleton-shimmer skeleton-title-bar"></div>
                <div class="skeleton-shimmer skeleton-subtitle-bar"></div>
            </div>
            <div class="skeleton-shimmer skeleton-action-btn"></div>
        </div>

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
                        @for($i = 0; $i < $rows; $i++)
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
    @elseif($type === 'form')
        <div class="skeleton-header">
            <div class="skeleton-header-texts">
                <div class="skeleton-shimmer skeleton-title-bar" style="width: 260px;"></div>
                <div class="skeleton-shimmer skeleton-subtitle-bar" style="width: 200px;"></div>
            </div>
        </div>

        <div class="card skeleton-card" style="max-width: 800px;">
            @for($f = 0; $f < $rows; $f++)
            <div class="skeleton-form-group">
                <div class="skeleton-shimmer skeleton-form-label" style="width: {{ [140, 160, 170, 150, 180][$f % 5] }}px;"></div>
                @if($f === $rows - 1)
                    <div class="skeleton-shimmer skeleton-form-textarea"></div>
                @else
                    <div class="skeleton-shimmer skeleton-form-input"></div>
                @endif
            </div>
            @endfor

            <div class="skeleton-form-actions">
                <div class="skeleton-shimmer skeleton-btn-primary" style="width: 160px;"></div>
                <div class="skeleton-shimmer skeleton-btn-outline" style="width: 90px;"></div>
            </div>
        </div>
    @endif
</div>

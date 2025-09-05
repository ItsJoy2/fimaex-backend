@props(['icon', 'value', 'label', 'bg'])

<div class="col-md-6">
    <div class="d-flex align-items-center border rounded p-3 h-100 shadow-sm bg-light hover-shadow">
        <div class="icon-box bg-{{ $bg }} text-white rounded d-flex justify-content-center align-items-center me-3" style="width: 48px; height: 48px;">
            <i class="{{ $icon }}"></i>
        </div>
        <div>
            <div class="fw-bold fs-5">{!! $value !!}</div>
            <small class="text-muted">{{ $label }}</small>
        </div>
    </div>
</div>

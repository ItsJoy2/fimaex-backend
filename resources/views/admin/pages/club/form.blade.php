{{-- Club Name --}}
<div class="mb-3">
    <label class="form-label">Club Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $club->name ?? '') }}" required>
</div>

{{-- Club Image --}}
<div class="mb-3">
    <label class="form-label">Club Badge</label><br>
    @if(!empty($club) && $club->image)
        <img src="{{ asset('storage/' . $club->image) }}" width="80" class="mb-2 rounded">
    @endif
    <input type="file" name="image" class="form-control">
</div>

{{-- Required Refers --}}
<div class="mb-3">
    <label class="form-label">Required Refers</label>
    <input type="number" name="required_refers" class="form-control"
           value="{{ old('required_refers', $club->required_refers ?? '') }}" required>
</div>

{{-- Bonus Percentage --}}
<div class="mb-3">
    <label class="form-label">Bonus Percentage</label>
    <input type="number" name="bonus_percent" class="form-control" step="0.01"
           value="{{ old('bonus_percent', $club->bonus_percent ?? '') }}" required>
</div>

{{-- Incentive --}}
<div class="mb-3">
    <label class="form-label">Incentive</label>
    <input type="text" name="incentive" class="form-control"
           value="{{ old('incentive', $club->incentive ?? '') }}">
</div>

{{-- Incentive Image --}}
<div class="mb-3">
    <label class="form-label">Incentive Image</label><br>
    @if(!empty($club) && $club->incentive_image)
        <img src="{{ asset('storage/' . $club->incentive_image) }}" width="80" class="mb-2 rounded">
    @endif
    <input type="file" name="incentive_image" class="form-control">
</div>

{{-- Status --}}
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-control" required>
        <option value="1" {{ old('status', $club->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', $club->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div>

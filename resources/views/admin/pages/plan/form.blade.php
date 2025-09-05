<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $plan->name ?? '') }}" required>
</div>

    <div class="form-group">
        <label>Icon</label>
        <input type="file" name="icon" class="form-control">
        @if($plan->icon)
            <img src="{{ asset('storage/' . $plan->icon) }}" alt="Icon" style="width:40px; height:40px; object-fit:cover; margin-top:5px;">
        @endif
    </div>

<div class="form-group">
    <label>Amount</label>
   <input type="number" name="amount" class="form-control" value="{{ old('amount', $plan->amount ?? 0) }}" required>
</div>


<div class="form-group">
    <label>Referral Commission ($)</label>
    <input type="number" name="refer_bonus" class="form-control" value="{{ old('refer_bonus', $plan->refer_bonus ?? 0) }}">
</div>

<div class="form-group">
    <label>Status</label>
    <select name="active" class="form-control">
        <option value="1" {{ old('active', $plan->active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('active', $plan->active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div>

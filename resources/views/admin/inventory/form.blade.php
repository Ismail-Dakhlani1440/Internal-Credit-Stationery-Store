<div class="form-row">
    <div class="form-group">
        <label class="form-label">
            Product Name <span class="required">*</span>
        </label>
        <input type="text"
            name="name"
            class="form-control"
            value="{{ old('name', $product->name ?? '') }}"
            required>
    </div>

    <div class="form-group">
        <label class="form-label">
            Category <span class="required">*</span>
        </label>
        <select name="categorie_id" class="form-control" required>
            <option value="">Select category</option>

            @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('categorie_id', $product->categorie_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->title }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label class="form-label">
            Stock <span class="required">*</span>
        </label>
        <input type="number"
            name="stock"
            class="form-control"
            value="{{ old('stock', $product->stock ?? '') }}"
            min="0"
            required>
    </div>

    <div class="form-group">
        <label class="form-label">
            Tokens Required <span class="required">*</span>
        </label>
        <input type="number"
            name="tokens_required"
            class="form-control"
            value="{{ old('tokens_required', $product->tokens_required ?? '') }}"
            min="0"
            required>
    </div>
</div>
<div class="form-group">
    <label class="form-label">Premium Product</label>

    <div style="margin-top:8px;">
        <input type="checkbox"
               name="premium"
               value="1"
               {{ old('premium', $product->premium ?? false) ? 'checked' : '' }}>
        <span style="margin-left:8px;">Mark as Premium</span>
    </div>
</div>
<div class="form-group">
    <label class="form-label">Product Image</label>
    <input type="file" name="image" class="form-control">
</div>
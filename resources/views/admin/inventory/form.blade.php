<div class="form-row">
    <div class="form-group">
        <label class="form-label">
            Product Name <span class="required">*</span>
        </label>
        <input type="text" 
               name="name" 
               class="form-control" 
               value="{{ old('name', $product->name ?? '') }}" 
               placeholder="Enter product name"
               required>
    </div>

    <div class="form-group">
        <label class="form-label">
            Category <span class="required">*</span>
        </label>
        <select name="category" class="form-control" required>
            <option value="">Select a category</option>
            <option value="Electronics" {{ old('category', $product->category ?? '') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
            <option value="Furniture" {{ old('category', $product->category ?? '') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
            <option value="Office Supplies" {{ old('category', $product->category ?? '') == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
            <option value="Equipment" {{ old('category', $product->category ?? '') == 'Equipment' ? 'selected' : '' }}>Equipment</option>
            <option value="Other" {{ old('category', $product->category ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label class="form-label">
            Quantity <span class="required">*</span>
        </label>
        <input type="number" 
               name="quantity" 
               class="form-control" 
               value="{{ old('quantity', $product->quantity ?? '') }}" 
               placeholder="0"
               min="0"
               required>
    </div>

    <div class="form-group">
        <label class="form-label">
            Price ($) <span class="required">*</span>
        </label>
        <input type="number" 
               name="price" 
               class="form-control" 
               value="{{ old('price', $product->price ?? '') }}" 
               placeholder="0.00"
               step="0.01"
               min="0"
               required>
    </div>
</div>

<div class="form-group">
    <label class="form-label">
        Description
    </label>
    <textarea name="description" 
              class="form-control" 
              rows="4" 
              placeholder="Enter product description (optional)">{{ old('description', $product->description ?? '') }}</textarea>
</div>
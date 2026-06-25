<div class="mb-4">
    <label for="category_id" class="block text-gray-700 mb-2">Kategori *</label>
    <select id="category_id" name="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror" required>
        <option value="">Pilih Kategori</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ old('category_id', isset($product) ? $product->category_id : '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
    @error('category_id')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

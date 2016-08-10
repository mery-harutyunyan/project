<a href="{{ route('products.edit', [$product->id]) }}" class="btn btn-xs btn-primary">
    <i class="glyphicon glyphicon-edit"></i> Edit
</a>

<button data-href="{{ route('products.destroy', $product->id) }}" data-method="delete" class="delete-product btn btn-xs btn-danger">
    <i class="glyphicon glyphicon-trash"></i>Delete
</button>
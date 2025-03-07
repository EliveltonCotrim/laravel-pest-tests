<div>
    <ul>
        <li>Product A</li>
        <li>Product B</li>

        @foreach ($products as $product)
            <li>{{ $product->title }}</li>
        @endforeach
    </ul>
</div>

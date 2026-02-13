<x-layout>

<style>
.orders-container{
    max-width:900px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:8px;
}
.order-card{
    border:1px solid #ddd;
    padding:15px;
    margin-bottom:10px;
    display:flex;
    justify-content:space-between;
    cursor:pointer;
}
.order-products{
    display:none;
    background:#f9f9f9;
    padding:15px;
    margin-bottom:20px;
}
</style>

<div class="orders-container">

<h2>📦 My Orders</h2>

@forelse($orders as $order)

<div class="order-card" onclick="toggleOrder({{ $order->id }})">
    <div>
        <b>Order #{{ $order->id }}</b><br>
        {{ $order->created_at->format('d M Y') }}
    </div>

    <div>
        {{ ucfirst($order->status) }}<br>
        🪙 {{ $order->total_price }}
    </div>
</div>

<div class="order-products" id="order-{{ $order->id }}">
    <table style="width:100%; border-collapse:collapse; margin-top:10px;">
    <thead>
        <tr style="background:#f1f1f1; text-align:left;">
            <th style="padding:8px;">Product</th>
            <th style="padding:8px;">Quantity</th>
            <th style="padding:8px;">Tokens</th>
            <th style="padding:8px;">Type</th>
            <th style="padding:8px;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->products as $product)
        <tr style="border-bottom:1px solid #ddd;">
            <td style="padding:8px;">
                {{ $product->name }}
            </td>

            <td style="padding:8px;">
                {{ $product->pivot->quantity }}
            </td>

            <td style="padding:8px;">
                🪙 {{ $product->pivot->tokens_required * $product->pivot->quantity }}
            </td>

            <td style="padding:8px;">
                @if($product->premium)
                    <span style="color:#c0392b; font-weight:bold;">
                        Needs manager approval
                    </span>
                @else
                    <span style="color:#27ae60;">
                        Normal
                    </span>
                @endif
            </td>

            <td style="padding:8px;">
                @if($product->pivot->status == 'pending')
                    <span style="color:#f39c12;">Pending</span>
                @elseif($product->pivot->status == 'approved')
                    <span style="color:#27ae60;">Accepted</span>
                @else
                    <span style="color:#c0392b;">Rejected</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@empty
<p>No orders yet</p>
@endforelse

</div>

<script>
function toggleOrder(id){
    const box = document.getElementById('order-'+id);
    box.style.display = box.style.display === 'block' ? 'none' : 'block';
}
</script>

</x-layout>
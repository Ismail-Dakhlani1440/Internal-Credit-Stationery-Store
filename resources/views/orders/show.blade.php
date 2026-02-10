<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Order Details</h1>
    <div>
        <foreach($orders as $order)>
            <div>
                <h2>Order #{{ $order->id }}</h2>
                <p>Customer: {{ $order->user->name }}</p>
                <p>Total Amount: ${{ $order->total_price }}</p>
            </div>
        <endforeach>
        
    </div>
</body>
</html>
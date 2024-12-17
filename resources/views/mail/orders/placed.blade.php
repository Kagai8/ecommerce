<x-mail::message>
# Order Placed Successfully!

Thank you for order. Your order nuumber is: {{ $order->id }}

<x-mail::button :url="$url">
View Your Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

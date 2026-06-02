<x-mail::message>

# Invoice {{ $invoice->invoice_number }}

Dear {{ $invoice->customer->name }},

Here are your invoice details:

| | |
|---|---|
| **Invoice Number** | {{ $invoice->invoice_number }} |
| **Amount Due** | ${{ number_format($invoice->amount, 2) }} |
| **Due Date** | {{ \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') }} |
| **Status** | {{ ucfirst($invoice->status) }} |

&nbsp;

Please click the button below to proceed with the payment.

<x-mail::button :url="$payUrl" color="success">
    Pay Now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}

</x-mail::message>
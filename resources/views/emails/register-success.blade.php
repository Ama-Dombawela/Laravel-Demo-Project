@component('mail::message')
# Welcome Aboard, {{ $user->name }}!

You have been successfully registered as an Admin. You now have full access to the CRM dashboard to manage customers, proposals, invoices and transactions.

@component('mail::button', ['url' => url('/dashboard')])
Go to Admin Dashboard
@endcomponent

If you did not create this account, please contact support immediately.

Thanks,
{{ config('app.name') }}
@endcomponent
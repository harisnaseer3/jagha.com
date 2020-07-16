@component('mail::message')
# Greetings

MR. {{ $name }}, hope your are doing good.
A(n)  {{ $visitor }}, view your property and sent you an email.

<div><strong>Message</strong></div>
{{ $message }}

<div><strong>Contact Details</strong></div>
<div>Name  : {{ $user_name }} </div>
<div>Email : {{ $email }} </div>
<div>Phone : {{ $phone }} </div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

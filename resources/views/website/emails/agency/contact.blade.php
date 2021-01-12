@component('mail::message')
# Greetings

Mr. {{ $name }}, hope your are doing good.
A {{ $visitor }}, has recently viewed your property and sent you an email.

# Message
{{ strip_tags($message) }}


# Contact Details of the Visitor
Name  : {{ $user_name }} <br>
Email : {{ $email }} <br>
Phone : {{ $phone }} <br>
Location : {{ $ip_location }} <br>

# Regards,<br>
{{--<img src="{{('img/logo/logo-with-text.png') }}" alt="About Pakistan"/>--}}
About Pakistan Properties
@endcomponent

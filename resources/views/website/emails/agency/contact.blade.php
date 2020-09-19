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

# Regards,<br>
{{--<img src="{{('img/logo/logo-with-text.png') }}" alt="About Pakistan"/>--}}

Pakistan history, culture, civilization, architecture, politics, constitution, election, music, drama, film, theatre, food, natural resources and more.
@endcomponent

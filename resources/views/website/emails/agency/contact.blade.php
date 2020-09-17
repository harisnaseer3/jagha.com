@component('mail::message')
# Greetings

MR. {{ $name }}, hope your are doing good.
A {{ $visitor }}, view your property and sent you an email.

# Message
{{ $message }}


# Contact Details of the visitor
Name  : {{ $user_name }} <br>
Email : {{ $email }} <br>
Phone : {{ $phone }} <br>

# Regards,<br>

<img src="{{asset('img/logo/logo-with-text.png')}}" alt="About Pakistan" data-rjs="2"/><br>
Pakistan history, culture, civilization, architecture, politics, constitution, election, music, drama, film, theatre, food, natural resources and more.
@endcomponent

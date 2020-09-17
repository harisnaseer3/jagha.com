@component('mail::message')
# Greetings

Mr. {{ $name }}, hope your are doing good.
A {{ $visitor }}, has recently viewed your property and sent you an email.

# Message
{{ html_entity_decode($message, ENT_HTML5) }}


# Contact Details of the visitor
Name  : {{ $user_name }} <br>
Email : {{ $email }} <br>
Phone : {{ $phone }} <br>

# Regards,<br>

<img src="{{asset('img/logo/logo-with-text.png')}}" alt="About Pakistan" data-rjs="2"/><br>
Pakistan history, culture, civilization, architecture, politics, constitution, election, music, drama, film, theatre, food, natural resources and more.
@endcomponent

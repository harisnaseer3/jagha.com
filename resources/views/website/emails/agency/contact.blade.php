@component('mail::message')
# Greetings

MR. {{ $name }}, hope your are doing good.
A(n)  {{ $visitor }}, view your property and sent you an email.

<div><strong>Message</strong></div>
<div>{{ $message }}</div>


# Contact Details
<div>Name  : {{ $user_name }} </div>
<div>Email : {{ $email }} </div>
<div>Phone : {{ $phone }} </div>

# Regards,<br>
<div class="foot-widget left relative">
    <div class="foot-logo left realtive">
        <img src="{{asset('img/logo/logo-with-text.png')}}" alt="About Pakistan" data-rjs="2"/>
    </div><!--foot-logo-->
    <div class="foot-info-text left relative">
        <p>Pakistan history, culture, civilization, architecture, politics, constitution, election, music, drama, film, theatre, food, natural resources and more.</p></div>
</div>
@endcomponent

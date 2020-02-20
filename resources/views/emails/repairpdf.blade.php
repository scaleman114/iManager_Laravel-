@component('mail::message')
# Your repair sheet

We have sent your repair sheet as an attachment to this message.

@component('mail::button', ['url' => 'https://www.weigh-till.co.uk'])
Visit Weigh-Till
@endcomponent


Kind Regards<br>
David Darlison<br>
{{ env('COMP_NAME') }}<br>
{{ config('app.name') }}
@endcomponent

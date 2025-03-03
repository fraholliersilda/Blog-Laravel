<x-mail::message>
# Users Count Monthly - {{$monthName}}

The number of users registered in {{$monthName}} is: {{ $userCount }}


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

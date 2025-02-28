<x-mail::message>
# Profile Deleted

Hello {{ $userName }},

Your profile has been successfully deleted.

If this was not you, please [contact support](mailto:support@example.com) immediately.

<x-mail::button :url="url('/login')">
Go Back to Login
</x-mail::button>

Thanks for being with us!
**{{ config('app.name') }} Team**
</x-mail::message>

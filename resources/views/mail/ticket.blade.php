@component('mail::message')

    Dear {{ $username }},

    Thank you for purchasing a ticket for the movie "{{ $title }}". We look forward to having you be a part of this cinematic experience.

    Click on the following link to download your PDF ticket:

    @component('mail::button', ['url' => $link])

        Ticket

    @endcomponent

    If you have any questions or need further assistance, feel free to contact us.

    Thank you,
    "{{ config('app.name') }}"

    @component('mail::footer')
        Enjoy the movie! If you have trouble printing the ticket, you can also download it from the following link: [{{ $link }}]({{ $link }})
    @endcomponent

@endcomponent


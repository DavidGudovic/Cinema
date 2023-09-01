@component('mail::message')

    Poštovani {{ $reclamation->user->username }},

    Žao nam je da vas obavestimo da vaša reklamacija pod brojem #{{ $reclamation->id }} nije prihvaćena.

    Zahtev povezan sa ovom reklamacijom: #{{ $reclamation->businessRequest->id }}

    Komentar menadžera u vezi sa vašom reklamacijom:
    {{ $reclamation->comment }}

    Razumemo da ovo može biti razočaravajuće. Ako imate dodatnih pitanja ili želite više informacija o razlozima odbijanja, slobodno nas kontaktirajte.

    Hvala vam što koristite "{{ config('app.name') }}" usluge.

    Srdačan pozdrav,
    "{{ config('app.name') }}"

@endcomponent

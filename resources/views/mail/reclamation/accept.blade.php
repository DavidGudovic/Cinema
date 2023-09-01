@component('mail::message')

    Poštovani {{ $reclamation->user->username }},

    Obaveštavamo vas da je vaša reklamacija pod brojem #{{ $reclamation->id }} prihvaćena.

    Zahtev povezan sa ovom reklamacijom: #{{ $reclamation->businessRequest()->id }}

    Komentar menadžera u vezi sa vašom reklamacijom:
    {{ $reclamation->comment }}

    Zadovoljstvo nam je da vam izađemo u susret i rešimo problem. Ako imate dodatnih pitanja ili potrebu za daljom asistencijom, slobodno nas kontaktirajte.

    Hvala vam na poverenju u "{{ config('app.name') }}".

    Srdačan pozdrav,
    "{{ config('app.name') }}"

@endcomponent

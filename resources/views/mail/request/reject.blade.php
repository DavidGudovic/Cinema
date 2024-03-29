@component('mail::message')

Poštovani {{ $businessRequest->user->username }},

Nažalost, moramo vas obavestiti da je vaš zahtev odbijen.

@if($is_advert)
Tip zahteva: Reklamiranje
Naslov: {{ $businessRequest->requestable->title }}
Delatnost: {{ $businessRequest->requestable->company }}
URL: {{ $businessRequest->requestable->url }}
Količina: {{ $businessRequest->requestable->quantity }}
@else
Tip zahteva: Rentiranje
Sala: {{ $businessRequest->requestable->hall_id }}
Datum: {{ $businessRequest->requestable->start_time->format('Y/m/d') }}
@endif

Komentar menadžera: {{ $businessRequest->comment }}

Ukoliko želite dodatne informacije ili objašnjenje o razlozima odbijanja, slobodno nas kontaktirajte.

Žao nam je što nismo mogli da udovoljimo vašem zahtevu ovog puta. Nadamo se da ćemo imati priliku da sarađujemo u budućnosti.

Srdačno,
"{{ config('app.name') }}"

@endcomponent

@component('mail::message')

Poštovani {{ $businessRequest->user->username }},

@if($is_advert)
Vaš zahtev za reklamiranje je prihvaćen.
Naslov: {{ $businessRequest->requestable->title }}
Delatnost: {{ $businessRequest->requestable->company }}
URL: {{ $businessRequest->requestable->url }}
Količina: {{ $businessRequest->requestable->quantity }}
@else
Vaš zahtev za rezervaciju je prihvaćen.
Sala: {{ $businessRequest->requestable->hall_id }}
Trajanje: {{ $businessRequest->requestable->duration }}
Datum početka: {{ $businessRequest->requestable->start_date }}
@endif
Komentar menadžera: {{ $businessRequest->comment }}

Hvala vam što ste izabrali naše usluge. Ukoliko imate bilo kakvih pitanja ili potrebu za dodatnom pomoći, slobodno nas kontaktirajte.

Srdačno,
"{{ config('app.name') }}"

@endcomponent

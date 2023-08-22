@component('mail::message')
Poštovani Korisniče,

Nažalost, obaveštavamo vas da je projekcija filma {{$screening->movie->title }} zakazana za {{ Carbon\Carbon::parse($screening->start_time)->format('d/m H:i') }} otkazana.

Budući da ste kupili ulaznice za ovu projekciju, biće vam ponuđena zamena ili povrat novca. Molimo vas da nas kontaktirate na našoj podršci za više informacija.

Hvala na razumevanju,
{{ config('app.name') }}
@component('mail::footer')
Za dodatne informacije, posetite naš sajt ili nas kontaktirajte putem emaila ili telefona.
@endcomponent
@endcomponent

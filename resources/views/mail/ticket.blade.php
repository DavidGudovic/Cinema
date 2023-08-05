@component('mail::message')

Poštovani {{ $username }},

Hvala vam što ste kupili kartu za film "{{ $title }}". Radujemo se što ćete biti deo ovog filmskog doživljaja.

Kliknite na sledeći link kako bi ste preuzeli PDF karte:

@component('mail::button', ['url' => $link])

Karta

@endcomponent

Ukoliko imate bilo kakvih pitanja ili potrebu za dodatnom pomoći, slobodno nas kontaktirajte.

Hvala,
"{{ config('app.name') }}"

@component('mail::footer')
Uživajte u filmu! Ukoliko imate problema sa štampanjem karte, možete je preuzeti i na sledećem linku: [{{ $link }}]({{ $link }})
@endcomponent

@endcomponent


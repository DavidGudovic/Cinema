@component('mail::message')

Poštovani Korisniče,

Hvala vam što ste se registrovali na našem sajtu. Molimo vas da potvrdite vašu email adresu kako biste završili registraciju i aktivirali svoj nalog.

Kliknite na sledeći link kako biste potvrdili svoj email:

@component('mail::button', ['url' => $link])

Potvrdi email

@endcomponent

Ukoliko niste vi kreirali ovaj nalog, molimo vas da zanemarite ovu poruku.

Hvala,
"{{ config('app.name') }}"

@component('mail::footer')
Ukoliko dugme ne radi, kliknite ili iskopirajte sledeći link: [{{ $link }}]({{ $link }})
@endcomponent

@endcomponent

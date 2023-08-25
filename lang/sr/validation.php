<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'required' => 'Polje \':attribute\' je obavezno!',
    'unique' => 'Ova vrednost već postoji!',
    'confirmed' => ':attribute se ne podudara!',
    'email' => 'Polje mora biti validna email adresa',
    'current_password' => 'Netačna lozinka',
    'url_field' => ':attribute mora biti validan URL',
    'date' => ':attribute mora biti validan datum',
    'integer' => ':attribute mora biti ceo broj',
    'image' => ':attribute mora biti slika',
    'url' => ':attribute mora biti validan URL',
    'mimes' => ':attribute mora biti png, jpeg ili webp formata',
    'min' => [
        'array' => ':attribute moraju imati minimum :min selekciju.',
        'file' => ':attribute mora biti minimum :min kilobita.',
        'numeric' => ':attribute mora biti minimum :min.',
        'string' => ':attribute mora biti minimum :min karaktera',
    ],
    'max' => [
        'array' => ':attribute ne sme imati više od :max elemenata.',
        'file' => ':attribute ne sme biti veći od :max kilobita.',
        'numeric' => ':attribute ne sme biti veći od :max.',
        'string' => ':attribute ne sme biti veći od :max karaktera.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'username' => 'Korisničko ime',
        'password' => 'Lozinka',
        'name' => 'Ime',
        'new_password' => 'Nova lozinka',
        'current_password' => 'Lozinka',
        'role' => 'Tip profila',
        'text' => 'Tekst',
        'price' => 'Cena',
        'start_time' => 'Početak',
        'end_time' => 'Kraj',
        'hall_id' => 'Hala',
        'user_id' => 'Korisnik',
        'business_request_id' => 'Zahtev',
        'hall_name' => 'Naziv hale',
        'hall_description' => 'Opis hale',
        'hall_image' => 'Slika hale',
        'hall_price' => 'Cena hale',
        'hall_capacity' => 'Kapacitet hale',
        'advert_url' => 'URL oglasa',
        'company' => 'Delatnost',
        'title' => 'Naslov',
        'quantity' => 'Količina',
        'director' => 'Režiser',
        'description' => 'Opis',
        'banner' => 'Baner',
        'poster' => 'Poster',
        'trailer_url' => 'URL trejlera',
        'release_date' => 'Datum izlaska',
        'duration' => 'Trajanje',
        'genre_id' => 'Žanr',
        'image_url' => 'URL slike',
        'is_showcased' => 'Istaknut',
        'response' => 'Odgovor',
        'selected_dates' => 'Datumi',
        'selected_times' => 'Termini',
    ],

];



@extends('templates.administration')

@section('content')
  <div class="flex flex-col-reverse md:flex-row gap-6 justify-center items-center w-full h-full">
      <div class="flex flex-col gap-6 w-full h-full">
          <div class="flex justify-between w-full h-2/3 bg-dark-blue rounded-2xl p-4">
              <div class="h-full w-full border border-white"></div>
              <div class="flex flex-col justify-center items-center gap-6 text-center h-full w-24">
                  <p>Tekst</p>
                  <p>Tekst</p>
                  <p>Tekst</p>
                  <p>Tekst</p>
                  <p>Tekst</p>
              </div>
          </div>

          <div class="flex flex-col gap-6 w-full h-full">
              <div class="w-full h-36 bg-dark-blue rounded-2xl p-4"></div>
              <div class="w-full h-full bg-dark-blue rounded-2xl p-4"></div>
          </div>

      </div>
      <div class="flex flex-col gap-6 w-full h-full bg-dark-blue rounded-2xl p-4">
          <div class="w-full h-full border border-white"></div>
          <div class="w-full h-full border border-white"></div>
      </div>
  </div>
@endsection

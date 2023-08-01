@extends('templates.user-profile')

@section('background-pattern') bg-user-profile bg-cover bg-no-repeat bg-center  @endsection

@section('window')
  <div class="flex h-full w-full flex-col gap-6 border border-white text-white p-5 md:p-16 md:px-20 bg-gray-950 bg-opacity-80  ">
    @if(session()->has('status'))
      <p class='text-center font-bold mb-5
      @if(session('status') == 'error') text-red-600 @else text-green-400 @endif'>{{session('status_msg')}}</p>
    @endif
    <!-- Info form -->
    <form class="flex flex-col gap-4 w-full" action="{{route('user.update', auth()->user())}}" method="post">
      <!--Status message display-->
      <!-- End status message -->
    <!--Fields-->
      @csrf
      @method('PATCH')
      <!-- Username -->
      <div class="flex flex-col gap-2">
        <p class="font-bold ">Korisničko Ime</p>
        <input type="text" class="form-control @error('username') border-red-500 @enderror" name="username" value="{{auth()->user()->username}}">
        @error('username')
          <div class="text-red-500 mt-2 text-sm">
             {{$message}}
          </div>
        @enderror
      </div>
      <!-- Email -->
      <div class="flex flex-col gap-2">
        <p class="font-bold ">E-mail</p>
        <input type="text" class="form-control @error('email') border-red-500 @enderror" name="email" value="{{auth()->user()->email}}">
        @error('email')
          <div class="text-red-500 mt-2 text-sm">
             {{$message}}
          </div>
        @enderror
      </div>
      <!-- Name -->
      <div class="flex flex-col gap-2">
        <p class="font-bold ">Ime</p>
        <input type="text" class="form-control @error('name') border-red-500 @enderror" name="name" value="{{auth()->user()->name}}">
        @error('name')
          <div class="text-red-500 mt-2 text-sm">
             {{$message}}
          </div>
        @enderror
      </div>
      <!-- Current pass -->
      <div class="flex flex-col gap-2">
        <p class="font-bold ">Trenutna lozinka</p>
        <input type="password" class="form-control @error('current_password') border-red-500 @enderror" name="current_password" placeholder="Unesite lozinku">
        @error('current_password')
          <div class="text-red-500 mt-2 text-sm">
             {{$message}}
          </div>
        @enderror
      </div>
      <!-- New pass or confirm -->
      <div class="flex flex-col gap-2">
        <p class="font-bold ">Nova lozinka</p>
        <input type="password" class="form-control @error('new_password') border-red-500 @enderror" name="new_password" placeholder="Ponovite staru ako ne menjate!">
        @error('new_password')
          <div class="text-red-500 mt-2 text-sm">
             {{$message}}
          </div>
        @enderror
      </div>
    <!-- End fields -->
        <!-- Submit-->
        <input type="submit" class="form-btn md:w-44 rounded-lg" name="submit" value="Izmeni informacije">
    </form>
    <!-- End info form -->
  </div>
@endsection


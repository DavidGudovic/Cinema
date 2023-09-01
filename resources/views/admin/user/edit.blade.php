@extends('templates.administration')

@section('content')
    <div class="flex flex-col gap-12 justify-center items-center w-full h-full">
        <h2 class="text-2xl font-extrabold">Izmena korisnika</h2>
        <form action="{{route('admin.users.update', $user)}}" method='POST' class="flex flex-col gap-4 md:w-[30rem]">
            @csrf
            @method('PATCH')
            <!-- Email -->
            <div class="form-group relative">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Unesite email"
                       value="{{old('email') ?? $user->email}}" class="form-control border @error('email') border-red-700 @else border-gray-300 @enderror rounded-md">
                @error('email')
                <span class="absolute top-0 right-0 text-red-700 text-sm">{{$message}}</span>
                @enderror
            </div>
            <!-- End Email -->

            <!-- Username -->
            <div class="form-group relative">
                <label for="username">Korisničko ime</label>
                <input type="text" name="username" id="username" placeholder="Unesite korisničko ime"
                       value="{{old('username') ?? $user->username}}"
                       class="form-control border @error('username') border-red-700 @else border-gray-300 @enderror rounded-md">
                @error('username')
                <span class="absolute top-0 right-0 text-red-700 text-sm">{{$message}}</span>
                @enderror
            </div>
            <!-- End Username -->

            <!-- Name -->
            <div class="form-group relative">
                <label for="name">Ime</label>
                <input type="text" name="name" id="name" placeholder="Unesite ime"
                       value="{{old('name') ?? $user->name}}" class="form-control border @error('name') border-red-700 @else border-gray-300 @enderror rounded-md">
                @error('name')
                <span class="absolute top-0 right-0 text-red-700 text-sm">{{$message}}</span>
                @enderror
            </div>
            <!-- End Name -->

            <!-- Password -->
            <div class="form-group relative">
                <label for="new_password">Lozinka</label>
                <input type="password" name="new_password" id="new_password" placeholder="Prazno ako ne menjate"
                       class="form-control border @error('new_password') border-red-700 @else border-gray-300 @enderror rounded-md">
                @error('new_password')
                <span class="absolute top-0 right-0 text-red-700 text-sm">{{$message}}</span>
                @enderror
            </div>
            <!-- End Password -->

            <!-- Role -->
            <div class="form-group relative">
                <label for="role">Rola</label>
                <select name="role" id="role" class="form-control border @error('role') border-red-700 @else border-gray-300 @enderror rounded-md">
                    @foreach($roles as $role => $name)
                        <option value="{{$role}}" {{$user->role->value == $role ? 'selected' : ''}}>{{$name}}</option>
                    @endforeach
                </select>
                @error('role')
                <span class="absolute top-0 right-0 text-red-700 text-sm">{{$message}}</span>
                @enderror
            </div>
            <!-- End role -->
            <!-- Actions -->
            <div class="flex mt-2 gap-6">
                <button type="submit" class="p-2.5 w-full text-white rounded-xl border bg-gray-700 hover:text-red-700 hover:border-red-700 cursor-pointer">Izmeni</button>
                <button type="reset" class="p-2.5 w-full text-white rounded-xl border bg-gray-700 hover:text-red-700 hover:border-red-700 cursor-pointer">Resetuj</button>
            </div>
            <!-- End Actions -->
            @if(session()->has('success'))
                <span class="text-center mt-2 text-green-300">Korisnik uspešno izmenjen</span>
            @endif
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')

@if (auth()->check())
    <div
        class="max-w-2xl mx-4 sm:max-w-sm md:max-w-sm lg:max-w-sm xl:max-w-sm sm:mx-auto md:mx-auto lg:mx-auto xl:mx-auto mt-16 bg-white shadow-xl rounded-lg text-gray-900">
        <div class="rounded-t-lg h-32 overflow-hidden">
            <img class="object-cover object-top w-full"
                src='https://cdn.pixabay.com/photo/2020/11/07/20/29/laboratory-5722327_1280.jpg' alt='Vaccine'>
        </div>
        <div
            class="mx-auto w-32 h-32 relative -mt-16 border-white rounded-full overflow-hidden flex items-center justify-center">
            <img class="object-cover object-center h-32" src="{{ auth()->user()->username_initials }}"
                alt='{{ auth()->user()->name }}'>
        </div>
        <div class="text-center mt-2">
            <h2 class="font-semibold mb-8">{{auth()->user()->name}}</h2>
            <h5>{{ auth()->user()->email }}</h5>
            <p class="text-slate-200 my-4 py-4 font-bold capitalize 
                    {{ auth()->user()->status === \App\Enums\UserStatus::NOT_SCHEDULED ? 'bg-red-600' :
            (auth()->user()->status === \App\Enums\UserStatus::SCHEDULED ? 'bg-blue-600' : 'bg-green-600') }}">
                {{ auth()->user()->status }}
            </p>
            <p class="mt-4 text-sm text-gray-400">Joined {{ auth()->user()->created_at->diffForHumans() }}</p>
        </div>
        <div class="my-4 py-2 text-center">
            {{auth()->user()->VaccineCenter->name}}
        </div>
        <ul class="py-4 mt-2 text-gray-700 flex items-center justify-around">
            <li class="flex flex-col items-center justify-around">
                <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                </svg>
                <div>2k</div>
            </li>
            <li class="flex flex-col items-center justify-between">
                <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z" />
                </svg>
                <div>10k</div>
            </li>
            <li class="flex flex-col items-center justify-around">
                <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M9 12H1v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6h-8v2H9v-2zm0-1H0V5c0-1.1.9-2 2-2h4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h4a2 2 0 0 1 2 2v6h-9V9H9v2zm3-8V2H8v1h4z" />
                </svg>
                <div>15</div>
            </li>
        </ul>
        <div class="p-4 border-t mx-8 mt-2">
            <button
                class="w-1/2 block mx-auto rounded-full bg-blue-700 hover:shadow-lg font-semibold text-white px-6 py-2">Follow</button>
        </div>
    </div>
@else
    <div class="p-4 border-t mx-8 text-center">
        <h3
            class="w-full text-cente block mx-auto rounded-full bg-blue-700 hover:shadow-lg font-semibold text-white px-6 py-4">
            Vaccine
            Registration Center
        </h3>
    </div>
@endif
@endsection
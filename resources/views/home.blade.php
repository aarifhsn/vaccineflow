@extends('layouts.app')

@section('content')

@if (auth()->check())
    <div
        class="max-w-2xl mx-4 sm:max-w-sm md:max-w-sm lg:max-w-sm xl:max-w-sm sm:mx-auto md:mx-auto lg:mx-auto xl:mx-auto mt-16 bg-white shadow-xl rounded-lg text-gray-900">
        <div class="rounded-t-lg h-32 overflow-hidden">
            <img class="object-cover object-top w-full"
                src='https://cdn.pixabay.com/photo/2020/11/07/20/29/laboratory-5722327_1280.jpg' alt='Vaccine'>
        </div>

        <div class="text-center mt-2 py-8">
            <h2 class="font-bold mb-4 text-2xl">{{auth()->user()->name}}</h2>

            @if (auth()->user()->status !== \App\Enums\UserStatus::VACCINATED)
                <h5 class="text-gray-700 font-semibold">Center: {{auth()->user()->VaccineCenter?->name}}</h5>
            @endif

            <p class="text-slate-200 my-8 py-4 font-bold capitalize {{ auth()->user()->status === \App\Enums\UserStatus::NOT_SCHEDULED ? 'bg-red-600' :
            (auth()->user()->status === \App\Enums\UserStatus::SCHEDULED ? 'bg-blue-600' : 'bg-green-600') }}">
                {{ auth()->user()->status }}
            </p>

            @if (auth()->user()->status === \App\Enums\UserStatus::NOT_SCHEDULED)
                <div id="countdown" class="text-gray-300 text-sm font-semibold mt-4 mb-2">
                    Loading countdown...
                </div>

            @elseif (auth()->user()->status === \App\Enums\UserStatus::SCHEDULED)
                <div class="px-4 font-semibold">Your vaccination is scheduled at <span
                        class="font-bold">{{auth()->user()->scheduled_date}} </span>. Please
                    arrive at the center by <span class="font-bold">9:00 AM.</span></div>

            @elseif (auth()->user()->status === \App\Enums\UserStatus::VACCINATED)
                <div class="px-4 font-semibold">Thank you for getting vaccinated! Stay healthy and take care. 😊</div>
            @endif

        </div>

        <div class="p-4 border-t mx-8 mt-2">
            @if(auth()->user()->status === \App\Enums\UserStatus::SCHEDULED)
                <button
                    class=" block mx-auto rounded-full bg-blue-700 hover:shadow-lg font-semibold text-white px-6 py-2">Confim
                    Vaccination</button>
            @else
                <button
                    class=" block mx-auto rounded-full bg-blue-700 hover:shadow-lg font-semibold text-white px-6 py-2">Contact
                    Us</button>
            @endif
        </div </div>
@else
    <div class="p-4 border-t mx-8 text-center">
        <h3
            class="w-full text-cente block mx-auto rounded-full bg-blue-700 hover:shadow-lg font-semibold text-white px-6 py-4">
            Vaccine
            Registration Center
        </h3>
    </div>
@endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notifiedAtTimestamp = {{ $notifiedAt }}; // Server-passed timestamp
            const countdownElement = document.getElementById('countdown');

            function updateCountdown() {
                const now = Math.floor(Date.now() / 1000); // Current time in seconds
                const timeRemaining = notifiedAtTimestamp - now;

                if (timeRemaining <= 0) {
                    countdownElement.textContent = "Check your Mail about your vaccination schedule.";
                    clearInterval(timer);
                    return;
                }

                // Convert remaining seconds into hours, minutes, and seconds
                const hours = Math.floor(timeRemaining / 3600);
                const minutes = Math.floor((timeRemaining % 3600) / 60);
                const seconds = timeRemaining % 60;

                countdownElement.innerHTML = `You will be scheduled and got notification in <br> <span style="font-weight: bold; font-size: 42px; margin-top: 20px; display:block; color:#6b7280; text-transform: uppercase">${hours}<span style="color: #9ca3af; font-size:18px">h</span> ${minutes}<span style="color: #9ca3af; font-size:18px">m</span> ${seconds}<span style="color: #9ca3af; font-size:18px">s</span> </span>`;
            }

            // Update countdown every second
            const timer = setInterval(updateCountdown, 1000);
            updateCountdown(); // Initial call
        });
    </script>
    @endsection
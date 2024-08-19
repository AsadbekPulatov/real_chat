<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row">
                        @foreach($users as $user)
                            <div class="col-4 p-3 d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white bg-secondary" style="width: 50px; height: 50px;">
                                    {{ $user->name[0] }}
                                </div>
                                <a class="ml-2 text-dark font-monospace" href="{{ route('chat', $user) }}">{{ $user->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

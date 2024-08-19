<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $friend->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row">
{{--                        <chat-component></chat-component>--}}
                        <x-chat-component :chat_id="$friend->id"/>
{{--                        {{ $friend->name }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

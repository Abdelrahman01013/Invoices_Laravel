<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الملف الشخصي') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <img src="{{ url('assets/img/profile/' . auth()->user()->img) }}" style="width: 500px ;height:500px">
                    "
                </div>
            </div>
        </div>
    </div> --}}

    <div style="margin-left: 30% ;margin-top: 50px">
        <img src="{{ url('assets/img/profile/' . auth()->user()->img) }}"
            style="width: 500px; height: 500px; border-radius: 250px">
    </div>
</x-app-layout>

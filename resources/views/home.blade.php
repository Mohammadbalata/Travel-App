<x-app-layout>
    <x-slot name="header" >
       
            <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between gap-4 mb-4">
                <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
                <button type="submit" class="btn btn-dark mx-2">Search</button>
            </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
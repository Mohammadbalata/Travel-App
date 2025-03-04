<x-app-layout>
    <div class="container mt-4">
        <form action="{{route('itineraries.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @include('Front.itineraries._form',['button_label' => 'Create'])
        </form>
    </div>
</x-app-layout>
<x-app-layout>
  <div class="container mt-4">
    <form action="{{route('itineraries.update',$itinerary->id)}}" method="post" enctype="multipart/form-data">
      @csrf
      @method('put')
      @include('Front.itineraries._form',['button_label' => 'Update'])
    </form>
  </div>
</x-app-layout>
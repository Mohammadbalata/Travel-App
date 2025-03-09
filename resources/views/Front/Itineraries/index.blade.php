<x-app-layout>
    <x-slot name="header">
        <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between gap-4 mb-4">
            <x-form.input name="filter" placeholder="Search Itineraries" class="mx-2" :value="request('filter')" />
            <button type="submit" class="btn btn-dark mx-2">Search</button>
        </form>
    </x-slot>

    <div class="container mt-4">
        <div class="mb-5">
            <a href="{{route('itineraries.create')}}" class="btn btn-primary mx-2">Create Itinerary</a>
        </div>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration (days)</th>
                    <th>Budget ($)</th>

                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($itineraries as $itinerary)
                <tr>
                    <td><a href="{{ route('itineraries.show',$itinerary)}}">{{ $itinerary->name }}</a></td>
                    <td>{{ $itinerary->start_date?->format('Y-m-d') }}</td>
                    <td>{{ $itinerary->end_date?->format('Y-m-d') }}</td>
                    <td>{{ $itinerary->duration }} days</td>
                    <td>{{ \App\Helpers\Currency::format( $itinerary->budget )}}</td>
                    <td>
                        <a href="{{route('itineraries.edit',$itinerary->id)}}" class="btn btn-sm btn-outline-success">Edit</a>

                    </td>
                    <td>
                        <form action="{{ route('itineraries.destroy',$itinerary->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No itineraries found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
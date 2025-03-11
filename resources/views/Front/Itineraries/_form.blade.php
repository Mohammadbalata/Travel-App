@if($errors->any())
<div class="alert alert-danger">
  <h2>Errors</h2>
  @foreach($errors->all() as $error)
  <li>{{$error}}</li>
  @endforeach
</div>
@endif

<div class="form-group">
  <x-form.input label="Name" type="text" :value="$itinerary->name" name="name" />
</div>
<div class="form-group">
  <x-form.input label="Start Date" type="date" :value="$itinerary->start_date?->format('Y-m-d')" name="start_date" />
</div>
<div class="form-group">
  <x-form.input label="End Date" type="date" :value="$itinerary->end_date?->format('Y-m-d')" name="end_date" />
</div>

<div class="form-group">
  <x-form.input label="Budget" type="number" :value="$itinerary->budget" name="budget" />
</div>

<div class="form-group">
  <x-form.textarea label="Notes" :value="$itinerary->notes" name="notes" />
</div>



<button type="submit" class="btn btn-primary">{{$button_label ?? 'Save'}}</button>
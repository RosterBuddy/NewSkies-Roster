@foreach($airport as $apt)
Airport Name: {{$apt->name}}<br>
Airport Code: {{$apt->iata}} // {{$apt->icao}}<br>
Timezone: {{$apt->timezone}}<br>
@endforeach
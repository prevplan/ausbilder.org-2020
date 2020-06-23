@component('mail::message')
# {{ __('course booking confirmation') }}

{{ __('Hello :name', ['name' => $request->firstname]) }},

{{ __('you have successfully booked a course at :company.', ['company' => $company->name]) }}

<strong>{{ __('course details') }}</strong><br>
{{ __($course->course_types[0]->name) }}<br>
{{ \Carbon\Carbon::parse($course->start)->format('d.m.Y H:i') }} Uhr - {{ \Carbon\Carbon::parse($course->end)->format('H:i') }} Uhr<br>

<strong>{{ __('location') }}</strong><br>
{{ $course->seminar_location }}<br>
{{ $course->street }}<br>
{{ $course->zipcode }} {{ $course->location }}

<strong>{{ __('price') }}</strong> {{ $course->prices->pluck('price', 'id')[$request->price] }} {{ $course->prices->pluck('currency', 'id')[$request->price] }}

{{ __('If you have questions, please mail to [:mail](mailto::mail) or simply reply to this mail.', ['mail' => $company->mail]) }}
@endcomponent

@php
    $alertStyles = [
        'success' => 'bg-green-100 border border-green-400 text-green-700',
        'error' => 'bg-red-100 border border-red-400 text-red-700',
        'info' => 'bg-blue-100 border border-blue-400 text-blue-700',
    ];
@endphp

@foreach($alertStyles as $type => $classes)
    @if(session($type))
        <div class="alert-{{ $type }} mb-6 p-4 rounded-lg {{ $classes }}">
            {{ session($type) }}
        </div>
    @endif
@endforeach

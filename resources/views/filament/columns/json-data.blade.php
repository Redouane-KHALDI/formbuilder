<div>
    @php
        $data = $getRecord()->data;
    @endphp

    @if(is_array($data) || is_object($data))
        <ul class="list-unstyled">
            @foreach($data as $key => $value)
                <li><strong>{{ $key }}:</strong> {{ is_array($value) ? json_encode($value) : $value }}</li>
            @endforeach
        </ul>
    @else
        {{ $data }}
    @endif
</div>

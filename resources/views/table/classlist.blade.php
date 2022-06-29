@foreach($classes as $class)
    <tr>
        <th scope="row">{{ $class['class_number'] }}</th>
        <td>{{ $class['subject'] . ' – ' . $class['catalog_number'] }}</td>
        <td data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $class['description'] }}">{{ $class['title'] }}</td>
        <td class="text-center">{{ $class['units'] }}</td>
        <td class="text-center">{{ $class['term'] }}</td>
        <td class="text-center">{{ $class['class_type'] }}</td>
        <td class="text-center">{{ $class['enrollment_count'] }} / {{ $class['enrollment_cap'] }}</td>
        <td class="text-center">{{ $class['waitlist_count'] }} / {{ $class['waitlist_cap'] }}</td>
        <td>
            @foreach($class['meetings'] as $meeting)
                {{ $meeting['location'] }}, {{ convertTimeTo12Hours($meeting['start_time']) }} - {{ convertTimeTo12Hours($meeting['end_time']) }}, {{ $meeting['days'] }}
            @endforeach
        </td>
        <td>{{ implode(', ', array_column($class['instructors'], 'instructor')) }}</td>
    </tr>
@endforeach

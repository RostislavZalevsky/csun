@extends('layout')

@section('title',  'Page 2')

@section('content')
    <form class="pb-4" id="formClasses">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" placeholder="e.g. Comp">
            </div>
            <div class="form-group col-md-3">
                <label for="catalogNumber">Catalog number</label>
                <input type="number" min="1" step="1" class="form-control" id="catalogNumber" placeholder="e.g. 110">
            </div>
            <div class="form-group col-md-3">
                <label for="semester">Semester</label>
                <select id="semester" class="form-control">
                    @foreach(\App\Data\Models\Semester::cases() as $s)
                        <option value="{{ $s->name }}" @if ($s->name == $currentSemester) selected @endif>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="year">Year</label>
                <select id="year" class="form-control">
                    @for($y = \App\Data\Models\Term::getMaxYear(); $y >= \App\Data\Models\Term::getMinYear(); $y--)
                        <option value="{{ $y }}" @if ($y == $currentYear) selected @endif>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <p id="executionTime" class="text-muted">{{ count($classes) }} result{{ count($classes) > 1 ? 's' : '' }} ({{ $executionTime }} sec)</p>

    @include('table.classes', ['classes' => $classes])
@endsection

@section('js')
    <script type="text/javascript">
        $('table').ready(function () {
            console.log('ready');

            $('#formClasses').on('submit',function(e) {
                e.preventDefault();

                let subject = $('#subject').val();
                let catalogNumber = $('#catalogNumber').val();
                let semester = $('#semester').val();
                let year = $('#year').val();

                $('tbody').html('<div class="alert alert-primary" role="alert">Loading classes of data...</div>');

                $.ajax({
                    url: "{{ route('classes') }}",
                    type:"GET",
                    data:{
                        _token: "{{ csrf_token() }}",
                        subject: subject,
                        catalog_number: catalogNumber,
                        semester: semester,
                        year: year,
                    },
                    success:function(response){
                        if (response.classes.length === 0) {
                            $('tbody').html('<div class="alert alert-warning" role="alert">Data classes are empty</div>');
                        } else {
                            $('tbody').html(response.listHtml);
                        }

                        $('#executionTime').html(
                            response.classes.length + ' result' + (response.classes.length > 1 ? 's' : '')
                            + ' (' + response.executionTime + ' sec)');

                    },
                    error: function(response) {
                        var message = response.responseJSON.message;

                        $('tbody').html('<div class="alert alert-danger" role="alert">' + message + '</div>');
                    },
                });
            });
        });
    </script>
@endsection

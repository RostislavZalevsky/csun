<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th class="align-middle" scope="col">Class #</th>
        <th class="align-middle" scope="col">Subject – #</th>
        <th class="align-middle text-center" scope="col">Title</th>
        <th class="align-middle text-center" scope="col">Units</th>
        <th class="align-middle text-center" scope="col">Term</th>
        <th class="align-middle text-center" scope="col">Type</th>
        <th class="align-middle text-center" scope="col">Enrollment<br/>count / cap</th>
        <th class="align-middle text-center" scope="col">Waitlist<br/>count / cap</th>
        <th class="align-middle" scope="col">Meetings:<br/>location, start - end time, days</th>
        <th class="align-middle" scope="col">Instructors</th>
    </tr>
    </thead>
    <tbody>
    @include('table.classlist', ['classes' => $classes])
    </tbody>
</table>

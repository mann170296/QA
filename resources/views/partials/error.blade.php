@if (session()->has('error'))
    <div class="alert alert-danger">
        <strong>Error: </strong>
        {{ session()->get('error') }}
    </div>
@endif
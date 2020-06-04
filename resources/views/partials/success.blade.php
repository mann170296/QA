@if (session()->has('success'))
    <div class="alert alert-success">
        <strong>Success: </strong>
        {{ session()->get('success') }}
    </div>
@endif
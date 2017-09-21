@if(session('errors')) @forelse(session('errors') as $error)
<div class="panel panel-danger">
    <div class="panel-heading">
        {{ $error }}
    </div>
</div>
@empty
@endforelse @endif

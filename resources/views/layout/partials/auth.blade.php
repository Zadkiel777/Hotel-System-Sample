@if(session(key: 'id') == null)
    {{ unauthorize() }}
@endif

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
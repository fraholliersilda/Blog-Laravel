<form action="{{ route('api-keys.destroy', $key) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this API key?')">
        Delete
    </button>
</form>
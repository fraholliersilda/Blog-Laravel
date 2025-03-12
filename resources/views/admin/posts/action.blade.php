<a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-sm">
    <i class="bi bi-eye"></i> Read More
</a>
<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-success btn-sm">
    <i class="bi bi-pencil-square"></i> Edit
</a>
<form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');">
        <i class="bi bi-trash"></i> Delete
    </button>
</form>
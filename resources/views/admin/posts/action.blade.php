<a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-sm">
    <i class="bi bi-eye"></i> Read More
</a>
<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-success btn-sm">
    <i class="bi bi-pencil-square"></i> Edit
</a>
<button class="btn btn-danger btn-sm delete-post-btn" data-post-id="{{ $post->id }}">
    <i class="bi bi-trash"></i> Delete
</button>


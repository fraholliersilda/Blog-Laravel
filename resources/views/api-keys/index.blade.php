@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">API Keys</h2>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('generated_key'))
            <div class="alert alert-warning" role="alert">
                <strong>Important:</strong> Save this API key as it won't be shown again.
                <input type="text" class="form-control mt-2" value="{{ session('generated_key') }}" readonly onclick="this.select();">
            </div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createApiKeyModal">
                Create New API Key
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Created</th>
                            <th>Last Used</th>
                            <th>Expires</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($apiKeys as $key)
                            <tr>
                                <td>{{ $key->name }}</td>
                                <td>{{ $key->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ $key->last_used_at ? $key->last_used_at->format('M d, Y H:i') : 'Never' }}</td>
                                <td>{{ $key->expires_at ? $key->expires_at->format('M d, Y') : 'Never' }}</td>
                                <td class="text-end">
                                    <form action="{{ route('api-keys.destroy', $key) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this API key?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No API keys found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create API Key Modal -->
    <div class="modal fade" id="createApiKeyModal" tabindex="-1" aria-labelledby="createApiKeyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createApiKeyModalLabel">Create API Key</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('api-keys.store') }}" id="createApiKeyForm">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expires At (optional)</label>
                            <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}"
                                   class="form-control @error('expires_at') is-invalid @enderror">
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="createApiKeyForm" class="btn btn-primary">Generate API Key</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            var createApiKeyModal = new bootstrap.Modal(document.getElementById('createApiKeyModal'));
            createApiKeyModal.show();
        });
    @endif
</script>
@endpush

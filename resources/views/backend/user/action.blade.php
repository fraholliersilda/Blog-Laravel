
<!-- Edit Button -->
<button type="button" class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-target="#editUserModal"
    data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}"
    data-role="{{ $user->role_id }}">
    {{__('app.edit')}}
</button>

<!-- Delete Button -->
<button type="button" class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal" data-target="#deleteUserModal"
    data-id="{{ $user->id }}" data-name="{{ $user->name }}">
    {{__('app.delete')}}
</button>



    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="editUserModalLabel">{{__('app.edit')}} {{__('app.user')}}</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_name">{{__('app.name')}}</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_email">Email</label>
                                    <input type="email" class="form-control" id="edit_email" name="email" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('app.cancel')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('app.update')}} {{__('app.user')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteUserModalLabel">{{__('app.delete')}} {{__('app.user')}}</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{__('app.sure_to_delete')}} <strong><span id="delete_user_name"></span></strong>?</p>
                    <p class="text-warning">{{__('app.cannot_undone')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__('app.cancel')}}</button>
                    <form id="deleteUserForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{__('app.delete')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

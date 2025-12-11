<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">{{ __('messages.edit') }} User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.name') }}</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.email') }}</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="(Kosongkan jika tidak ingin mengubah)">
                        <small class="text-muted" style="font-size: 0.75rem;">Biarkan kosong jika password tetap sama.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.role') }}</label>
                        <select name="role" id="editRole" class="form-select" required>
                            <option value="donatur">{{ __('messages.donor') }}</option>
                            <option value="relawan">{{ __('messages.volunteer') }}</option>
                            <option value="admin">{{ __('messages.admin') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

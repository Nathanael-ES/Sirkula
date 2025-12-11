
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">{{ __('messages.add_user') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.name') }}</label>
                        <input type="text" name="name" class="form-control" required placeholder="Nama Lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control" required placeholder="email@contoh.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.password') }}</label>
                        <input type="password" name="password" class="form-control" required placeholder="********">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.role') }}</label>
                        <select name="role" class="form-select" required>
                            <option value="donatur">{{ __('messages.donor') }}</option>
                            <option value="relawan">{{ __('messages.volunteer') }}</option>
                            <option value="admin">{{ __('messages.admin') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4">{{ __('messages.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

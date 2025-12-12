<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.category_name') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Elektronik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat..."></textarea>
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

<div class="modal fade" id="createRecipientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Penerima</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('recipients.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Nama Penerima</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">No. Telepon</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Alamat</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
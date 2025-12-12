<div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editItemForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    
                    <div class="mb-3 text-center d-none" id="editPhotoPreviewContainer">
                        <p class="small text-muted mb-1">Foto Saat Ini:</p>
                        <img id="editPhotoPreview" src="" class="rounded shadow-sm" style="max-height: 120px; object-fit: cover;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Nama Barang</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted fw-bold">Kategori</label>
                            <select name="category_id" id="editCategory" class="form-select" required>
                                <option value="">Pilih...</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted fw-bold">Kondisi</label>
                            <input type="text" name="condition" id="editCondition" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Ganti Foto (Opsional)</label>
                        <input type="file" name="photo" class="form-control">
                        <small class="text-muted" style="font-size: 0.7rem;">Biarkan kosong jika tidak ingin mengubah foto.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Deskripsi</label>
                        <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
    <label class="form-label small text-muted fw-bold">Status Barang</label>
    <select name="status" id="editStatus" class="form-select">
        <option value="pending">Pending</option>
        <option value="verified">Verified</option>
        <option value="ready">Siap Kirim</option>
    </select>
</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Update</button>
                </div>

 
            </form>
        </div>
    </div>
</div>
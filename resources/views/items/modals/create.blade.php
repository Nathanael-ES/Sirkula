<div class="modal fade" id="createItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Nama Barang</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Laptop Acer Bekas">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted fw-bold">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Pilih...</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted fw-bold">Kondisi</label>
                            <input type="text" name="condition" class="form-control" placeholder="Cth: Layak Pakai">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Foto Barang</label>
                        <input type="file" name="photo" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan detail barang..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
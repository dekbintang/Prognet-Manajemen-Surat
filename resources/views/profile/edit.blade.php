<x-app-layout>
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Profil</h1>
            <div class="text-secondary">Kelola informasi akun Anda</div>
        </div>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success rounded-4">Profil berhasil diperbarui.</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">Informasi Profil</h5>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-primary rounded-4 px-4">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">Hapus Akun</h5>
                    <p class="text-secondary">Masukkan password untuk konfirmasi hapus akun.</p>

                    <form method="POST" action="{{ route('profile.destroy') }}" class="d-flex gap-2">
                        @csrf
                        @method('DELETE')

                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" required>
                        <button class="btn btn-danger rounded-4 px-4">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>

                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

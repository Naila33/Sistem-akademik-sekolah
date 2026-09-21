<div class="mb-3">
    <label for="mulai_penilaian" class="form-label">
        Mulai Penilaian
    </label>
    <input
        type="datetime-local"
        name="mulai_penilaian"
        id="mulai_penilaian"
        class="form-control"
        value="{{ old('mulai_penilaian', isset($pjbl) && $pjbl->mulai_penilaian ? $pjbl->mulai_penilaian->format('Y-m-d\TH:i') : '') }}"
    >
</div>

<div class="mb-3">
    <label for="batas_penilaian" class="form-label">
        Batas Penilaian
    </label>
    <input
        type="datetime-local"
        name="batas_penilaian"
        id="batas_penilaian"
        class="form-control"
        value="{{ old('batas_penilaian', isset($pjbl) && $pjbl->batas_penilaian ? $pjbl->batas_penilaian->format('Y-m-d\TH:i') : '') }}"
    >
</div>
<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">Edit Official Task File</h2>
    <div class="row">
        <div class="col-xl-6">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('official-task-files.update', $officialTaskFile->id) }}" onsubmit="showLoader()"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_type" type="text" name="letter_type"
                            placeholder="Jenis Surat" value="{{ old('letter_type', $officialTaskFile->letter_type) }}"
                            required />
                        <label for="letter_type">Jenis Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_number" type="text" name="letter_number"
                            placeholder="Nomor Surat"
                            value="{{ old('letter_number', $officialTaskFile->letter_number) }}" required />
                        <label for="letter_number">Nomor Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_reference" type="text" name="letter_reference"
                            placeholder="Referensi Surat"
                            value="{{ old('letter_reference', $officialTaskFile->letter_reference) }}" required />
                        <label for="letter_reference">Referensi Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_date" type="date" name="letter_date"
                            value="{{ old('letter_date', $officialTaskFile->letter_date) }}" required />
                        <label for="letter_date">Tanggal Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="assign" name="assign" placeholder="Penugasan" required style="height: 100px">{{ old('assign', $officialTaskFile->assign) }}</textarea>
                        <label for="assign">Penugasan</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="to_implement" name="to_implement" placeholder="Pelaksanaan" required
                            style="height: 100px">{{ old('to_implement', $officialTaskFile->to_implement) }}</textarea>
                        <label for="to_implement">Pelaksanaan</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="letter_closing" name="letter_closing" placeholder="Penutup Surat" required
                            style="height: 100px">{{ old('letter_closing', $officialTaskFile->letter_closing) }}</textarea>
                        <label for="letter_closing">Penutup Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_creation_date" type="date" name="letter_creation_date"
                            value="{{ old('letter_creation_date', $officialTaskFile->letter_creation_date) }}"
                            required />
                        <label for="letter_creation_date">Tanggal Pembuatan Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating form-floating-advance-select">
                        <label for="signed_by">Ditandatangani oleh</label>
                        <select class="form-select" id="signed_by" data-choices="data-choices" size="1"
                            name="signed_by" data-options='{"removeItemButton":true,"placeholder":true}' required>
                            <option value="" hidden>Pilih Pegawai</option>
                            @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}"
                                    {{ old('signed_by', $officialTaskFile->signed_by) == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }} - {{ $emp->employee_identification_number }} -
                                    {{ $emp->rank }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="attachment" type="text" name="attachment"
                            placeholder="Lampiran" value="{{ old('attachment', $officialTaskFile->attachment) }}" />
                        <label for="attachment">Lampiran</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="operator_name" type="text" name="operator_name"
                            placeholder="Nama Operator/Admin"
                            value="{{ old('operator_name', $officialTaskFile->operator_name) }}" required />
                        <label for="operator_name">Nama Operator/Admin</label>
                    </div>
                </div>
                <!-- End of new input fields -->
                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Batal</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xl-6">
            <h3 class="mb-4">Preview PDF</h3>
            <iframe id="pdf-preview" style="width: 100%; height: 500px;"></iframe>
        </div>
    </div>
    @push('header')
        <link rel="stylesheet" href="{{ asset('assets/vendors/choices/choices.min.css') }}">
    @endpush
    @push('footer')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <script src="{{ asset('assets/vendors/choices/choices.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const {
                    jsPDF
                } = window.jspdf;

                function getBase64Image(imgUrl, callback) {
                    const img = new Image();
                    img.crossOrigin = 'Anonymous';
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0);
                        const dataURL = canvas.toDataURL('image/png');
                        console.log('Base64 Image:', dataURL); // Debugging line
                        callback(dataURL);
                    };
                    img.onerror = function() {
                        console.error('Failed to load image:', imgUrl); // Debugging line
                    };
                    img.src = imgUrl;
                }

                function generatePDF(logoBase64) {
                    const doc = new jsPDF();

                    // Capture form input values
                    const letterType = document.getElementById('letter_type').value;
                    const letterNumber = document.getElementById('letter_number').value;
                    const letterReference = document.getElementById('letter_reference').value;
                    const letterDate = document.getElementById('letter_date').value;
                    const assign = document.getElementById('assign').value;
                    const toImplement = document.getElementById('to_implement').value;
                    const letterClosing = document.getElementById('letter_closing').value;
                    const letterCreationDate = document.getElementById('letter_creation_date').value;
                    const signedBy = document.getElementById('signed_by').value;
                    const attachment = document.getElementById('attachment').value;
                    const operatorName = document.getElementById('operator_name').value;

                    // Add header with logo
                    if (logoBase64) {
                        doc.addImage(logoBase64, 'PNG', 20, 10, 20, 30); // Adjust the position and size as needed
                    }

                    doc.setFontSize(20);
                    doc.text('PEMERINTAH KABUPATEN CIAMIS', 110, 15, {
                        align: 'center'
                    });

                    doc.setFontSize(24);
                    doc.setFont('Arial', 'bold');
                    doc.text('DINAS KESEHATAN', 110, 24, {
                        align: 'center'
                    });
                    doc.setFontSize(12);
                    doc.setFont('Arial', 'normal');
                    doc.text('Jalan. Mr. Iwa Kusumasomantri No 12', 110, 30, {
                        align: 'center'
                    });
                    doc.text('Tlp. (0265) 771139, Faximile (0265) 773828', 110, 35, {
                        align: 'center'
                    });
                    doc.text('Website: www.dinkes.ciamiskab.go.id , Pos 46213', 110, 40, {
                        align: 'center'
                    });

                    // Add line separator
                    doc.setLineWidth(0.5);
                    doc.line(15, 45, 200, 45);

                    // Add letter details with margins
                    const marginLeft = 20;
                    doc.setFontSize(12);
                    doc.text(`Nomor: ${letterNumber}`, marginLeft, 50);
                    doc.text(`Referensi: ${letterReference}`, marginLeft, 55);
                    doc.text(`Tanggal: ${letterDate}`, marginLeft, 60);
                    doc.text(`Penugasan: ${assign}`, marginLeft, 65);
                    doc.text(`Pelaksanaan: ${toImplement}`, marginLeft, 70);
                    doc.text(`Penutup: ${letterClosing}`, marginLeft, 75);
                    doc.text(`Tanggal Pembuatan: ${letterCreationDate}`, marginLeft, 80);
                    doc.text(`Ditandatangani oleh: ${signedBy}`, marginLeft, 85);
                    doc.text(`Lampiran: ${attachment}`, marginLeft, 90);
                    doc.text(`Operator/Admin: ${operatorName}`, marginLeft, 95);

                    // Output PDF to data URI
                    const pdfDataUri = doc.output('datauristring');
                    console.log('PDF Data URI:', pdfDataUri); // Debugging line
                    document.getElementById('pdf-preview').src = pdfDataUri;
                }

                // Attach event listeners to form inputs
                const formInputs = document.querySelectorAll('input, select, textarea');
                formInputs.forEach(input => {
                    input.addEventListener('input', () => {
                        getBase64Image("{{ asset('assets/assets/img/logos/logoDinkes.png') }}",
                            generatePDF);
                    });
                });

                // Initial PDF generation
                getBase64Image("{{ asset('assets/assets/img/logos/logoDinkes.png') }}", generatePDF);
            });
        </script>
    @endpush
</x-dash.layout>

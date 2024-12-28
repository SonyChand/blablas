<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">Tambah surat keluar</h2>
    <div class="row">
        <div class="col-xl-6">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('outgoing-letters.store') }}" onsubmit="showLoader()" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="letter_type" id="letter_type" value="{{ $type }}" required>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="number" type="text" name="letter_number"
                            placeholder="Nomor Surat" value="{{ old('letter_number') }}" required />
                        <label for="number">Nomor Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating form-floating-advance-select">
                            <label for="letter_nature">Sifat Surat</label>
                            <select class="form-select" id="letter_nature" data-choices="data-choices" size="1"
                                name="letter_nature" data-options='{"removeItemButton":true,"placeholder":true}'
                                required>
                                <option value="" hidden>Pilih Sifat Surat</option>
                                <option value="penting" {{ old('letter_nature') == 'penting' ? 'selected' : '' }}>
                                    Penting
                                </option>
                                <option value="biasa" {{ old('letter_nature') == 'biasa' ? 'selected' : '' }}>
                                    Biasa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_subject" type="text" name="letter_subject"
                            placeholder="Perihal" value="{{ old('letter_subject') }}" required />
                        <label for="letter_subject">Perihal</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="letter_date" type="date" name="letter_date"
                            value="{{ old('letter_date') }}" required />
                        <label for="letter_date">Tanggal Surat</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="attachment" type="text" name="attachment"
                            placeholder="Lampiran" value="{{ old('attachment') }}" required />
                        <label for="attachment">Lampiran</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="to" type="text" name="to" placeholder="Kepada Yth :" required
                            style="height: 100px">{{ old('to') }}</textarea>
                        <label for="to">Kepada Yth :</label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea class="tinymce" data-tinymce="{}" id="letter_body" name="letter_body" placeholder="Isi Surat :" required
                            style="height: 150px">{{ old('letter_body') }}</textarea>
                    </div>
                </div>
                @if ($type == 'surat-undangan')
                    <!-- Input fields specific to Surat Undangan -->
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="event_date_start" type="date" name="event_date_start"
                                placeholder="Tanggal Acara" value="{{ old('event_date_start') }}" required />
                            <label for="event_date_start">Tanggal Acara Mulai</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="event_date_end" type="date" name="event_date_end"
                                placeholder="Tanggal Acara" value="{{ old('event_date_end') }}" required />
                            <label for="event_date_end">Tanggal Acara Selesai</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="event_time_start" type="time" name="event_time_start"
                                placeholder="Tanggal Acara" value="{{ old('event_time_start') }}" required />
                            <label for="event_time_start">Waktu Acara Mulai</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="event_time_end" type="time" name="event_time_end"
                                placeholder="Tanggal Acara" value="{{ old('event_time_end') }}" required />
                            <label for="event_time_end">Waktu Acara Selesai</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating">
                            <input class="form-control" id="event_location" type="text" name="event_location"
                                placeholder="Lokasi Acara" value="{{ old('event_location') }}" required />
                            <label for="event_location">Lokasi Acara</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating">
                            <input class="form-control" id="event_agenda" type="text" name="event_agenda"
                                placeholder="Lokasi Acara" value="{{ old('event_agenda') }}" required />
                            <label for="event_agenda">Agenda Acara</label>
                        </div>
                    </div>
                @elseif($type == 'surat-dinas')
                    <!-- Input fields specific to Surat Dinas -->
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="event_date_start" type="date" name="event_date_start"
                                placeholder="Tanggal Tugas" value="{{ old('event_date_start') }}" required />
                            <label for="event_date_start">Tanggal Mulai Tugas</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="event_date_end" type="date" name="event_date_end"
                                placeholder="Tanggal Tugas" value="{{ old('event_date_end') }}" required />
                            <label for="event_date_end">Tanggal Berakhir Tugas</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="event_time_start" type="time" name="event_time_start"
                                placeholder="Tanggal Tugas" value="{{ old('event_time_start') }}" required />
                            <label for="event_time_start">Waktu Mulai Tugas</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="event_time_end" type="time" name="event_time_end"
                                placeholder="Tanggal Tugas" value="{{ old('event_time_end') }}" required />
                            <label for="event_time_end">Waktu Berakhir Tugas</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating">
                            <input class="form-control" id="event_location" type="text" name="event_location"
                                placeholder="Lokasi Tugas" value="{{ old('event_location') }}" required />
                            <label for="event_location">Lokasi Tugas</label>
                        </div>
                    </div>
                @elseif($type == 'surat-pernyataan-spmt')
                    <!-- Input fields specific to Surat SPMT -->
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating">
                            <input class="form-control" id="spmt_date" type="date" name="spmt_date"
                                placeholder="Tanggal SPMT" value="{{ old('spmt_date') }}" required />
                            <label for="spmt_date">Tanggal SPMT</label>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating">
                            <input class="form-control" id="spmt_location" type="text" name="spmt_location"
                                placeholder="Lokasi SPMT" value="{{ old('spmt_location') }}" required />
                            <label for="spmt_location">Lokasi SPMT</label>
                        </div>
                    </div>
                @endif

                <div class="col-sm-12 col-md-12">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating form-floating-advance-select">
                            <label for="signed_by">Ditandatangani oleh</label>
                            <select class="form-select" id="signed_by" data-choices="data-choices" size="1"
                                name="signed_by" data-options='{"removeItemButton":true,"placeholder":true}' required>
                                <option value="" hidden>Pilih Pegawai</option>
                                @foreach ($employees as $emp)
                                    <option value="{{ $emp->id }}"
                                        {{ old('signed_by') == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->name }} - {{ $emp->employee_identification_number }} -
                                        {{ $emp->rank }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <textarea id="letter_closing" class="tinymce" data-tinymce="{}" name="letter_closing" placeholder="Penutup Surat :"
                            required style="height: 150px">{{ old('letter_closing') }}</textarea>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="operator_name" type="text" name="operator_name"
                            placeholder="Nama Operator/Admin" value="{{ old('operator_name') }}" required />
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
                            <button class="btn btn-primary px-5 px-sm-15">Tambah</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="letter_destination_json" id="letter_destination_json">
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
                    const letterType = "{{ $type }}";
                    const letterNumber = document.getElementById('number').value;
                    const letterNature = document.getElementById('letter_nature').value;
                    const letterSubject = document.getElementById('letter_subject').value;
                    const letterDate = document.getElementById('letter_date').value;
                    const attachment = document.getElementById('attachment').value;
                    const to = document.getElementById('to').value;
                    const letterBody = document.getElementById('letter_body').value;
                    const letterClosing = document.getElementById('letter_closing').value;
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
                    doc.text(`Sifat: ${letterNature}`, marginLeft, 55);
                    doc.text(`Lampiran: ${attachment}`, marginLeft, 60);
                    doc.text(`Perihal: ${letterSubject}`, marginLeft, 65);

                    // Add date
                    doc.text(`Ciamis, ${letterDate}`, 200 - marginLeft, 75, {
                        align: 'right'
                    });

                    // Add recipient
                    doc.text(`Kepada Yth:`, marginLeft, 85);
                    doc.text(`${to}`, marginLeft, 90);

                    // Add body
                    doc.text(`Dengan hormat,`, marginLeft, 100);
                    doc.text(`${letterBody}`, marginLeft, 110, {
                        maxWidth: 170
                    });

                    // Add closing
                    doc.text(`${letterClosing}`, marginLeft, 160, {
                        maxWidth: 170
                    });

                    if (letterType === 'surat-undangan') {
                        const eventDateStart = document.getElementById('event_date_start') ? document.getElementById(
                            'event_date_start').value : '';
                        const eventDateEnd = document.getElementById('event_date_end') ? document.getElementById(
                            'event_date_end').value : '';
                        const eventTimeStart = document.getElementById('event_time_start') ? document.getElementById(
                            'event_time_start').value : '';
                        const eventTimeEnd = document.getElementById('event_time_end') ? document.getElementById(
                            'event_time_end').value : '';
                        const eventLocation = document.getElementById('event_location') ? document.getElementById(
                            'event_location').value : '';
                        const eventAgenda = document.getElementById('event_agenda') ? document.getElementById(
                            'event_agenda').value : '';

                        doc.text(`Tanggal Acara Mulai: ${eventDateStart}`, marginLeft, 170);
                        doc.text(`Tanggal Acara Selesai: ${eventDateEnd}`, marginLeft, 175);
                        doc.text(`Waktu Acara Mulai: ${eventTimeStart}`, marginLeft, 180);
                        doc.text(`Waktu Acara Selesai: ${eventTimeEnd}`, marginLeft, 185);
                        doc.text(`Lokasi Acara: ${eventLocation}`, marginLeft, 190);
                        doc.text(`Agenda Acara: ${eventAgenda}`, marginLeft, 195);
                    } else if (letterType === 'surat-dinas') {
                        const eventDate = document.getElementById('event_date') ? document.getElementById('event_date')
                            .value : '';
                        const eventLocation = document.getElementById('event_location') ? document.getElementById(
                            'event_location').value : '';

                        doc.text(`Tanggal Tugas: ${eventDate}`, marginLeft, 170);
                        doc.text(`Lokasi Tugas: ${eventLocation}`, marginLeft, 175);
                    } else if (letterType === 'surat-spmt') {
                        const eventDay = document.getElementById('event_day') ? document.getElementById('event_day')
                            .value : '';
                        const eventTime = document.getElementById('event_time') ? document.getElementById('event_time')
                            .value : '';
                        const eventLocation = document.getElementById('event_location') ? document.getElementById(
                            'event_location').value : '';
                        const eventAgenda = document.getElementById('event_agenda') ? document.getElementById(
                            'event_agenda').value : '';

                        doc.text(`Hari/Tanggal: ${eventDay}`, marginLeft, 170);
                        doc.text(`Waktu: ${eventTime}`, marginLeft, 175);
                        doc.text(`Tempat: ${eventLocation}`, marginLeft, 180);
                        doc.text(`Acara: ${eventAgenda}`, marginLeft, 185);
                    }

                    // Add signature
                    doc.text(`Hormat kami,`, 200 - marginLeft, 200, {
                        align: 'right'
                    });
                    doc.text(`Dinas Kesehatan Kabupaten Ciamis`, 200 - marginLeft, 205, {
                        align: 'right'
                    });

                    // Format and add employee details
                    const employeeSelect = document.getElementById('employee_id');
                    if (employeeSelect) {
                        const employeeText = employeeSelect.selectedOptions[0].text;
                        const employeeDetails = employeeText.split(' - ');
                        if (employeeDetails.length === 3) {
                            const [name, nip, rank] = employeeDetails;
                            doc.text(name, 200 - marginLeft, 210, {
                                align: 'right'
                            });
                            doc.text(rank, 200 - marginLeft, 215, {
                                align: 'right'
                            });
                            doc.text(`NIP. ${nip}`, 200 - marginLeft, 220, {
                                align: 'right'
                            });
                        }
                    }

                    // Add operator/admin
                    doc.setFontSize(10);
                    doc.text(`Operator/Admin: ${operatorName}`, marginLeft, 230);

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
        <script src="{{ asset('assets') }}/vendors/tinymce/tinymce.min.js"></script>
    @endpush
</x-dash.layout>

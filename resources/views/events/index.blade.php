@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white p-4 md:p-8 rounded-lg shadow-lg">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Jadwal Acara Gereja</h1>

            <div id='calendar' class="text-sm md:text-base"></div>
        </div>
    </div>

    {{-- PERBAIKAN: backdrop-blur-sm dihapus, diganti bg-black agar background gelap transparan --}}
    <div id="event-modal" class="fixed inset-0 bg-opacity-50 flex items-center justify-center p-4 z-50 transition-opacity duration-300 opacity-0 pointer-events-none">
        <div id="modal-content" class="bg-white rounded-lg shadow-xl w-full max-w-lg transform scale-95 transition-transform duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div class="pr-4">
                        <h3 id="modal-title" class="text-2xl font-bold text-gray-900">Nama Acara</h3>
                        <p id="modal-time" class="text-sm text-gray-500 mt-1">Waktu Acara</p>
                    </div>
                    <button id="modal-close-btn" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>
                <hr class="my-4">
                <div id="modal-description" class="prose max-w-none text-gray-700 max-h-60 overflow-y-auto">
                    Deskripsi acara akan muncul di sini.
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eventModal = document.getElementById('event-modal');
            const modalContent = document.getElementById('modal-content');
            const modalTitle = document.getElementById('modal-title');
            const modalTime = document.getElementById('modal-time');
            const modalDescription = document.getElementById('modal-description');
            const modalCloseBtn = document.getElementById('modal-close-btn');

            const openModal = () => {
                eventModal.classList.remove('opacity-0', 'pointer-events-none');
                modalContent.classList.remove('scale-95');
            };

            const closeModal = () => {
                eventModal.classList.add('opacity-0', 'pointer-events-none');
                modalContent.classList.add('scale-95');
            };

            // Event listener untuk tombol close
            modalCloseBtn.addEventListener('click', closeModal);

            // Opsional: Tutup modal jika klik di luar area konten (background gelap)
            eventModal.addEventListener('click', function(e) {
                if (e.target === eventModal) {
                    closeModal();
                }
            });

            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: '{{ route('events.json') }}',

                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    modalTitle.textContent = info.event.title;
                    const startTime = new Date(info.event.start).toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' });
                    // Handle jika end time null (acara seharian/satu waktu)
                    let endTime = '';
                    if (info.event.end) {
                        endTime = ' - ' + new Date(info.event.end).toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' });
                    }

                    modalTime.textContent = `${startTime}${endTime}`;
                    modalDescription.innerHTML = info.event.extendedProps.description ? info.event.extendedProps.description.replace(/\n/g, '<br>') : 'Tidak ada deskripsi.';

                    openModal();
                }
            });

            calendar.render();
        });
    </script>
@endpush

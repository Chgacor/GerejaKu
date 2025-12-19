@extends('layouts.app')

@section('content')
    <style>
        /* Custom CSS untuk merapikan FullCalendar di Mobile */
        .fc .fc-toolbar {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .fc .fc-toolbar {
                flex-direction: row;
            }
        }

        /* Mengecilkan font tombol di mobile agar tidak meluber */
        @media (max-width: 640px) {
            .fc .fc-button {
                padding: 0.4rem 0.6rem !important;
                font-size: 0.75rem !important;
            }
            .fc .fc-toolbar-title {
                font-size: 1.25rem !important;
            }
        }

        /* Memperbaiki tinggi kalender agar pas di layar */
        #calendar {
            min-height: 500px;
        }
    </style>

    <div class="container mx-auto px-2 sm:px-6 lg:px-8 py-4 md:py-8">
        <div class="bg-white p-3 md:p-8 rounded-lg shadow-lg">
            <h1 class="text-xl md:text-3xl font-bold text-gray-800 mb-6 border-b pb-4">Jadwal Acara Gereja</h1>

            <div id='calendar'></div>
        </div>
    </div>

    {{-- MODAL EVENT --}}
    <div id="event-modal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-[60] transition-opacity duration-300 opacity-0 pointer-events-none">
        <div id="modal-content" class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform scale-95 transition-transform duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div class="pr-4">
                        <h3 id="modal-title" class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">Nama Acara</h3>
                        <div class="flex items-center text-gray-500 mt-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p id="modal-time" class="text-sm">Waktu Acara</p>
                        </div>
                    </div>
                    <button id="modal-close-btn" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>
                <hr class="my-4">
                <div id="modal-description" class="prose max-w-none text-gray-700 max-h-60 overflow-y-auto text-sm md:text-base">
                    Deskripsi acara akan muncul di sini.
                </div>
                <div class="mt-6 text-right">
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let calendar; // Definisi variabel global

        document.addEventListener('DOMContentLoaded', function() {
            const eventModal = document.getElementById('event-modal');
            const modalContent = document.getElementById('modal-content');
            const modalTitle = document.getElementById('modal-title');
            const modalTime = document.getElementById('modal-time');
            const modalDescription = document.getElementById('modal-description');
            const modalCloseBtn = document.getElementById('modal-close-btn');

            window.openModal = () => {
                eventModal.classList.remove('opacity-0', 'pointer-events-none');
                modalContent.classList.remove('scale-95');
            };

            window.closeModal = () => {
                eventModal.classList.add('opacity-0', 'pointer-events-none');
                modalContent.classList.add('scale-95');
            };

            modalCloseBtn.addEventListener('click', closeModal);
            eventModal.addEventListener('click', (e) => { if (e.target === eventModal) closeModal(); });

            const calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth', // List di mobile, Grid di desktop
                locale: 'id',
                height: 'auto',
                headerToolbar: window.innerWidth < 768 ? {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'listWeek,dayGridMonth' // Opsi lebih sedikit di mobile
                } : {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    list: 'Daftar'
                },
                events: '{{ route('events.json') }}',
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    modalTitle.textContent = info.event.title;

                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                    const startTime = new Date(info.event.start).toLocaleString('id-ID', options);
                    let endTime = '';
                    if (info.event.end) {
                        endTime = ' - ' + new Date(info.event.end).toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit' });
                    }

                    modalTime.textContent = `${startTime}${endTime}`;
                    modalDescription.innerHTML = info.event.extendedProps.description
                        ? info.event.extendedProps.description.replace(/\n/g, '<br>')
                        : '<span class="italic text-gray-400">Tidak ada deskripsi.</span>';

                    openModal();
                },
                // Handle perubahan orientasi layar
                windowResize: function(view) {
                    if (window.innerWidth < 768) {
                        calendar.changeView('listWeek');
                    } else {
                        calendar.changeView('dayGridMonth');
                    }
                }
            });

            calendar.render();
        });
    </script>
@endpush

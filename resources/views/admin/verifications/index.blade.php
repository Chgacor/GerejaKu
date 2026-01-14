@extends('layouts.admin')

@section('content')

    {{-- JUDUL HALAMAN --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Verifikasi & Manajemen User</h1>
    </div>

    {{-- ================================================== --}}
    {{-- TABEL 1: PERMINTAAN VERIFIKASI USER BARU          --}}
    {{-- ================================================== --}}
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg mb-10 border-t-4 border-blue-500">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    User Baru (Pending Approval)
                </h2>
                <p class="text-sm text-gray-500 mt-1">Daftar pengguna baru yang menunggu persetujuan login.</p>
            </div>
            @if($pendingUsers->count() > 0)
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $pendingUsers->count() }} Menunggu
                </span>
            @endif
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Nama Lengkap</th>
                    <th class="py-3 px-6 text-left">Username / Email</th>
                    <th class="py-3 px-6 text-left">Tanggal Daftar</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse($pendingUsers as $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-700">{{ $user->username ?? '-' }}</span>
                                <span class="text-xs text-gray-500">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $user->created_at->format('d M Y, H:i') }}
                            <span class="text-xs text-gray-400 block">({{ $user->created_at->diffForHumans() }})</span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <form id="approve-{{ $user->id }}" action="{{ route('admin.verifications.toggle', $user->id) }}" method="POST">
                                @csrf
                                <button type="button"
                                        onclick="confirmAction(event, 'approve-{{ $user->id }}', 'Terima User Ini?', 'User akan diizinkan login ke sistem.', 'Ya, Terima', '#10b981')"
                                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md text-xs transition transform hover:scale-105 flex items-center justify-center gap-1 mx-auto">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Terima
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500 bg-gray-50 italic">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <p>Tidak ada user baru yang perlu diverifikasi.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- ================================================== --}}
    {{-- TABEL 2: PERMINTAAN RESET PASSWORD                --}}
    {{-- ================================================== --}}
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg border-t-4 border-yellow-500">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                    Permintaan Reset Password
                </h2>
                <p class="text-sm text-gray-500 mt-1">User yang lupa password dan meminta reset manual.</p>
            </div>
            @if($resetRequests->count() > 0)
                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full animate-pulse">
                    {{ $resetRequests->count() }} Permintaan
                </span>
            @endif
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Nama User</th>
                    <th class="py-3 px-6 text-left">Identitas Akun</th>
                    <th class="py-3 px-6 text-left">Waktu Request</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse($resetRequests as $req)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <span class="font-medium text-gray-800">{{ $req->name }}</span>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-700">{{ $req->username ?? '-' }}</span>
                                <span class="text-xs text-gray-500">{{ $req->email }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $req->password_reset_requested_at->format('d M Y, H:i') }}
                            <span class="text-xs text-red-500 font-bold block">
                                    ({{ $req->password_reset_requested_at->diffForHumans() }})
                                </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <form id="reset-req-{{ $req->id }}" action="{{ route('admin.verifications.password_reset', $req->id) }}" method="POST">
                                @csrf
                                <button type="button"
                                        onclick="confirmAction(event, 'reset-req-{{ $req->id }}', 'Reset Password User Ini?', 'Password akan direset ke Tanggal Lahir (atau default).', 'Ya, Reset Password', '#f59e0b')"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow-md text-xs transition transform hover:scale-105 flex items-center justify-center gap-1 mx-auto">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                    Reset
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500 bg-gray-50 italic">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <p>Tidak ada permintaan reset password baru.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

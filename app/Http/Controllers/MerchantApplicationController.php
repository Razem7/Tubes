<?php

namespace App\Http\Controllers;

use App\Models\MerchantApplication;
use Illuminate\Http\Request;

class MerchantApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── User: form pendaftaran ─────────────────────────────────────────────

    public function create()
    {
        $user = auth()->user();

        // Merchant aktif tidak perlu daftar lagi
        if ($user->isMerchant()) {
            return redirect()->route('merchant.dashboard')
                ->with('error', 'Kamu sudah menjadi Merchant.');
        }

        // Cek apakah sudah ada pendaftaran pending/approved
        $existing = MerchantApplication::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->latest()
            ->first();

        if ($existing) {
            return redirect()->route('merchant.apply.status')
                ->with('info', 'Kamu sudah memiliki pendaftaran yang sedang diproses.');
        }

        return view('merchant.apply.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->isMerchant()) {
            return redirect()->route('merchant.dashboard');
        }

        $validated = $request->validate([
            // Data diri
            'owner_name'         => 'required|string|max:100',
            'owner_nik'          => 'required|digits:16',
            'owner_phone'        => 'required|string|max:20',
            'owner_dob'          => 'required|date|before:-17 years',
            'owner_address'      => 'required|string|max:255',
            'owner_city'         => 'required|string|max:100',
            'owner_province'     => 'required|string|max:100',
            'id_card_photo'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
            // Data toko
            'store_name'         => 'required|string|max:100',
            'store_category'     => 'required|string|max:100',
            'store_description'  => 'required|string|min:20|max:1000',
            'store_address'      => 'required|string|max:255',
            'store_city'         => 'required|string|max:100',
            'store_province'     => 'required|string|max:100',
            'store_phone'        => 'required|string|max:20',
            'store_email'        => 'nullable|email|max:100',
            'store_logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // Legalitas
            'npwp'               => 'nullable|string|max:20',
            'npwp_photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'siup_nib'           => 'nullable|string|max:50',
            'bank_name'          => 'required|string|max:50',
            'bank_account_number'=> 'required|string|max:30',
            'bank_account_name'  => 'required|string|max:100',
        ]);

        // Upload file
        if ($request->hasFile('id_card_photo')) {
            $validated['id_card_photo'] = $request->file('id_card_photo')->store('merchant/ktp', 'public');
        }
        if ($request->hasFile('store_logo')) {
            $validated['store_logo'] = $request->file('store_logo')->store('merchant/logo', 'public');
        }
        if ($request->hasFile('npwp_photo')) {
            $validated['npwp_photo'] = $request->file('npwp_photo')->store('merchant/npwp', 'public');
        }

        MerchantApplication::create(array_merge($validated, [
            'user_id' => $user->id,
            'status'  => 'pending',
        ]));

        return redirect()->route('merchant.apply.status')
            ->with('success', 'Pendaftaran berhasil dikirim! Kami akan mereview dalam 1–3 hari kerja.');
    }

    public function status()
    {
        $application = MerchantApplication::where('user_id', auth()->id())
            ->latest()
            ->first();

        return view('merchant.apply.status', compact('application'));
    }

    // ── Admin: review ──────────────────────────────────────────────────────

    public function adminIndex(Request $request)
    {
        $query = MerchantApplication::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(20);

        $counts = [
            'pending'  => MerchantApplication::where('status', 'pending')->count(),
            'approved' => MerchantApplication::where('status', 'approved')->count(),
            'rejected' => MerchantApplication::where('status', 'rejected')->count(),
        ];

        return view('admin.merchant-applications.index', compact('applications', 'counts'));
    }

    public function adminShow(MerchantApplication $application)
    {
        $application->load('user', 'reviewer');

        return view('admin.merchant-applications.show', compact('application'));
    }

    public function approve(MerchantApplication $application)
    {
        if (!$application->isPending()) {
            return back()->with('error', 'Pendaftaran ini sudah diproses.');
        }

        $application->update([
            'status'      => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Upgrade user role ke merchant
        $application->user->update(['role' => 'merchant']);

        return back()->with('success', 'Pendaftaran disetujui! ' . $application->store_name . ' sekarang menjadi Merchant.');
    }

    public function reject(Request $request, MerchantApplication $application)
    {
        if (!$application->isPending()) {
            return back()->with('error', 'Pendaftaran ini sudah diproses.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $application->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'reviewed_by'      => auth()->id(),
            'reviewed_at'      => now(),
        ]);

        return back()->with('success', 'Pendaftaran ditolak.');
    }
}

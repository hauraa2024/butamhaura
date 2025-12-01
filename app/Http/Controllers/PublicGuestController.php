<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicGuestEntryRequest;
use App\Models\GuestEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class PublicGuestController extends Controller
{
    public function create(Request $request): View
    {
        $first = random_int(1, 9);
        $second = random_int(1, 9);

        $request->session()->put('guest_captcha_answer', $first + $second);

        return view('public.guest-form', [
            'captchaQuestion' => "{$first} + {$second} = ?",
        ]);
    }

    public function store(PublicGuestEntryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['captcha']);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('guest-photos', 'public');
            $data['photo'] = $path;
        }

        GuestEntry::create(array_merge($data, [
            'status' => GuestEntry::STATUS_PENDING,
        ]));

        $request->session()->forget('guest_captcha_answer');

        return redirect()->route('landing')->with('status', 'Pengajuan tamu dikirim dan menunggu review admin.');
    }
}

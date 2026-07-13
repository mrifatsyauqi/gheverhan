<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index()
    {
        return view('profile.index', [
            'user' => Auth::user(),
        ]);
    }

    public function orders()
    {
        $orders = $this->orderService->getOrdersByUser(Auth::id());

        return view('profile.orders', [
            'orders' => $orders,
        ]);
    }

    public function orderDetail(string $orderNumber)
    {
        $order = $this->orderService->getOrderDetail($orderNumber);

        if (!$order || $order->user_id !== Auth::id()) {
            abort(404);
        }

        return view('profile.order-detail', [
            'order' => $order,
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        Auth::user()->update($request->validated());

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(\App\Http\Requests\UpdatePasswordRequest $request)
    {
        Auth::user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->validated('password')),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updateAvatar(\App\Http\Requests\UpdateAvatarRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::uuid() . '.' . $extension;

            // Delete old avatar if exists
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }

            $path = $file->storeAs('avatars', $filename, 'public');
            
            $user->update(['avatar' => $path]);
        }

        return back()->with('success', 'Avatar berhasil diperbarui.');
    }

    public function destroyAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return back()->with('success', 'Avatar berhasil dihapus.');
    }
}

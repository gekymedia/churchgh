<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin|pastor');
    }

    /**
     * Display the settings page.
     */
    public function index()
    {
        // Load from database or fallback to env/config
        $socialMediaSettings = [
            'facebook' => Setting::get('social_facebook', '') ?: config('services.social.facebook', ''),
            'twitter' => Setting::get('social_twitter', '') ?: config('services.social.twitter', ''),
            'instagram' => Setting::get('social_instagram', '') ?: config('services.social.instagram', ''),
            'youtube' => Setting::get('social_youtube', '') ?: config('services.social.youtube', ''),
            'whatsapp' => Setting::get('social_whatsapp', '') ?: config('services.social.whatsapp', ''),
            'website' => Setting::get('social_website', '') ?: config('services.social.website', ''),
        ];

        $paymentSettings = [
            'paystack_public_key' => Setting::get('paystack_public_key', '') ?: config('services.paystack.public_key', ''),
            'paystack_secret_key' => Setting::get('paystack_secret_key', '') ?: config('services.paystack.secret_key', ''),
        ];

        return view('admin.settings', compact('socialMediaSettings', 'paymentSettings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            // Social media
            'social_facebook' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_youtube' => 'nullable|url',
            'social_whatsapp' => 'nullable|string',
            'social_website' => 'nullable|url',
            // Payment
            'paystack_public_key' => 'nullable|string',
            'paystack_secret_key' => 'nullable|string',
        ]);

        // Save social media settings
        foreach (['facebook', 'twitter', 'instagram', 'youtube', 'website'] as $platform) {
            Setting::set("social_{$platform}", $data["social_{$platform}"] ?? '', 'url', 'social_media');
        }
        
        // WhatsApp is a phone number, not a URL
        Setting::set('social_whatsapp', $data['social_whatsapp'] ?? '', 'text', 'social_media');

        // Save payment settings
        Setting::set('paystack_public_key', $data['paystack_public_key'] ?? '', 'text', 'payment');
        Setting::set('paystack_secret_key', $data['paystack_secret_key'] ?? '', 'text', 'payment');

        // Update config cache if needed (optional - for immediate effect)
        // Note: In production, you might want to cache these settings

        return back()->with('success', 'Settings updated successfully.');
    }
}

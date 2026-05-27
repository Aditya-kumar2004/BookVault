<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OtpController extends Controller
{
    /**
     * Generate a 6-digit OTP, store it, and email it to the user.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name'  => 'nullable|string',
        ]);

        $email = $request->email;

        // Invalidate any previous unused OTPs for this email
        DB::table('otp_codes')
            ->where('email', $email)
            ->where('used', false)
            ->delete();

        // Generate a cryptographically random 6-digit OTP
        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP (valid for 10 minutes)
        DB::table('otp_codes')->insert([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
            'used'       => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Send email
        try {
            Mail::send([], [], function ($message) use ($email, $otp, $request) {
                $name    = $request->name ?? 'there';
                $appName = config('app.name', 'BookVault');

                $otpChars = str_split($otp);
                $otpHtml = '';
                foreach ($otpChars as $char) {
                    $otpHtml .= '<span style="display: inline-block; width: 44px; height: 54px; line-height: 54px; text-align: center; background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 12px; font-size: 28px; font-weight: 900; color: #F4623A; margin: 0 4px; font-family: \'Courier New\', Courier, monospace; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">' . $char . '</span>';
                }

                $message->to($email)
                    ->subject("Your {$appName} Verification Code")
                    ->html(<<<HTML
<div style="background-color: #f3f4f6; padding: 40px 20px; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; min-height: 100%;">
    <div style="max-width: 500px; margin: 0 auto; background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); border: 1px solid #e5e7eb;">
        <!-- Brand Top Accent Bar -->
        <div style="height: 6px; background: linear-gradient(90deg, #F4623A 0%, #1B4332 100%);"></div>
        
        <!-- Email Header / Logo -->
        <div style="padding: 32px 32px 20px 32px; border-bottom: 1px solid #f3f4f6; display: table; width: 100%; box-sizing: border-box;">
            <div style="display: table-cell; vertical-align: middle;">
                <span style="font-size: 24px; font-weight: bold; color: #1B4332; font-family: 'Playfair Display', serif; display: inline-block;">
                    📚 Book<span style="color: #F4623A;">Vault</span>
                </span>
            </div>
            <div style="display: table-cell; vertical-align: middle; text-align: right; font-size: 11px; font-weight: 800; color: #9ca3af; text-transform: uppercase; letter-spacing: 1.5px;">
                Verification
            </div>
        </div>

        <!-- Email Body -->
        <div style="padding: 40px 32px; box-sizing: border-box;">
            <h2 style="font-size: 22px; font-weight: 800; color: #111827; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                Verify Your Email Address
            </h2>
            <p style="font-size: 15px; color: #4b5563; line-height: 1.6; margin: 0 0 24px 0;">
                Hi <strong style="color: #111827;">{$name}</strong>,
            </p>
            <p style="font-size: 15px; color: #4b5563; line-height: 1.6; margin: 0 0 32px 0;">
                Welcome to BookVault! To complete your registration and secure your new account, please use the 6-digit verification code below:
            </p>

            <!-- OTP Block -->
            <div style="background-color: #f9fafb; border: 1px dashed #e5e7eb; border-radius: 16px; padding: 24px; text-align: center; margin: 32px 0;">
                <div style="font-size: 11px; font-weight: 800; color: #9ca3af; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 16px;">
                    Your One-Time Passcode
                </div>
                <div style="text-align: center; margin-bottom: 14px; white-space: nowrap;">
                    {$otpHtml}
                </div>
                <div style="font-size: 12px; color: #6b7280; margin-top: 14px;">
                    This passcode is valid for <strong style="color: #111827;">10 minutes</strong>.
                </div>
            </div>

            <!-- Warning and Assistance -->
            <p style="font-size: 13px; color: #9ca3af; line-height: 1.5; margin: 32px 0 0 0; border-top: 1px solid #f3f4f6; padding-top: 24px;">
                💡 <strong>Security Note:</strong> If you did not request this verification code, please ignore this email or reach out to us at <a href="mailto:support@bookvault.io" style="color: #1B4332; text-decoration: none; font-weight: 600;">support@bookvault.io</a>.
            </p>
        </div>

        <!-- Email Footer -->
        <div style="background-color: #f9fafb; padding: 24px 32px; text-align: center; border-top: 1px solid #f3f4f6; box-sizing: border-box;">
            <p style="font-size: 12px; color: #9ca3af; margin: 0 0 6px 0;">
                © 2026 BookVault. All rights reserved.
            </p>
            <p style="font-size: 11px; color: #cbd5e1; margin: 0;">
                Delivered with care to secure your literary journey.
            </p>
        </div>
    </div>
</div>
HTML
);
            });
        } catch (\Exception $e) {
            // Even if email fails, log and return a generic error
            \Log::error('OTP email send failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to send OTP email. Please check mail configuration.',
                'error'   => $e->getMessage(),
            ], 500);
        }

        return response()->json(['message' => 'OTP sent successfully. Check your email.']);
    }

    /**
     * Verify the OTP submitted by the user.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $record = DB::table('otp_codes')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$record) {
            return response()->json([
                'message' => 'Invalid or expired OTP. Please request a new one.',
            ], 422);
        }

        // Mark OTP as used
        DB::table('otp_codes')
            ->where('id', $record->id)
            ->update(['used' => true, 'updated_at' => Carbon::now()]);

        return response()->json(['message' => 'OTP verified successfully.', 'verified' => true]);
    }

    /**
     * Subscribe a user to the newsletter and send a welcome email.
     */
    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // Save or update subscription
        $subscribed = DB::table('newsletter_subscriptions')->where('email', $email)->first();
        if (!$subscribed) {
            DB::table('newsletter_subscriptions')->insert([
                'email'      => $email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            DB::table('newsletter_subscriptions')
                ->where('email', $email)
                ->update(['updated_at' => Carbon::now()]);
        }

        // Send Welcome Email
        try {
            Mail::send([], [], function ($message) use ($email) {
                $appName = config('app.name', 'BookVault');
                $frontendUrl = rtrim(config('app.frontend_url', 'http://localhost:8080'), '/');

                $message->to($email)
                    ->subject("Welcome to BookVault! Here is your 20% discount code 🎉")
                    ->html(<<<HTML
<div style="background-color: #f3f4f6; padding: 40px 20px; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; min-height: 100%;">
    <div style="max-width: 550px; margin: 0 auto; background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); border: 1px solid #e5e7eb;">
        <!-- Brand Top Accent Bar -->
        <div style="height: 6px; background: linear-gradient(90deg, #F4623A 0%, #1B4332 100%);"></div>
        
        <!-- Email Header / Logo -->
        <div style="padding: 32px 32px 20px 32px; border-bottom: 1px solid #f3f4f6; display: table; width: 100%; box-sizing: border-box;">
            <div style="display: table-cell; vertical-align: middle;">
                <span style="font-size: 24px; font-weight: bold; color: #1B4332; font-family: 'Playfair Display', serif; display: inline-block;">
                    📚 Book<span style="color: #F4623A;">Vault</span>
                </span>
            </div>
            <div style="display: table-cell; vertical-align: middle; text-align: right; font-size: 11px; font-weight: 800; color: #F4623A; text-transform: uppercase; letter-spacing: 1.5px;">
                Welcome Offer
            </div>
        </div>

        <!-- Email Body -->
        <div style="padding: 40px 32px; box-sizing: border-box;">
            <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin: 0 0 12px 0; font-family: 'Outfit', sans-serif;">
                Thank you for subscribing!
            </h2>
            <p style="font-size: 15px; color: #4b5563; line-height: 1.6; margin: 0 0 24px 0;">
                We are thrilled to welcome you to the <strong>BookVault</strong> family. Get ready for curations of the best-selling masterpieces, handpicked literature recommendations, exclusive subscriber-only deals, and first access to new releases!
            </p>
            <p style="font-size: 15px; color: #4b5563; line-height: 1.6; margin: 0 0 32px 0;">
                As a token of our appreciation, please enjoy <strong>20% off</strong> your first order with us. Copy the exclusive promo code below and apply it at checkout:
            </p>

            <!-- Discount Badge Block -->
            <div style="background-color: #f0f7f4; border: 1.5px dashed #1B4332; border-radius: 16px; padding: 24px; text-align: center; margin: 32px 0;">
                <div style="font-size: 11px; font-weight: 800; color: #1B4332; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px;">
                    Your Exclusive Coupon Code
                </div>
                <div style="font-size: 36px; font-weight: 900; color: #F4623A; letter-spacing: 2px; font-family: 'Courier New', Courier, monospace; display: inline-block;">
                    BVAULT20
                </div>
                <div style="font-size: 12px; color: #1B4332; font-weight: 600; margin-top: 10px;">
                    Valid for all books & collections
                </div>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center; margin: 36px 0 24px 0;">
                <a href="{$frontendUrl}" style="display: inline-block; background: linear-gradient(90deg, #F4623A 0%, #ff7e5f 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; font-size: 15px; font-weight: bold; border-radius: 50px; box-shadow: 0 4px 15px rgba(244, 98, 58, 0.35); text-transform: uppercase; letter-spacing: 1px;">
                    Shop Now & Save
                </a>
            </div>

            <!-- Footer warning -->
            <p style="font-size: 13px; color: #9ca3af; line-height: 1.5; margin: 32px 0 0 0; border-top: 1px solid #f3f4f6; padding-top: 24px;">
                💡 <strong>Need any assistance?</strong> If you have any questions about your discount, ordering, or shipping, we'd love to help! Reach out directly at <a href="mailto:support@bookvault.io" style="color: #1B4332; text-decoration: none; font-weight: 600;">support@bookvault.io</a>.
            </p>
        </div>

        <!-- Email Footer -->
        <div style="background-color: #f9fafb; padding: 24px 32px; text-align: center; border-top: 1px solid #f3f4f6; box-sizing: border-box;">
            <p style="font-size: 12px; color: #9ca3af; margin: 0 0 6px 0;">
                © 2026 BookVault. All rights reserved.
            </p>
            <p style="font-size: 11px; color: #cbd5e1; margin: 0;">
                Delivering literary magic directly to your inbox.
            </p>
        </div>
    </div>
</div>
HTML
);
            });
        } catch (\Exception $e) {
            \Log::error('Newsletter email send failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Subscription successful, but failed to send the welcome email.',
                'error'   => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Subscribed successfully! Check your inbox for the 20% discount code 🎉',
        ]);
    }
}

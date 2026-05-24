<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed | BookVault</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for premium layout styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            emerald: '#1B4332',
                            mint: '#40916C',
                            coral: '#F4623A',
                            peach: '#FEEAFA',
                        }
                    },
                    fontFamily: {
                        sans: ['"Instrument Sans"', 'sans-serif'],
                        display: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8FAFC] text-[#1E293B] font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Header -->
    <header class="py-5 px-6 border-b border-gray-100 bg-white">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="w-3.5 h-3.5 bg-brand-coral rounded-full inline-block"></span>
                <span class="font-display text-2xl font-bold text-brand-emerald">BookVault</span>
            </div>
            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-brand-coral/10 text-brand-coral">
                Payment Blocked
            </span>
        </div>
    </header>

    <!-- Error Container -->
    <main class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-lg">
            
            <!-- Error Receipt Card -->
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden relative p-8 text-center space-y-6">
                
                <!-- Error Warning Icon -->
                <div class="h-20 w-20 bg-brand-coral/10 text-brand-coral rounded-full flex items-center justify-center mx-auto animate-pulse">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <div class="space-y-2">
                    <p class="text-brand-coral font-bold uppercase tracking-widest text-xs">Authorization Interrupted</p>
                    <h1 class="text-3xl font-display font-bold text-brand-emerald">Payment Failed</h1>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm mx-auto">
                        Something went wrong during signature capture or checkouts verification. Please review the details below.
                    </p>
                </div>

                <!-- Error Logs Breakdown -->
                <div class="p-6 rounded-2xl bg-brand-coral/5 border border-brand-coral/10 text-left space-y-2">
                    <span class="text-xs text-brand-coral font-bold uppercase tracking-wider block">Error Description / Reason</span>
                    <p class="text-sm font-medium text-gray-800 leading-relaxed font-mono">
                        {{ $message ?? 'The checkout was cancelled or the session key signature validation rejected the payment verification.' }}
                    </p>
                </div>

                <!-- Retry Trigger -->
                <div>
                    <a href="/payment" class="block w-full py-4 px-6 rounded-2xl bg-brand-coral hover:bg-opacity-95 text-white font-bold text-sm tracking-wide transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 duration-200">
                        Try Again
                    </a>
                </div>
            </div>

            <div class="text-center mt-6">
                <a href="/" class="text-xs font-semibold text-gray-400 hover:text-brand-coral transition-all">
                    ← Return to Storefront
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-xs text-gray-400 bg-white border-t border-gray-100">
        © 2026 My Laravel Store. All rights reserved. Razorpay Sandbox Environment.
    </footer>

</body>
</html>

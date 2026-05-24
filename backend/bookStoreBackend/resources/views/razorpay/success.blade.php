<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful! | BookVault</title>
    
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
                <span class="w-3.5 h-3.5 bg-brand-mint rounded-full inline-block"></span>
                <span class="font-display text-2xl font-bold text-brand-emerald">BookVault</span>
            </div>
            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-emerald-500/10 text-emerald-600">
                Paid Successfully
            </span>
        </div>
    </header>

    <!-- Success Container -->
    <main class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-lg">
            
            <!-- Success Receipt Card -->
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden relative p-8 text-center space-y-6">
                
                <!-- Success Animated Icon -->
                <div class="h-20 w-20 bg-emerald-500/10 text-emerald-600 rounded-full flex items-center justify-center mx-auto animate-bounce">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <div class="space-y-2">
                    <p class="text-brand-mint font-bold uppercase tracking-widest text-xs">Transaction Approved</p>
                    <h1 class="text-3xl font-display font-bold text-brand-emerald">Payment Received! 🎉</h1>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm mx-auto">
                        Your test purchase has been processed and captured successfully via Razorpay Payment Gateway.
                    </p>
                </div>

                <!-- Receipt Breakdown -->
                <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 text-left space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Razorpay Payment ID</span>
                        <span class="text-sm font-mono font-bold text-gray-800">{{ $payment_id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Order ID Reference</span>
                        <span class="text-sm font-mono font-bold text-gray-800">{{ $order_id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Method Used</span>
                        <span class="text-xs font-semibold uppercase bg-gray-200/60 text-gray-700 px-2 py-0.5 rounded">
                            {{ $method }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Customer Email</span>
                        <span class="text-xs font-bold text-gray-700">{{ $email }}</span>
                    </div>
                    <hr class="border-gray-200/60 my-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Captured Amount</span>
                        <span class="text-xl font-bold text-brand-emerald">₹{{ $amount }}</span>
                    </div>
                </div>

                <!-- Return Button -->
                <div>
                    <a href="/payment" class="block w-full py-4 px-6 rounded-2xl bg-brand-emerald hover:bg-opacity-95 text-white font-bold text-sm tracking-wide transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 duration-200">
                        Test Another Payment
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

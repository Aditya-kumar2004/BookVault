<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment | My Laravel Store</title>
    
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
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1B4332 0%, #0D1B2A 100%);
        }
        .coral-glow {
            box-shadow: 0 10px 30px -10px rgba(244, 98, 58, 0.3);
        }
        .premium-card {
            backdrop-filter: blur(16px);
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .shimmer-btn {
            position: relative;
            overflow: hidden;
        }
        .shimmer-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.3) 30%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            transition: all 0.5s ease;
            opacity: 0;
        }
        .shimmer-btn:hover::after {
            opacity: 1;
            left: 120%;
            transition: all 0.7s ease-in-out;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-[#1E293B] font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="py-5 px-6 border-b border-gray-100 bg-white">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="w-3.5 h-3.5 bg-brand-coral rounded-full inline-block animate-ping"></span>
                <span class="font-display text-2xl font-bold text-brand-emerald">BookVault</span>
            </div>
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest">
                Secure Checkout
            </div>
        </div>
    </header>

    <!-- Main Payment Container -->
    <main class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-lg">
            
            <!-- Payment Card -->
            <div class="premium-card rounded-3xl shadow-2xl border border-gray-100 overflow-hidden relative">
                
                <!-- Card Header Visual -->
                <div class="gradient-bg p-8 text-white relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-mint opacity-10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-brand-coral opacity-10 rounded-full blur-xl -ml-5 -mb-5"></div>
                    
                    <p class="text-brand-mint font-bold uppercase tracking-widest text-xs">Payment Authorization</p>
                    <h1 class="text-3xl font-display font-bold mt-2">Complete Your Order</h1>
                    <p class="text-gray-300 text-sm mt-1">Please authorize the test payment below to proceed.</p>
                </div>
                
                <!-- Order & Billing Details -->
                <div class="p-8 space-y-6">
                    
                    <!-- Billing Summary -->
                    <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100 space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Demo Purchase Item</span>
                            <span class="text-gray-800 font-semibold">Razorpay Demo Package</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Store</span>
                            <span class="text-gray-800 font-semibold">My Laravel Store</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Currency / Class</span>
                            <span class="text-gray-800 font-semibold font-mono text-xs">INR / Sandboxed</span>
                        </div>
                        <hr class="border-gray-200/60 my-2">
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-wider block">Total Amount</span>
                                <span class="text-2xl font-bold text-brand-emerald">₹500.00</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-brand-mint/10 text-brand-mint">
                                Test Mode
                            </span>
                        </div>
                    </div>

                    <!-- Customer Info Card -->
                    <div class="space-y-3">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pre-filled Customer Parameters</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3.5 rounded-xl border border-gray-100 bg-white">
                                <span class="text-[10px] text-gray-400 block font-semibold">EMAIL ADDRESS</span>
                                <span class="text-xs text-gray-800 font-bold">demouser@example.com</span>
                            </div>
                            <div class="p-3.5 rounded-xl border border-gray-100 bg-white">
                                <span class="text-[10px] text-gray-400 block font-semibold">CONTACT NUMBER</span>
                                <span class="text-xs text-gray-800 font-bold">+91 99999 99999</span>
                            </div>
                        </div>
                    </div>

                    <!-- Razorpay Trigger Form -->
                    <div class="pt-4">
                        <!-- Redirect Form on signature success callback -->
                        <form id="callback-form" action="{{ route('payment.callback') }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                            <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                        </form>

                        <button 
                            id="pay-button"
                            type="button" 
                            class="w-full py-4 px-6 rounded-2xl bg-brand-coral hover:bg-opacity-95 text-white font-bold text-sm tracking-wide transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 duration-200 flex items-center justify-center gap-2.5 shimmer-btn coral-glow"
                        >
                            <svg id="pay-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span id="btn-text">Pay Now (₹500.00)</span>
                        </button>
                    </div>
                </div>

                <!-- Trusted/Safety Footer -->
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <svg class="h-4 w-4 text-brand-mint" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Secured & encrypted with official <b>Razorpay SDK</b></span>
                </div>
            </div>

            <!-- Cancel Back to Home Link -->
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

    <!-- Razorpay Checkout Integration -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        const btn = document.getElementById('pay-button');
        const btnText = document.getElementById('btn-text');
        const payIcon = document.getElementById('pay-icon');
        const originalText = btnText.innerHTML;

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Set payment loading state
            btn.disabled = true;
            btnText.innerHTML = "Opening Secure Gateway...";
            payIcon.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;

            const options = {
                "key": "{{ $keyId }}",
                "amount": "50000", // in paise (₹500.00)
                "currency": "INR",
                "name": "My Laravel Store",
                "description": "Razorpay Demo Payment",
                "image": "https://laravel.com/img/logomark.min.svg",
                "order_id": "{{ $orderId }}",
                "handler": function (response) {
                    // Populate parameters and submit back to signature verification callback
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                    document.getElementById('razorpay_signature').value = response.razorpay_signature;
                    
                    btnText.innerHTML = "Verifying Signature...";
                    document.getElementById('callback-form').submit();
                },
                "prefill": {
                    "name": "Demo User",
                    "email": "demouser@example.com",
                    "contact": "9999999999"
                },
                "theme": {
                    "color": "#1B4332" // Sleek emerald green color matching logo theme
                },
                "modal": {
                    "ondismiss": function() {
                        // Dismissed, restore button states
                        btn.disabled = false;
                        btnText.innerHTML = originalText;
                        payIcon.innerHTML = `
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        `;
                    }
                }
            };

            const rzp = new Razorpay(options);
            
            rzp.on('payment.failed', function (response) {
                // In case of instant fail inside SDK frame
                window.location.href = "{{ route('payment.show') }}?error=" + encodeURIComponent(response.error.description);
            });

            rzp.open();
        });
    </script>
</body>
</html>

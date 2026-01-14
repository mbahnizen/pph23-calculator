<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator PPh 23 Pro - @mbahnizen</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700;800&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            primary: '#8b5cf6',
                            secondary: '#ec4899',
                            emerald: '#10b981',
                            dark: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .glass-card {
                @apply bg-slate-900/50 backdrop-blur-xl border border-white/5 shadow-2xl;
            }
            .input-base {
                @apply bg-slate-800/50 border border-slate-700 text-white placeholder-slate-500 focus:border-brand-primary focus:ring-1 focus:ring-brand-primary outline-none transition-all;
            }
        }
        @media print {
            body { background: white !important; color: black !important; }
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            .glass-card { background: none !important; border: 1px solid #ddd !important; shadow: none !important; }
            .text-white { color: black !important; }
            .text-slate-400 { color: #666 !important; }
        }
    </style>
</head>

<body class="bg-brand-dark text-slate-300 min-h-screen font-sans selection:bg-brand-primary/30">

    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10 no-print">
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-brand-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-brand-emerald/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Toast Notification -->
    <div x-data="{ show: false, message: '' }"
        @notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
        class="fixed top-6 right-6 z-50 bg-slate-800/90 backdrop-blur-md border border-brand-emerald/40 text-brand-emerald px-4 py-3 rounded-xl shadow-2xl flex items-center gap-2"
        style="display: none;">
        <i class="ph-fill ph-check-circle text-lg"></i>
        <span class="font-medium text-sm" x-text="message"></span>
    </div>

    <main class="container mx-auto px-4 py-8 md:py-16 flex flex-col items-center justify-center min-h-screen">

        <!-- App Container -->
        <div x-data="taxCalculator()" x-init="initData(<?= $results ? json_encode($results) : 'null' ?>)"
            class="glass-card w-full max-w-2xl rounded-3xl p-6 md:p-10 relative overflow-hidden">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8 no-print">
                <a href="https://apps.nizen.my.id"
                    class="flex items-center gap-2 text-slate-400 hover:text-white transition-colors group">
                    <i class="ph ph-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
                    <span class="text-sm font-medium">Kembali</span>
                </a>
            </div>

            <!-- Title Section -->
            <div class="text-center mb-10">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand-emerald/20 to-brand-primary/20 mb-4 ring-1 ring-white/10">
                    <i class="ph ph-calculator text-3xl text-white"></i>
                </div>
                <h1 class="font-display text-3xl md:text-4xl font-bold text-white mb-2">PPh 23 Calculator</h1>
                <p class="text-slate-400">Hitung pajak penghasilan dan PPN secara real-time.</p>
            </div>

            <!-- Calculator Form -->
            <div class="space-y-8">
                <!-- Subtotal Input -->
                <div class="relative group">
                    <div class="flex justify-between items-end mb-2 ml-1">
                        <label for="subtotal" class="block text-sm font-medium text-slate-300">Nilai Subtotal</label>
                        <div x-show="isMathExpression" x-transition class="text-right">
                            <div class="text-xs text-slate-500 mb-0.5">Hasil Penjumlahan:</div>
                            <div
                                class="text-sm font-mono text-brand-emerald font-bold bg-brand-emerald/10 px-2 py-0.5 rounded border border-brand-emerald/20">
                                <span x-text="formatCurrency(subtotal)"></span>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span
                                class="text-slate-500 font-semibold group-focus-within:text-brand-primary transition-colors">Rp</span>
                        </div>
                        <input type="text" x-model="formattedSubtotal" @input="updateCalculation"
                            class="input-base w-full pl-12 pr-4 py-4 rounded-xl text-xl font-mono"
                            placeholder="Contoh: 500000 + 150000" autofocus>
                    </div>
                    <!-- Helper Text -->
                    <p class="text-xs text-slate-500 mt-2 ml-1">
                        <i class="ph ph-info mr-1"></i> Tip: Bisa menjumlahkan langsung, contoh: <code
                            class="bg-slate-800 px-1 rounded text-slate-400">100.000 + 50.000</code>
                    </p>

                    <!-- PHP Error Fallback -->
                    <?php if ($error_message): ?>
                        <p class="text-red-400 text-sm mt-2 flex items-center gap-1">
                            <i class="ph-fill ph-warning-circle"></i> <?= $error_message ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Live Results -->
                <div class="space-y-4 pt-4 border-t border-white/5" x-show="subtotal > 0"
                    x-transition.opacity.duration.300ms>

                    <h3
                        class="text-white font-semibold text-sm uppercase tracking-wider text-center md:text-left text-slate-500 mb-2">
                        Rincian Perhitungan</h3>

                    <!-- Calculation Grid -->
                    <div class="grid gap-3">
                        <!-- PPN Row -->
                        <div
                            class="flex justify-between items-center p-3 rounded-lg hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400">PPN (11%)</span>
                            </div>
                            <div class="font-mono text-white flex items-center gap-3">
                                <span x-text="formatCurrency(results.ppn_value)"></span>
                            </div>
                        </div>

                        <!-- Subtotal + PPN -->
                        <div
                            class="flex justify-between items-center p-3 rounded-lg hover:bg-white/5 transition-colors">
                            <span class="text-slate-400">Subtotal + PPN</span>
                            <span class="font-mono text-white"
                                x-text="formatCurrency(results.subtotal_plus_ppn)"></span>
                        </div>

                        <!-- PPh 23 Row -->
                        <div
                            class="flex justify-between items-center p-3 rounded-lg hover:bg-white/5 transition-colors">
                            <span class="text-slate-400">PPh 23 (2%)</span>
                            <span class="font-mono text-rose-400">-<span
                                    x-text="formatCurrency(results.pph23_value)"></span></span>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div
                        class="mt-6 bg-gradient-to-r from-brand-emerald/10 to-transparent border border-brand-emerald/20 rounded-2xl p-6 flex flex-col md:flex-row justify-between items-center gap-4">
                        <span class="text-brand-emerald font-bold uppercase tracking-widest text-sm">Total Bersih</span>
                        <div class="flex items-center gap-3">
                            <span class="text-3xl font-display font-bold text-white tracking-tight"
                                x-text="formatCurrency(results.total, true)"></span>
                            <button @click="copyToClipboard(results.total)"
                                class="p-2 hover:bg-brand-emerald/20 rounded-lg text-brand-emerald transition-colors no-print group relative"
                                title="Copy Total">
                                <i class="ph ph-copy text-lg group-active:scale-90 transition-transform"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Empty State -->
                <div x-show="subtotal <= 0" class="text-center py-8 text-slate-600 no-print">
                    <p>Masukkan nilai subtotal untuk melihat hasil perhitungan.</p>
                </div>
            </div>

            <footer class="mt-12 text-center text-xs text-slate-600 border-t border-white/5 pt-6">
                &copy; <?= date('Y') ?> @mbahnizen. All rights reserved.
            </footer>

        </div>
    </main>

    <!-- Confetti JS -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <!-- Alpine Logic -->
    <script>
        function taxCalculator() {
            return {
                subtotal: 0,
                formattedSubtotal: '',
                isMathExpression: false,
                results: {
                    ppn_value: 0,
                    subtotal_plus_ppn: 0,
                    pph23_value: 0,
                    total: 0
                },

                initData(phpData) {
                    if (phpData) {
                        this.subtotal = parseFloat(phpData.subtotal);
                        // If PHP passed back a raw expression string, use it, else format
                        // Since we passed subtotal float, we just format it.
                        // If PHP passed back the raw input (expression), we should use that.
                        // But for simplicity let's just format the subtotal result.
                        this.formattedSubtotal = new Intl.NumberFormat('id-ID').format(this.subtotal);
                        this.results = phpData;
                    }
                },

                parseInput(str) {
                    if (!str) return 0;
                    let clean = str.trim();
                    // Heuristic: If it ends with .XX (1 or 2 digits), treat that dot as a decimal (comma)
                    clean = clean.replace(/\.(\d{1,2})$/, ',$1');

                    // ID Standard: Remove thousand separators (.)
                    clean = clean.replace(/\./g, '');
                    // ID Standard: Replace decimal separator (,) with dot (.)
                    clean = clean.replace(',', '.');

                    return parseFloat(clean) || 0;
                },

                updateCalculation() {
                    // Sanitize Input: Only allow 0-9, +, whitespace, dots, and commas
                    this.formattedSubtotal = this.formattedSubtotal.replace(/[^0-9+\s\.,]/g, '');

                    const rawInput = this.formattedSubtotal;

                    if (rawInput.includes('+')) {
                        this.isMathExpression = true;
                        const parts = rawInput.split('+');
                        let sum = 0;
                        parts.forEach(part => sum += this.parseInput(part));

                        this.subtotal = sum;
                    } else {
                        this.isMathExpression = false;
                        this.subtotal = this.parseInput(rawInput);

                        // Only auto-format if strictly integer (no comma, no decimal-like dot)
                        // This prevents fighting the cursor when typing decimals
                        if (!rawInput.includes(',') && !rawInput.match(/\.\d{1,2}$/)) {
                            // Use raw value for check to allow typing "10." without it disappearing
                            if (rawInput && !rawInput.endsWith('.')) {
                                // Re-format clean integers
                                this.formattedSubtotal = new Intl.NumberFormat('id-ID').format(this.subtotal);
                            }
                        }
                    }

                    // Calculation Logic
                    const ppnRate = 0.11;
                    const pph23Rate = 0.02;

                    const ppnValue = this.subtotal * ppnRate;
                    const subtotalPlusPpn = this.subtotal + ppnValue;
                    const pph23Value = this.subtotal * pph23Rate;
                    const total = subtotalPlusPpn - pph23Value;

                    this.results = {
                        ppn_value: ppnValue,
                        subtotal_plus_ppn: subtotalPlusPpn,
                        pph23_value: pph23Value,
                        total: total
                    };
                },

                formatCurrency(value, withSymbol = false) {
                    if (value === undefined || value === null) return '0';
                    const formatted = new Intl.NumberFormat('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2
                    }).format(value);

                    return withSymbol ? `Rp ${formatted}` : formatted;
                },

                async copyToClipboard(text) {
                    try {
                        const amount = Math.round(text);
                        await navigator.clipboard.writeText(amount);

                        // 1. Dispatch Toast
                        window.dispatchEvent(new CustomEvent('notify', { detail: 'Total disalin: ' + this.formatCurrency(amount, true) }));

                        // 2. Fire Confetti
                        confetti({
                            particleCount: 100,
                            spread: 70,
                            origin: { y: 0.6 },
                            colors: ['#10b981', '#8b5cf6', '#ec4899']
                        });

                    } catch (err) {
                        console.error('Failed to copy', err);
                    }
                }
            }
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <title>Kalkulator PPh 23 & PPN Online — Hitung Pajak Otomatis | @mbahnizen</title>
    <meta name="description"
        content="Hitung PPh 23 (2%) dan PPN (11%) secara otomatis. Kalkulator pajak Indonesia gratis dengan dukungan format angka lokal dan hasil real-time.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://apps.nizen.my.id/pph23-calculator">

    <!-- OpenGraph -->
    <meta property="og:title" content="Kalkulator PPh 23 & PPN Online">
    <meta property="og:description"
        content="Hitung pajak penghasilan pasal 23 dan PPN secara real-time. Gratis, cepat, dan akurat.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://apps.nizen.my.id/pph23-calculator">
    <meta property="og:locale" content="id_ID">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="apple-touch-icon" href="favicon.svg">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;700;800&display=swap"
        rel="stylesheet">
</head>

<body class="bg-brand-dark text-slate-300 min-h-screen font-sans selection:bg-brand-primary/30">

    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10 no-print" aria-hidden="true">
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
        style="display: none;" role="alert" aria-live="polite">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 256 256">
            <path
                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm45.66,85.66-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35a8,8,0,0,1,11.32,11.32Z">
            </path>
        </svg>
        <span class="font-medium text-sm" x-text="message"></span>
    </div>

    <main class="container mx-auto px-4 py-8 md:py-16 flex flex-col items-center justify-center min-h-screen">

        <!-- App Container -->
        <div x-data="taxCalculator()" x-init="initFromServer(<?= $results ? json_encode($results) : 'null' ?>, '<?= htmlspecialchars($rawInput, ENT_QUOTES) ?>')"
            class="glass-card w-full max-w-2xl rounded-3xl p-6 md:p-10 relative overflow-hidden">

            <!-- Header -->
            <header class="flex items-center justify-between mb-8 no-print">
                <a href="https://apps.nizen.my.id"
                    class="flex items-center gap-2 text-slate-400 hover:text-white transition-colors group"
                    id="back-link">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="currentColor"
                        viewBox="0 0 256 256">
                        <path
                            d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">Kembali</span>
                </a>
            </header>

            <!-- Title Section -->
            <div class="text-center mb-10">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-brand-emerald/20 to-brand-primary/20 mb-4 ring-1 ring-white/10">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M200,32H56A24,24,0,0,0,32,56V200a24,24,0,0,0,24,24H200a24,24,0,0,0,24-24V56A24,24,0,0,0,200,32Zm8,168a8,8,0,0,1-8,8H56a8,8,0,0,1-8-8V56a8,8,0,0,1,8-8H200a8,8,0,0,1,8,8Zm-32-96a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,104Zm0,48a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h80A8,8,0,0,1,176,152Z">
                        </path>
                    </svg>
                </div>
                <h1 class="font-display text-3xl md:text-4xl font-bold text-white mb-2">PPh 23 Calculator</h1>
                <p class="text-slate-400">Hitung pajak penghasilan dan PPN secara real-time.</p>
            </div>

            <!-- Calculator Form -->
            <section class="space-y-8" aria-label="Form Kalkulator">
                <form method="POST" action="" id="calc-form" @submit.prevent="submitForm">
                    <!-- Subtotal Input -->
                    <div class="relative group">
                        <div class="flex justify-between items-end mb-2 ml-1">
                            <label for="subtotal" class="block text-sm font-medium text-slate-300">Nilai
                                Subtotal</label>
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
                            <input type="text" id="subtotal" name="subtotal" x-model="formattedSubtotal"
                                @input="updateCalculation"
                                class="input-base w-full pl-12 pr-4 py-4 rounded-xl text-xl font-mono"
                                placeholder="Contoh: 500.000 + 150.000" autocomplete="off" autofocus>
                        </div>
                        <!-- Helper Text -->
                        <p class="text-xs text-slate-500 mt-2 ml-1">
                            <svg class="w-3.5 h-3.5 inline-block mr-0.5 -mt-0.5" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm-8-80V80a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,172Z">
                                </path>
                            </svg>
                            Tip: Bisa menjumlahkan langsung, contoh: <code
                                class="bg-slate-800 px-1 rounded text-slate-400">100.000 + 50.000</code>
                        </p>

                        <!-- Server-side Error -->
                        <?php if ($error): ?>
                            <p class="text-red-400 text-sm mt-2 flex items-center gap-1" role="alert">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 256 256">
                                    <path
                                        d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm-8,56a8,8,0,0,1,16,0v56a8,8,0,0,1-16,0Zm8,104a12,12,0,1,1,12-12A12,12,0,0,1,128,184Z">
                                    </path>
                                </svg>
                                <?= htmlspecialchars($error) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Hidden submit for form fallback (no-JS) -->
                    <noscript>
                        <button type="submit"
                            class="mt-4 w-full bg-brand-primary text-white py-3 rounded-xl font-semibold hover:bg-brand-primary/90 transition-colors">
                            Hitung Pajak
                        </button>
                    </noscript>
                </form>

                <!-- Live Results -->
                <section class="space-y-4 pt-4 border-t border-white/5" x-show="subtotal > 0"
                    x-transition.opacity.duration.300ms aria-label="Hasil Perhitungan">

                    <h2
                        class="text-sm uppercase tracking-wider text-slate-500 font-semibold text-center md:text-left mb-2">
                        Rincian Perhitungan</h2>

                    <!-- Calculation Grid -->
                    <div class="grid gap-3">
                        <!-- Subtotal Row -->
                        <div
                            class="flex justify-between items-center p-3 rounded-lg hover:bg-white/5 transition-colors">
                            <span class="text-slate-400">Subtotal</span>
                            <span class="font-mono text-white" x-text="formatCurrency(subtotal)"></span>
                        </div>

                        <!-- PPN Row -->
                        <div
                            class="flex justify-between items-center p-3 rounded-lg hover:bg-white/5 transition-colors">
                            <span class="text-slate-400">PPN (11%)</span>
                            <span class="font-mono text-white"
                                x-text="'+' + formatCurrency(results.ppn_value)"></span>
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
                            <span class="font-mono text-rose-400"
                                x-text="'-' + formatCurrency(results.pph23_value)"></span>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div
                        class="mt-6 bg-gradient-to-r from-brand-emerald/10 to-transparent border border-brand-emerald/20 rounded-2xl p-6 flex flex-col md:flex-row justify-between items-center gap-4">
                        <span class="text-brand-emerald font-bold uppercase tracking-widest text-sm">Total
                            Bersih</span>
                        <div class="flex items-center gap-3">
                            <span class="text-3xl font-display font-bold text-white tracking-tight"
                                x-text="formatCurrency(results.total, true)"></span>
                            <button @click="copyToClipboard(results.total)" id="copy-total-btn"
                                class="p-2 hover:bg-brand-emerald/20 rounded-lg text-brand-emerald transition-colors no-print group relative"
                                title="Copy Total" type="button">
                                <svg class="w-5 h-5 group-active:scale-90 transition-transform" fill="currentColor"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M216,32H88a8,8,0,0,0-8,8V80H40a8,8,0,0,0-8,8V216a8,8,0,0,0,8,8H168a8,8,0,0,0,8-8V176h40a8,8,0,0,0,8-8V40A8,8,0,0,0,216,32Zm-56,176H48V96H160Zm48-48H176V88a8,8,0,0,0-8-8H96V48H208Z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                </section>

                <!-- Empty State -->
                <div x-show="subtotal <= 0" class="text-center py-8 text-slate-600 no-print">
                    <p>Masukkan nilai subtotal untuk melihat hasil perhitungan.</p>
                </div>
            </section>

            <footer class="mt-12 text-center text-xs text-slate-600 border-t border-white/5 pt-6">
                &copy; <?= date('Y') ?> <a href="https://github.com/mbahnizen" class="hover:text-slate-400 transition-colors">@mbahnizen</a>. All rights reserved.
            </footer>

        </div>
    </main>

    <!-- Confetti (optional delight) -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <!-- Alpine.js Logic — UI state only, calculation mirrors PHP for instant preview -->
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
                    total: 0,
                },

                /**
                 * Initialize from PHP server-rendered data (on POST redirect).
                 */
                initFromServer(phpData, rawInput) {
                    if (phpData) {
                        this.subtotal = parseFloat(phpData.subtotal);
                        this.formattedSubtotal = rawInput || new Intl.NumberFormat('id-ID').format(this.subtotal);
                        this.isMathExpression = rawInput.includes('+');
                        this.results = phpData;
                    }
                },

                /**
                 * Parse Indonesian number format to float.
                 * "1.000.000" → 1000000, "1.500,50" → 1500.50
                 */
                parseInput(str) {
                    if (!str) return 0;
                    let clean = str.trim();

                    // Heuristic: ".XX" at end → treat as decimal
                    clean = clean.replace(/\.(\d{1,2})$/, ',$1');

                    // Remove thousand separators (dots)
                    clean = clean.replace(/\./g, '');
                    // Convert decimal comma to dot
                    clean = clean.replace(',', '.');

                    return parseFloat(clean) || 0;
                },

                /**
                 * Live calculation on input — mirrors PHP logic for instant UX.
                 * PHP remains the source of truth on form submit.
                 */
                updateCalculation() {
                    // Sanitize: only allow digits, dots, commas, plus, spaces
                    this.formattedSubtotal = this.formattedSubtotal.replace(/[^0-9+\s.,]/g, '');

                    const rawInput = this.formattedSubtotal;

                    if (rawInput.includes('+')) {
                        this.isMathExpression = true;
                        let sum = 0;
                        rawInput.split('+').forEach(part => sum += this.parseInput(part));
                        this.subtotal = sum;
                    } else {
                        this.isMathExpression = false;
                        this.subtotal = this.parseInput(rawInput);

                        // Auto-format integers (avoid fighting cursor on decimals)
                        if (!rawInput.includes(',') && !rawInput.match(/\.\d{1,2}$/)) {
                            if (rawInput && !rawInput.endsWith('.')) {
                                this.formattedSubtotal = new Intl.NumberFormat('id-ID').format(this.subtotal);
                            }
                        }
                    }

                    // Mirror PHP calculation (deterministic, identical formula)
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
                        total: total,
                    };
                },

                /**
                 * Format number as Indonesian currency.
                 */
                formatCurrency(value, withSymbol = false) {
                    if (value === undefined || value === null) return '0';
                    const formatted = new Intl.NumberFormat('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2,
                    }).format(value);
                    return withSymbol ? `Rp ${formatted}` : formatted;
                },

                /**
                 * Copy value to clipboard with toast + confetti.
                 */
                async copyToClipboard(value) {
                    try {
                        const amount = Math.round(value);
                        await navigator.clipboard.writeText(amount);

                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: 'Total disalin: ' + this.formatCurrency(amount, true),
                        }));

                        if (typeof confetti === 'function') {
                            confetti({
                                particleCount: 100,
                                spread: 70,
                                origin: { y: 0.6 },
                                colors: ['#10b981', '#8b5cf6', '#ec4899'],
                            });
                        }
                    } catch (err) {
                        console.error('Failed to copy:', err);
                    }
                },

                /**
                 * Submit form via POST (no-JS fallback, also triggered by Alpine).
                 */
                submitForm() {
                    this.$refs?.form?.submit() || document.getElementById('calc-form').submit();
                },
            };
        }
    </script>
</body>

</html>

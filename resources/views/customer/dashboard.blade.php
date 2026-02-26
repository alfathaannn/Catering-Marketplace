@extends('layouts.customer')

@section('title', 'Catering Marketplace')

@push('styles')
<style>
    /* Google-style search container */
    .search-wrapper {
        min-height: 45vh;
        padding-bottom: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .brand-logo-text {
        font-size: 4rem;
        font-weight: 700;
        letter-spacing: -1.5px;
        margin-bottom: 30px;
        background: -webkit-linear-gradient(45deg, #4285F4);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        user-select: none;
    }

    .search-box-container {
        width: 100%;
        max-width: 600px;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 16px 24px 16px 52px;
        border-radius: 9999px;
        border: 2px solid #dfe1e5;
        font-size: 1rem;
        outline: none;
        box-shadow: none;
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .search-input:hover,
    .search-input:focus {
        background-color: #fff;
        box-shadow: 0 1px 6px rgba(32, 33, 36, .28);
        border-color: rgba(223, 225, 229, 0);
    }

    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa0a6;
        font-size: 20px;
    }

    /* Merchants Section */
    .merchants-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px 0;
        opacity: 0;
        transform: translateY(20px);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        padding: 0 12px;
    }

    .merchants-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        padding: 0 12px;
    }

    .merchant-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .merchant-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
    }

    .merchant-card-image {
        height: 140px;
        background: radial-gradient(circle at center, #f8fafc 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .merchant-card-content {
        padding: 20px;
    }

    .merchant-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0 0 8px 0;
    }

    .merchant-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #64748b;
        font-size: 0.875rem;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        backdrop-filter: blur(4px);
    }

    .modal-container {
        background: white;
        width: 100%;
        max-width: 1100px;
        height: 90vh;
        /* Fixed height for near full screen */
        margin: auto;
        /* Ensure it stays centered in the flex container */
        border-radius: 24px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
        padding: 20px 32px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background: #f8fafc;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .modal-close-btn {
        background: #e2e8f0;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .modal-close-btn:hover {
        background: #cbd5e1;
        color: #0f172a;
    }

    .modal-body {
        padding: 32px;
        flex-grow: 1;
        overflow-y: auto;
        background: #f8fafc;
    }

    /* Menus Grid inside Modal */
    .menus-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 24px;
    }

    .menu-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s;
    }

    .menu-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .menu-image {
        height: 180px;
        background-size: cover;
        background-position: center;
        background-color: #f1f5f9;
        position: relative;
    }

    .menu-image-placeholder {
        height: 180px;
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .menu-image-placeholder .material-symbols-rounded {
        font-size: 48px;
        opacity: 0.5;
    }

    .menu-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .menu-name {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
    }

    .menu-desc {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0 0 16px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }

    .menu-price {
        font-weight: 700;
        color: #1f4a9c;
        font-size: 1.25rem;
        margin-top: auto;
    }

    .no-menus-message {
        text-align: center;
        padding: 48px 24px;
        color: #64748b;
        font-size: 1.125rem;
        background: white;
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
    }

    @media (max-width: 768px) {
        .modal-overlay {
            padding: 12px;
        }

        .modal-container {
            height: 95vh;
            border-radius: 16px;
        }

        .modal-header {
            padding: 16px 20px;
        }

        .modal-body {
            padding: 20px;
        }

        .search-wrapper {
            min-height: 35vh;
        }
    }
</style>
@endpush

@section('content')
<div x-data="customerDashboard()">
    <div class="search-wrapper" id="search-wrapper">
        <div class="brand-logo-text" id="logo-text">
            Catering Marketplace
        </div>

        <div class="search-box-container" id="search-box">
            <span class="material-symbols-rounded search-icon">search</span>
            <input type="text" x-model="searchQuery" class="search-input" placeholder="Cari merchant catering..." autocomplete="off">
        </div>
    </div>

    <div class="merchants-section" id="merchants-section">
        <h2 class="section-title">Rekomendasi Merchant</h2>

        <div class="merchants-grid">
            @forelse($merchants as $merchant)
            <div class="merchant-card" x-show="matchesSearch('{{ addslashes($merchant->company_name) }}')" @click="openModal({{ $merchant->toJson() }})">
                <div class="merchant-card-image">
                    <span class="material-symbols-rounded" style="font-size: 48px; color: #94a3b8;">storefront</span>
                </div>
                <div class="merchant-card-content">
                    <h3 class="merchant-name">{{ $merchant->company_name }}</h3>
                    <div class="merchant-meta">
                        <span class="material-symbols-rounded">location_on</span>
                        <span>{{ Str::limit($merchant->address, 30) }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 48px; color: #64748b; background: white; border-radius: 16px; border: 1px dashed #cbd5e1;">
                <span class="material-symbols-rounded" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;">store_off</span>
                <p style="font-size: 1.125rem;">Belum ada merchant yang tersedia saat ini.</p>
            </div>
            @endforelse

            @if($merchants->count() > 0)
            <!-- Custom Empty State for Search -->
            <div x-cloak x-show="filteredMerchantsCount === 0" style="grid-column: 1 / -1; text-align: center; padding: 48px; color: #64748b; background: white; border-radius: 16px; border: 1px dashed #cbd5e1;">
                <span class="material-symbols-rounded" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;">search_off</span>
                <p style="font-size: 1.125rem;">Merchant tidak ditemukan untuk pencarian "<strong x-text="searchQuery"></strong>".</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Menus Modal (Alpine JS) -->
    <div x-show="isOpen" style="display: none;" class="modal-overlay" x-transition.opacity>
        <div class="modal-container" x-show="isOpen" @click.away="closeModal()" x-transition.scale.origin.bottom>
            <!-- Modal Header -->
            <div class="modal-header">
                <div style="display: flex; flex-direction: column;">
                    <h3 x-text="selectedMerchant ? selectedMerchant.company_name : ''" class="modal-title"></h3>
                    <span style="font-size: 0.875rem; color: #64748b;" x-text="selectedMerchant ? selectedMerchant.address : ''"></span>
                </div>
                <button @click="closeModal()" class="modal-close-btn">
                    <span class="material-symbols-rounded">close</span>
                </button>
            </div>

            <!-- Modal Content (Menus Grid) -->
            <div class="modal-body">
                <template x-if="selectedMerchant && selectedMerchant.menus && selectedMerchant.menus.length > 0">
                    <div class="menus-grid" style="padding-bottom: 80px;">
                        <template x-for="menu in selectedMerchant.menus" :key="menu.id">
                            <div class="menu-card">
                                <template x-if="menu.image">
                                    <div class="menu-image" :style="`background-image: url('${menu.image.startsWith('http') ? menu.image : '/storage/' + menu.image}')`"></div>
                                </template>
                                <template x-if="!menu.image">
                                    <div class="menu-image-placeholder">
                                        <span class="material-symbols-rounded">restaurant</span>
                                    </div>
                                </template>
                                <div class="menu-content">
                                    <h4 class="menu-name" x-text="menu.name"></h4>
                                    <p class="menu-desc" x-text="menu.description"></p>
                                    <div class="menu-price" style="margin-bottom: 16px;" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(menu.price)"></div>

                                    <!-- Quantity Selector -->
                                    <div style="display: flex; align-items: center; justify-content: space-between; background: #f1f5f9; border-radius: 8px; padding: 4px;">
                                        <button @click="updateQuantity(menu, -1)" style="border: none; background: white; width: 32px; height: 32px; border-radius: 6px; cursor: pointer; color: #475569; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                            <span class="material-symbols-rounded" style="font-size: 20px;">remove</span>
                                        </button>
                                        <span style="font-weight: 600; font-size: 1rem; color: #1e293b;" x-text="getQuantity(menu.id)"></span>
                                        <button @click="updateQuantity(menu, 1)" style="border: none; background: white; width: 32px; height: 32px; border-radius: 6px; cursor: pointer; color: #475569; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                            <span class="material-symbols-rounded" style="font-size: 20px;">add</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="selectedMerchant && (!selectedMerchant.menus || selectedMerchant.menus.length === 0)">
                    <div class="no-menus-message">
                        Merchant ini belum memiliki menu.
                    </div>
                </template>
            </div>

            <!-- Checkout Footer -->
            <template x-if="selectedMerchant && selectedMerchant.menus && selectedMerchant.menus.length > 0">
                <div style="padding: 24px 32px; border-top: 1px solid #e2e8f0; background: white; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; color: #64748b; margin-bottom: 4px; font-weight: 500;">Tanggal Pengiriman</label>
                            <input type="date" x-model="deliveryDate" :min="tomorrowDate()" style="border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px; font-size: 0.875rem; color: #1e293b; outline: none;">
                        </div>
                        <div x-show="errorMessage" x-text="errorMessage" style="color: #ef4444; font-size: 0.875rem;"></div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 24px;">
                        <div style="text-align: right;">
                            <div style="font-size: 0.875rem; color: #64748b;">Total Pembayaran</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: #1f4a9c;" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice)"></div>
                        </div>
                        <button
                            @click="submitOrder()"
                            :disabled="isSubmitting || totalPrice === 0 || !deliveryDate"
                            style="background: #1f4a9c; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background 0.2s; opacity: 1;"
                            :style="(isSubmitting || totalPrice === 0 || !deliveryDate) ? 'opacity: 0.5; cursor: not-allowed;' : ''">
                            <span x-show="!isSubmitting">Buat Pesanan</span>
                            <span x-show="isSubmitting" style="display: flex; align-items: center; gap: 8px;">
                                <span class="material-symbols-rounded" style="animation: spin 1s linear infinite;">progress_activity</span>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<style>
    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        // Animate elements in like Google opening
        gsap.fromTo("#logo-text", {
            y: 20,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: "power3.out"
        });

        gsap.fromTo("#search-box", {
            y: 20,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            delay: 0.1,
            ease: "power3.out"
        });

        gsap.fromTo("#search-actions", {
            y: 15,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            delay: 0.2,
            ease: "power3.out"
        });

        gsap.fromTo("#search-footer", {
            opacity: 0
        }, {
            opacity: 1,
            duration: 1,
            delay: 0.4
        });

        gsap.to(".merchants-section", {
            y: 0,
            opacity: 1,
            duration: 0.8,
            delay: 0.3,
            ease: "power3.out"
        });
    });
</script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('customerDashboard', () => ({
            searchQuery: '',
            merchantsList: @json($merchants -> map(fn($m) => ['company_name' => $m -> company_name])),
            isOpen: false,
            selectedMerchant: null,
            cart: {}, // Format: { menu_id: { quantity: 1, price: 50000 } }
            deliveryDate: '',
            isSubmitting: false,
            errorMessage: '',

            get filteredMerchantsCount() {
                if (this.searchQuery === '') return this.merchantsList.length;
                const query = this.searchQuery.toLowerCase();
                return this.merchantsList.filter(m => m.company_name.toLowerCase().includes(query)).length;
            },

            matchesSearch(name) {
                if (this.searchQuery === '') return true;
                return name.toLowerCase().includes(this.searchQuery.toLowerCase());
            },

            get totalPrice() {
                let total = 0;
                for (let key in this.cart) {
                    total += this.cart[key].price * this.cart[key].quantity;
                }
                return total;
            },

            tomorrowDate() {
                const today = new Date();
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                return tomorrow.toISOString().split('T')[0];
            },

            openModal(merchant) {
                this.selectedMerchant = merchant;
                // Reset states
                this.cart = {};
                this.deliveryDate = this.tomorrowDate();
                this.errorMessage = '';

                this.isOpen = true;
                document.body.style.overflow = 'hidden';
            },

            closeModal() {
                this.isOpen = false;
                setTimeout(() => {
                    this.selectedMerchant = null;
                }, 300);
                document.body.style.overflow = '';
            },

            getQuantity(menuId) {
                return this.cart[menuId] ? this.cart[menuId].quantity : 0;
            },

            updateQuantity(menu, change) {
                if (!this.cart[menu.id]) {
                    this.cart[menu.id] = {
                        quantity: 0,
                        price: menu.price
                    };
                }

                let newQuantity = this.cart[menu.id].quantity + change;

                if (newQuantity <= 0) {
                    delete this.cart[menu.id];
                } else {
                    this.cart[menu.id].quantity = newQuantity;
                }
            },

            async submitOrder() {
                if (this.totalPrice === 0) return;

                this.isSubmitting = true;
                this.errorMessage = '';

                // Format items for request
                const itemsRequest = Object.keys(this.cart).map(menuId => ({
                    menu_id: parseInt(menuId),
                    quantity: this.cart[menuId].quantity
                }));

                try {
                    const response = await fetch("{{ route('customer.checkout.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            merchant_id: this.selectedMerchant.id,
                            delivery_date: this.deliveryDate,
                            items: itemsRequest
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        this.errorMessage = data.message || 'Terjadi kesalahan saat memproses pesanan.';
                    }
                } catch (error) {
                    this.errorMessage = 'Gagal terhubung ke server. Silakan coba lagi.';
                } finally {
                    this.isSubmitting = false;
                }
            }
        }));
    });
</script>
@endpush
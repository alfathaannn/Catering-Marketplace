@extends('layouts.merchant')

@section('title', 'Menu Management | Catering Marketplace')

@push('styles')
<style>
    /* Flux UI Inspired Tailwind/Custom CSS */
    .menu-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .flux-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .flux-btn-primary {
        background-color: #0f172a;
        color: white;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .flux-btn-primary:hover {
        background-color: #1e293b;
    }

    .flux-btn-secondary {
        background-color: white;
        color: #334155;
        border-color: #e2e8f0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .flux-btn-secondary:hover {
        background-color: #f8fafc;
    }

    .flux-btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .flux-btn-danger:hover {
        background-color: #dc2626;
    }

    /* Toolbar */
    .flux-toolbar {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (min-width: 768px) {
        .flux-toolbar {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    /* Tabs */
    .flux-tabs {
        display: flex;
        gap: 8px;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 8px;
    }

    .flux-tab {
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s;
    }

    .flux-tab.active {
        background: white;
        color: #0f172a;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Search Input */
    .flux-search-wrapper {
        position: relative;
        width: 100%;
        max-width: 320px;
    }

    .flux-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 20px;
    }

    .flux-search-input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .flux-search-input:focus {
        border-color: #1f4a9c;
        box-shadow: 0 0 0 3px rgba(31, 74, 156, 0.1);
    }

    /* Table */
    .flux-table-container {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: white;
        overflow-x: auto;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .flux-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .flux-table th {
        padding: 12px 24px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        letter-spacing: 0.05em;
    }

    .flux-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .flux-table tr:last-child td {
        border-bottom: none;
    }

    .menu-image {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .action-group {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        padding: 6px;
        border-radius: 6px;
        color: #64748b;
        background: transparent;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
    }

    .action-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .action-btn.delete:hover {
        background: #fee2e2;
        color: #ef4444;
    }

    /* Status Badge */
    .flux-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 8px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-active {
        background: #dcfce7;
        color: #166534;
    }

    .badge-archived {
        background: #f1f5f9;
        color: #475569;
    }

    /* Modals (Alpine controlled) */
    .flux-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(4px);
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .flux-modal {
        background: white;
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .flux-modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .flux-modal-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #0f172a;
    }

    .flux-modal-close {
        color: #94a3b8;
        cursor: pointer;
        transition: color 0.2s;
    }

    .flux-modal-close:hover {
        color: #0f172a;
    }

    .flux-modal-body {
        padding: 24px;
    }

    .flux-modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    /* Form Inputs */
    .flux-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #334155;
        margin-bottom: 6px;
    }

    .flux-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        outline: none;
        transition: all 0.2s;
        margin-bottom: 16px;
    }

    .flux-input:focus {
        border-color: #1f4a9c;
        box-shadow: 0 0 0 3px rgba(31, 74, 156, 0.1);
    }

    textarea.flux-input {
        resize: vertical;
        min-height: 80px;
    }

    /* Toast Alert */
    .flux-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #0f172a;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 150;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .flux-toast.show {
        transform: translateY(0);
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div x-data="menuManager()">

    <!-- Toast Notification -->
    @if(session('success'))
    <div id="toastNotification" class="flux-toast">
        <span class="material-symbols-rounded" style="color: #4ade80;">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <div class="menu-page-header">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Menu Management</h1>
            <p style="color: #64748b; font-size: 0.875rem;">Create and manage your catering packages and items.</p>
        </div>
        <button @click="openCreateModal" class="flux-btn flux-btn-primary">
            <span class="material-symbols-rounded" style="font-size: 18px;">add</span>
            New Menu Item
        </button>
    </div>

    <!-- Toolbar -->
    <div class="flux-toolbar">
        <div class="flux-tabs">
            <a href="{{ route('merchant.menus.index', ['tab' => 'active', 'search' => request('search')]) }}" class="flux-tab {{ $tab == 'active' ? 'active' : '' }}">Active</a>
            <a href="{{ route('merchant.menus.index', ['tab' => 'archived', 'search' => request('search')]) }}" class="flux-tab {{ $tab == 'archived' ? 'active' : '' }}">Archived</a>
        </div>

        <form action="{{ route('merchant.menus.index') }}" method="GET" class="flux-search-wrapper">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <span class="material-symbols-rounded flux-search-icon">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search menus..." class="flux-search-input">
        </form>
    </div>

    <!-- Data Table -->
    <div class="flux-table-container">
        <table class="flux-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" class="menu-image" alt="{{ $menu->name }}">
                            @else
                            <div class="menu-image">
                                <span class="material-symbols-rounded">restaurant</span>
                            </div>
                            @endif
                            <div>
                                <div style="font-weight: 600; color: #0f172a; margin-bottom: 2px;">{{ $menu->name }}</div>
                                <div style="color: #64748b; font-size: 0.75rem; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $menu->description ?: 'No description provided.' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight: 500;">Rp {{ number_format($menu->price, 2) }}</td>
                    <td>
                        @if($menu->trashed())
                        <span class="flux-badge badge-archived">Archived</span>
                        @else
                        <span class="flux-badge badge-active">Active</span>
                        @endif
                    </td>
                    <td style="color: #64748b; font-size: 0.8125rem;">
                        {{ $menu->created_at->format('M d, Y') }}
                    </td>
                    <td style="text-align: right;">
                        <div class="action-group" style="justify-content: flex-end;">
                            @if(!$menu->trashed())
                            <button @click="openViewModal({{ $menu->toJson() }})" class="action-btn" title="View Details">
                                <span class="material-symbols-rounded" style="font-size: 18px;">visibility</span>
                            </button>
                            <button @click="openEditModal({{ $menu->toJson() }})" class="action-btn" title="Edit">
                                <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
                            </button>
                            <button @click="openArchiveModal({{ $menu->id }}, '{{ addslashes($menu->name) }}')" class="action-btn delete" title="Archive">
                                <span class="material-symbols-rounded" style="font-size: 18px;">inventory_2</span>
                            </button>
                            @else
                            <button @click="openViewModal({{ $menu->toJson() }})" class="action-btn" title="View Details">
                                <span class="material-symbols-rounded" style="font-size: 18px;">visibility</span>
                            </button>
                            <form action="{{ route('merchant.menus.restore', $menu->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="action-btn" title="Restore">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">restore</span>
                                </button>
                            </form>
                            <button @click="openHardDeleteModal({{ $menu->id }}, '{{ addslashes($menu->name) }}')" class="action-btn delete" title="Delete Permanently">
                                <span class="material-symbols-rounded" style="font-size: 18px;">delete_forever</span>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 48px 24px; color: #64748b;">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                <span class="material-symbols-rounded" style="font-size: 24px;">search_off</span>
                            </div>
                            <p>No menus found in this section.</p>
                            @if($tab == 'active')
                            <button @click="openCreateModal" class="flux-btn flux-btn-secondary flux-btn-sm" style="margin-top: 8px;">
                                Create one now
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 24px;">
        {{ $menus->links('pagination::tailwind') }}
    </div>

    <!-- MODALS (Alpine.js controlled) -->

    <!-- View Details Modal -->
    <div x-show="isViewModalOpen" x-cloak style="display: none;">
        <div class="flux-modal-backdrop" x-transition.opacity>
            <div class="flux-modal" @click.away="closeViewModal" x-transition.scale.origin.bottom>
                <div class="flux-modal-header">
                    <h3 class="flux-modal-title">Menu Details</h3>
                    <span class="material-symbols-rounded flux-modal-close" @click="closeViewModal">close</span>
                </div>
                <div class="flux-modal-body" style="padding: 0;">
                    <template x-if="viewData.image">
                        <div style="position: relative; cursor: pointer;" @click="openFullScreenImage(viewData.image)" title="Click to view full image">
                            <img :src="`/storage/${viewData.image}`" alt="Menu Image" style="width: 100%; height: 240px; object-fit: cover;">
                            <div style="position: absolute; bottom: 12px; right: 12px; background: rgba(15, 23, 42, 0.7); color: white; border-radius: 6px; padding: 4px 8px; display: flex; align-items: center; gap: 4px; font-size: 0.75rem;">
                                <span class="material-symbols-rounded" style="font-size: 14px;">zoom_in</span>
                                <span>Expand</span>
                            </div>
                        </div>
                    </template>
                    <template x-if="!viewData.image">
                        <div style="width: 100%; height: 160px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                            <span class="material-symbols-rounded" style="font-size: 48px;">restaurant</span>
                        </div>
                    </template>

                    <div style="padding: 24px;">
                        <h4 x-text="viewData.name" style="font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;"></h4>
                        <div style="display: inline-block; background: #f1f5f9; padding: 4px 12px; border-radius: 6px; font-weight: 600; color: #1e293b; margin-bottom: 16px;">
                            <span x-text="formatCurrency(viewData.price)"></span>
                        </div>

                        <div>
                            <span class="flux-label">Description</span>
                            <p x-text="viewData.description || 'No description provided.'" style="color: #475569; font-size: 0.95rem; line-height: 1.6;"></p>
                        </div>
                    </div>
                </div>
                <div class="flux-modal-footer">
                    <button type="button" @click="closeViewModal" class="flux-btn flux-btn-secondary">Close</button>
                    <template x-if="viewData.deleted_at === null">
                        <button type="button" @click="openEditModal(viewData); closeViewModal()" class="flux-btn flux-btn-primary">Edit Menu</button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div x-show="isModalOpen" x-cloak style="display: none;">
        <div class="flux-modal-backdrop" x-transition.opacity>
            <div class="flux-modal" @click.away="closeModal" x-transition.scale.origin.bottom>
                <div class="flux-modal-header">
                    <h3 class="flux-modal-title" x-text="isEditing ? 'Edit Menu Item' : 'Create Menu Item'"></h3>
                    <span class="material-symbols-rounded flux-modal-close" @click="closeModal">close</span>
                </div>

                <form :action="formAction" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div x-show="isEditing">
                        <input type="hidden" name="_method" value="PUT" :disabled="!isEditing">
                    </div>

                    <div class="flux-modal-body">
                        <div>
                            <label class="flux-label">Menu Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="name" x-model="formData.name" class="flux-input" required placeholder="e.g. Premium Wedding Package">
                        </div>

                        <div>
                            <label class="flux-label">Price (IDR) <span style="color: #ef4444;">*</span></label>
                            <input type="number" name="price" x-model="formData.price" class="flux-input" required min="0" step="0.01" placeholder="50000">
                        </div>

                        <div>
                            <label class="flux-label">Description</label>
                            <textarea name="description" x-model="formData.description" class="flux-input" placeholder="Describe the items included in this menu..."></textarea>
                        </div>

                        <div>
                            <label class="flux-label">Image Overview (Optional)</label>
                            <input type="file" name="image" class="flux-input" accept="image/*" style="padding: 8px;">
                        </div>
                    </div>

                    <div class="flux-modal-footer">
                        <button type="button" @click="closeModal" class="flux-btn flux-btn-secondary">Cancel</button>
                        <button type="submit" class="flux-btn flux-btn-primary" x-text="isEditing ? 'Save Changes' : 'Create Menu'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Archive Confirmation Modal -->
    <div x-show="isArchiveModalOpen" x-cloak style="display: none;">
        <div class="flux-modal-backdrop" x-transition.opacity>
            <div class="flux-modal" @click.away="closeArchiveModal" x-transition.scale.origin.bottom>
                <div class="flux-modal-header">
                    <h3 class="flux-modal-title">Archive Menu</h3>
                    <span class="material-symbols-rounded flux-modal-close" @click="closeArchiveModal">close</span>
                </div>
                <div class="flux-modal-body">
                    <p style="color: #475569; font-size: 0.95rem; line-height: 1.5;">
                        Are you sure you want to archive <strong><span x-text="actionMenuName"></span></strong>? <br><br>
                        It will not be visible to customers anymore, but you can restore it later from the Archives tab.
                    </p>
                </div>
                <div class="flux-modal-footer">
                    <button type="button" @click="closeArchiveModal" class="flux-btn flux-btn-secondary">Cancel</button>
                    <form :action="archiveActionUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flux-btn flux-btn-danger">Yes, Archive it</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hard Delete Confirmation Modal -->
    <div x-show="isHardDeleteModalOpen" x-cloak style="display: none;">
        <div class="flux-modal-backdrop" x-transition.opacity>
            <div class="flux-modal" @click.away="closeHardDeleteModal" x-transition.scale.origin.bottom>
                <div class="flux-modal-header">
                    <h3 class="flux-modal-title" style="color: #ef4444;">Delete Permanently</h3>
                    <span class="material-symbols-rounded flux-modal-close" @click="closeHardDeleteModal">close</span>
                </div>
                <div class="flux-modal-body">
                    <div style="padding: 16px; background: #fee2e2; border-radius: 8px; margin-bottom: 16px; display: flex; gap: 12px; color: #b91c1c;">
                        <span class="material-symbols-rounded">warning</span>
                        <p style="font-size: 0.875rem; font-weight: 500;">This action is irreversible.</p>
                    </div>
                    <p style="color: #475569; font-size: 0.95rem; line-height: 1.5;">
                        Are you sure you want to permanently delete <strong><span x-text="actionMenuName"></span></strong>? <br>
                        All associated data and images will be wiped unconditionally.
                    </p>
                </div>
                <div class="flux-modal-footer">
                    <button type="button" @click="closeHardDeleteModal" class="flux-btn flux-btn-secondary">Cancel</button>
                    <form :action="hardDeleteActionUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flux-btn flux-btn-danger">Permanently Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Screen Image Modal -->
    <div x-show="isFullScreenImageOpen" x-cloak style="display: none; position: fixed; inset: 0; z-index: 200;">
        <div class="flux-modal-backdrop" @click="closeFullScreenImage" style="background: rgba(0,0,0,0.85); backdrop-filter: blur(8px); padding: 24px;" x-transition.opacity>
            <button @click="closeFullScreenImage" style="position: absolute; top: 24px; right: 24px; color: white; background: rgba(255,255,255,0.1); border: none; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s;">
                <span class="material-symbols-rounded" style="font-size: 28px;">close</span>
            </button>
            <img :src="`/storage/${fullScreenImageUrl}`" style="max-width: 100%; max-height: 90vh; border-radius: 8px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);" @click.stop x-transition.scale>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Add Alpine.js for handling the modal UI logic -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('menuManager', () => ({
            isModalOpen: false,
            isViewModalOpen: false,
            isEditing: false,
            isArchiveModalOpen: false,
            isHardDeleteModalOpen: false,
            isFullScreenImageOpen: false,
            actionMenuName: '',
            archiveActionUrl: '',
            hardDeleteActionUrl: '',
            formAction: "{{ route('merchant.menus.store') }}",
            fullScreenImageUrl: '',

            formData: {
                id: null,
                name: '',
                price: '',
                description: ''
            },

            viewData: {
                id: null,
                name: '',
                price: '',
                description: '',
                image: '',
                deleted_at: null
            },

            formatCurrency(value) {
                if (!value) return 'Rp 0';
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(value);
            },

            openViewModal(menu) {
                this.viewData = menu;
                this.isViewModalOpen = true;
            },

            closeViewModal() {
                this.isViewModalOpen = false;
            },

            openFullScreenImage(imageUrl) {
                if (!imageUrl) return;
                this.fullScreenImageUrl = imageUrl;
                this.isFullScreenImageOpen = true;
            },

            closeFullScreenImage() {
                this.isFullScreenImageOpen = false;
            },

            openCreateModal() {
                this.isEditing = false;
                this.formAction = "{{ route('merchant.menus.store') }}";
                this.formData = {
                    id: null,
                    name: '',
                    price: '',
                    description: ''
                };
                this.isModalOpen = true;
            },

            openEditModal(menu) {
                this.isEditing = true;
                // Generate url correctly using Laravel standard conventions since we inject JS safely
                this.formAction = `/merchant/menus/${menu.id}`;
                this.formData = {
                    id: menu.id,
                    name: menu.name,
                    price: menu.price,
                    description: menu.description || ''
                };
                this.isModalOpen = true;
            },

            closeModal() {
                this.isModalOpen = false;
            },

            openArchiveModal(id, name) {
                this.actionMenuName = name;
                this.archiveActionUrl = `/merchant/menus/${id}`;
                this.isArchiveModalOpen = true;
            },

            closeArchiveModal() {
                this.isArchiveModalOpen = false;
            },

            openHardDeleteModal(id, name) {
                this.actionMenuName = name;
                this.hardDeleteActionUrl = `/merchant/menus/${id}/force`;
                this.isHardDeleteModalOpen = true;
            },

            closeHardDeleteModal() {
                this.isHardDeleteModalOpen = false;
            },

            init() {
                // Show toast animation on load if exists
                setTimeout(() => {
                    const toast = document.getElementById('toastNotification');
                    if (toast) {
                        toast.classList.add('show');
                        setTimeout(() => {
                            toast.classList.remove('show');
                        }, 3500);
                    }
                }, 100);
            }
        }))
    })
</script>
@endpush

@extends('layouts.merchant')

@section('title', 'Merchant Dashboard | CaterDash')

@section('topbar-search')
<!-- Search bar -->
<div class="search-container">
    <span class="material-symbols-rounded search-icon">search</span>
    <input type="text" class="search-input" placeholder="Search orders, customers, or items...">
</div>
@endsection

@section('content')
<!-- Header section -->
<div class="page-header gs-title">
    <div>
        <h1 class="page-title">Welcome back, {{ explode(' ', $user->name)[0] }} 👋</h1>
        <p class="page-desc">Here is the overview of your catering business today.</p>
    </div>
    <button class="btn-secondary">
        <span class="material-symbols-rounded">calendar_today</span>
        {{ now()->format('M d, Y') }}
        <span class="material-symbols-rounded" style="margin-left: 4px; font-size: 20px;">expand_more</span>
    </button>
</div>

<!-- Stats / Info Cards -->
<div class="stats-grid">
    <div class="stat-card gs-card">
        <div class="stat-header">
            <span class="stat-title">Total Revenue</span>
            <div class="stat-icon blue">
                <span class="material-symbols-rounded" style="font-size: 28px;">account_balance</span>
            </div>
        </div>
        <div class="stat-value">$0.00</div>
        <div class="stat-trend up" style="opacity: 0;">
            <span class="material-symbols-rounded" style="font-size: 16px;">trending_up</span>
            <span>0% vs last month</span>
        </div>
    </div>

    <div class="stat-card gs-card">
        <div class="stat-header">
            <span class="stat-title">Active Orders</span>
            <div class="stat-icon orange">
                <span class="material-symbols-rounded" style="font-size: 28px;">restaurant</span>
            </div>
        </div>
        <div class="stat-value">0</div>
        <div class="stat-trend up" style="opacity: 0;">
            <span class="material-symbols-rounded" style="font-size: 16px;">trending_up</span>
            <span>0% vs last month</span>
        </div>
    </div>

    <div class="stat-card gs-card">
        <div class="stat-header">
            <span class="stat-title">Total Customers</span>
            <div class="stat-icon green">
                <span class="material-symbols-rounded" style="font-size: 28px;">groups</span>
            </div>
        </div>
        <div class="stat-value">0</div>
        <div class="stat-trend up" style="opacity: 0;">
            <span class="material-symbols-rounded" style="font-size: 16px;">trending_up</span>
            <span>0% vs last month</span>
        </div>
    </div>

    <div class="stat-card gs-card">
        <div class="stat-header">
            <span class="stat-title">Canceled Orders</span>
            <div class="stat-icon purple">
                <span class="material-symbols-rounded" style="font-size: 28px;">event_busy</span>
            </div>
        </div>
        <div class="stat-value">0</div>
        <div class="stat-trend down" style="opacity: 0;">
            <span class="material-symbols-rounded" style="font-size: 16px;">trending_down</span>
            <span>0% vs last month</span>
        </div>
    </div>
</div>

<!-- Complex Data Table Section -->
<div class="card gs-table-wrapper">
    <div class="card-header">
        <div class="card-title">
            Recent Catering Orders
            <span class="badge-count">0 Total</span>
        </div>
        <div class="table-toolbar">
            <button class="btn-secondary">
                <span class="material-symbols-rounded" style="font-size: 20px;">filter_list</span>
                Filter
            </button>
            <button class="btn-secondary">
                <span class="material-symbols-rounded" style="font-size: 20px;">download</span>
                Export
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="data-table">
            <thead>
                <tr>
                    <th class="checkbox-cell"><input type="checkbox" class="custom-checkbox" id="selectAll"></th>
                    <th class="sortable">Order ID</th>
                    <th>Customer Details</th>
                    <th class="sortable">Event Date & Time</th>
                    <th>Package Type</th>
                    <th class="sortable">Amount</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Empty state for now since database has no orders -->
                <tr class="gs-row">
                    <td colspan="8" style="text-align: center; color: var(--stone-300); padding: 40px;">
                        No recent orders found.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination footer -->
    <div class="pagination-container gs-pagination">
        <div class="page-info">Showing <b>0</b> to <b>0</b> of <b>0</b> results</div>
        <div class="page-controls">
            <button class="btn-secondary" style="padding: 8px 12px; margin-right: 8px;" disabled>Previous</button>
            <button class="btn-secondary" style="padding: 8px 12px; margin-left: 8px;" disabled>Next</button>
        </div>
    </div>
</div>
@endsection
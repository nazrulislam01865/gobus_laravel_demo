@php
    $activeSection = $activeSection ?? 'revenue';
    $promotions = $promotions ?? collect();
    $busCompanies = $busCompanies ?? collect();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBUS | Admin Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/admin_dashboard.css') }}">
</head>
<body>

    <header>
        <div class="logo">
            Go<span id="logo">Bus</span>
        </div>

        <div class="header-right">
            <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                    onclick="return confirm('Do you want to log out?');"
                    style="border: none; cursor: pointer;"
                >
                    <img
                        src="{{ asset('picture/user_logo.png') }}"
                        alt="User Icon"
                        style="width: 18px; height: 18px; vertical-align: middle;"
                    >

                    {{ Auth::guard('admin')->user()->username ?? 'Admin' }}
                </button>
            </form>
        </div>
    </header>

    <nav class="sidebar">
        <ul>
            <li>
                <a
                    href="#revenue"
                    class="sidebar-link {{ $activeSection === 'revenue' ? 'active' : '' }}"
                    data-section="revenue"
                >
                    Revenue Tracking
                </a>
            </li>

            <li>
                <a
                    href="#discounts"
                    class="sidebar-link {{ $activeSection === 'discounts' ? 'active' : '' }}"
                    data-section="discounts"
                >
                    Discounts & Promotions
                </a>
            </li>

            <li>
                <a
                    href="#reports"
                    class="sidebar-link {{ $activeSection === 'reports' ? 'active' : '' }}"
                    data-section="reports"
                >
                    Report Generation
                </a>
            </li>

            <li>
                <a
                    href="#feedback"
                    class="sidebar-link {{ $activeSection === 'feedback' ? 'active' : '' }}"
                    data-section="feedback"
                >
                    Feedback Handling
                </a>
            </li>

            <li>
                <a
                    href="#bus_companies"
                    class="sidebar-link {{ $activeSection === 'bus_companies' ? 'active' : '' }}"
                    data-section="bus_companies"
                >
                    Bus Companies
                </a>
            </li>
        </ul>
    </nav>

    <main class="main-content">

        <section id="revenue" class="section" style="display: {{ $activeSection === 'revenue' ? 'block' : 'none' }};">
            <h2>Revenue Tracking per Route</h2>

            <table class="revenue-table">
                <thead>
                    <tr>
                        <th>Route</th>
                        <th>Revenue (BDT)</th>
                        <th>Tickets Sold</th>
                        <th>Average Price</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Dhaka - Rajshahi</td>
                        <td>25,000.00</td>
                        <td>50</td>
                        <td>500.00</td>
                    </tr>

                    <tr>
                        <td>Dhaka - Chittagong</td>
                        <td>42,000.00</td>
                        <td>70</td>
                        <td>600.00</td>
                    </tr>

                    <tr>
                        <td>Dhaka - Cox's Bazar</td>
                        <td>64,000.00</td>
                        <td>80</td>
                        <td>800.00</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="discounts" class="section" style="display: {{ $activeSection === 'discounts' ? 'block' : 'none' }};">
            <h2>Discounts & Promotions</h2>

            @if (session('promotion_success'))
                <div style="color: green; margin-bottom: 15px;">
                    {{ session('promotion_success') }}
                </div>
            @endif

            <form class="promotion-form" action="{{ route('admin.promotions.store') }}" method="POST">
                @csrf

                <label for="promo-code">Promo Code:</label>
                <input
                    type="text"
                    id="promo-code"
                    name="promo_code"
                    placeholder="Enter promo code"
                    maxlength="20"
                    value="{{ old('promo_code') }}"
                >

                @error('promo_code')
                    <span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                @enderror

                <label for="discount-type">Discount Type:</label>
                <select id="discount-type" name="discount_type">
                    <option value="Percentage" {{ old('discount_type') === 'Percentage' ? 'selected' : '' }}>
                        Percentage
                    </option>

                    <option value="Fixed Amount" {{ old('discount_type') === 'Fixed Amount' ? 'selected' : '' }}>
                        Fixed Amount
                    </option>
                </select>

                @error('discount_type')
                    <span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                @enderror

                <label for="discount-value">Value:</label>
                <input
                    type="number"
                    id="discount-value"
                    name="discount_value"
                    placeholder="Enter value"
                    min="0"
                    step="0.01"
                    value="{{ old('discount_value') }}"
                >

                @error('discount_value')
                    <span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                @enderror

                <label for="route">Applicable Route:</label>
                <input
                    type="text"
                    id="route"
                    name="route"
                    placeholder="Enter route"
                    value="{{ old('route') }}"
                >

                @error('route')
                    <span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                @enderror

                <button type="submit">
                    Add Promotion
                </button>
            </form>

            <div class="promotion-list">
                <h3>Current Promotions</h3>

                <ul>
                    @forelse ($promotions as $promotion)
                        <li>
                            Code: {{ $promotion->promo_code }} -

                            @if ($promotion->discount_type === 'Percentage')
                                {{ rtrim(rtrim(number_format($promotion->discount_value, 2), '0'), '.') }}% off
                            @else
                                ৳{{ number_format($promotion->discount_value, 2) }} off
                            @endif

                            on {{ $promotion->route }} routes

                            <form
                                action="{{ route('admin.promotions.destroy', $promotion) }}"
                                method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Do you want to delete this promotion?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    style="margin-left: 10px; color: red; background: transparent; border: none; cursor: pointer;"
                                >
                                    Delete
                                </button>
                            </form>
                        </li>
                    @empty
                        <li>No promotions available.</li>
                    @endforelse
                </ul>
            </div>
        </section>

        <section id="reports" class="section" style="display: {{ $activeSection === 'reports' ? 'block' : 'none' }};">
            <h2>Report Generation</h2>

            <form class="report-form frontend-only" action="#" method="POST">
                @csrf

                <label for="report-type">Report Type:</label>
                <select id="report-type" name="report_type">
                    <option value="Revenue Report">Revenue Report</option>
                    <option value="Sales Report">Sales Report</option>
                    <option value="User Feedback Report">User Feedback Report</option>
                </select>

                <label for="date-range">Date Range:</label>
                <select id="date-range" name="date_range" onchange="toggleCustomDates(this)">
                    <option value="Last 7 Days">Last 7 Days</option>
                    <option value="Last 30 Days">Last 30 Days</option>
                    <option value="Custom">Custom</option>
                </select>

                <div id="custom-dates" style="display: none;">
                    <label for="custom-start">Start Date:</label>
                    <input type="date" id="custom-start" name="custom_start">

                    <label for="custom-end">End Date:</label>
                    <input type="date" id="custom-end" name="custom_end">
                </div>

                <button type="submit">
                    Generate Report
                </button>
            </form>

            <div class="report-results">
                <h3>Sample Revenue Report</h3>

                <table class="revenue-table">
                    <thead>
                        <tr>
                            <th>Route</th>
                            <th>Total Revenue (BDT)</th>
                            <th>Total Tickets Sold</th>
                            <th>Average Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Dhaka - Rajshahi</td>
                            <td>25,000.00</td>
                            <td>50</td>
                            <td>500.00</td>
                        </tr>

                        <tr>
                            <td>Dhaka - Chittagong</td>
                            <td>42,000.00</td>
                            <td>70</td>
                            <td>600.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="feedback" class="section" style="display: {{ $activeSection === 'feedback' ? 'block' : 'none' }};">
            <h2>Feedback and Complaint Handling</h2>

            <div class="feedback-list">
                <div class="feedback-item">
                    <h4>
                        Complaint from User: Rahim
                        (Booking ID: GB1001, Route: Dhaka - Rajshahi, Status: Pending)
                    </h4>

                    <p>
                        <strong>Type:</strong>
                        Late Bus
                    </p>

                    <p>
                        <strong>Details:</strong>
                        The bus arrived 45 minutes late.
                    </p>

                    <p>
                        <strong>Date:</strong>
                        2025-01-15 10:30:00
                    </p>

                    <form class="frontend-only" action="#" method="POST">
                        @csrf

                        <label for="response-text-1">Response:</label>
                        <textarea
                            id="response-text-1"
                            name="response_text"
                            placeholder="Enter your response"
                            maxlength="500"
                        ></textarea>

                        <label for="complaint-status-1">Status:</label>
                        <select id="complaint-status-1" name="complaint_status">
                            <option value="Pending">Pending</option>
                            <option value="Resolved">Resolved</option>
                            <option value="Dismissed">Dismissed</option>
                        </select>

                        <button type="submit">
                            Submit Response
                        </button>
                    </form>
                </div>

                <div class="feedback-item">
                    <h4>
                        Feedback from User: Karim
                        (Booking ID: GB1002, Route: Dhaka - Chittagong)
                    </h4>

                    <p>
                        <strong>Rating:</strong>
                        5/5
                    </p>

                    <p>
                        <strong>Details:</strong>
                        Smooth booking experience and clean bus.
                    </p>

                    <p>
                        <strong>Date:</strong>
                        2025-01-16 14:20:00
                    </p>

                    <p>
                        <strong>Response:</strong>
                        Thank you for your feedback.
                        (2025-01-16 15:00:00)
                    </p>
                </div>
            </div>
        </section>

        <section id="bus_companies" class="section" style="display: {{ $activeSection === 'bus_companies' ? 'block' : 'none' }};">
            <h2>Manage Bus Companies</h2>

            @if (session('company_success'))
                <div style="color: green; margin-bottom: 15px;">
                    {{ session('company_success') }}
                </div>
            @endif

            <form class="promotion-form" action="{{ route('admin.bus-companies.store') }}" method="POST">
                @csrf

                <label for="company-name">Company Name:</label>
                <input
                    type="text"
                    id="company-name"
                    name="company_name"
                    placeholder="Enter company name"
                    maxlength="255"
                    value="{{ old('company_name') }}"
                >

                @error('company_name')
                    <span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                @enderror

                <label for="company-phone">Phone Number:</label>
                <input
                    type="text"
                    id="company-phone"
                    name="phone"
                    placeholder="Enter 11-digit phone number"
                    maxlength="11"
                    value="{{ old('phone') }}"
                >

                @error('phone')
                    <span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                @enderror

                <label for="company-password">Password:</label>
                <input
                    type="password"
                    id="company-password"
                    name="password"
                    placeholder="Enter password"
                >

                @error('password')
                    <span style="color: red; font-size: 0.85em;">{{ $message }}</span>
                @enderror

                <label for="confirm-password">Confirm Password:</label>
                <input
                    type="password"
                    id="confirm-password"
                    name="password_confirmation"
                    placeholder="Confirm password"
                >

                <button type="submit">
                    Add Bus Company
                </button>
            </form>

            <div class="promotion-list">
                <h3>Current Bus Companies</h3>

                <ul>
                    @forelse ($busCompanies as $company)
                        <li>
                            {{ $company->company_name }} - Phone: {{ $company->phone }}

                            <form
                                action="{{ route('admin.bus-companies.destroy', $company) }}"
                                method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Do you want to delete this bus company?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    style="margin-left: 10px; color: red; background: transparent; border: none; cursor: pointer;"
                                >
                                    Delete
                                </button>
                            </form>
                        </li>
                    @empty
                        <li>No bus companies available.</li>
                    @endforelse
                </ul>
            </div>
        </section>

    </main>

    <footer>
        <div class="footerContainer">
            <div class="footerSection">
                <h2>GO BUS</h2>

                <p>
                    gobus.com is a premium online booking portal which allows you to purchase ticket
                    for various bus booking services locally across the country.
                </p>
            </div>

            <div class="footerSection">
                <h3>Company Info</h3>
                <a href="{{ route('home') }}">Home</a>
                <a href="#">Terms and Condition</a>
                <a href="#">Privacy Policy</a>
            </div>

            <div class="footerSection">
                <h3>About GoBUS</h3>
                <a href="#">About Us</a>
                <a href="#">Contact Us</a>
            </div>
        </div>

        <div class="footerBottom">
            Copyright &copy;2025 | All Rights Reserved Designed by
            <span class="designer">Group 1</span>
        </div>
    </footer>

    <script>
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        const sections = document.querySelectorAll('.section');

        sidebarLinks.forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                const sectionId = this.getAttribute('data-section');

                sidebarLinks.forEach(function (item) {
                    item.classList.remove('active');
                });

                sections.forEach(function (section) {
                    section.style.display = 'none';
                });

                this.classList.add('active');

                document.getElementById(sectionId).style.display = 'block';
            });
        });

        function toggleCustomDates(select) {
            const customDates = document.getElementById('custom-dates');

            if (select.value === 'Custom') {
                customDates.style.display = 'block';
            } else {
                customDates.style.display = 'none';
            }
        }

        document.querySelectorAll('form.frontend-only').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                alert('Backend is not connected yet for this section.');
            });
        });
    </script>

</body>
</html>

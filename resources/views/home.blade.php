@php
    $promotions = $promotions ?? collect();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBus</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <style>
        .dashboard-btn {
            margin-left: 10px;
            padding: 8px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            background-color: #007bff;
            transition: background-color 0.3s;
        }

        .dashboard-btn:hover {
            background-color: #0056b3;
        }

        .promotions-banner {
            margin: 20px auto;
            max-width: 1650px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            white-space: nowrap;
            font-size: 16px;
        }

        .promotions-banner .scroll-container {
            display: flex;
            animation: scroll 20s linear infinite;
        }

        .promotions-banner .promotion-item {
            flex: 0 0 auto;
            margin-right: 30px;
            color: #333;
        }

        .promotions-banner .promotion-item span {
            color: #007bff;
            font-weight: bold;
        }

        .promotions-banner .no-promotions {
            color: #777;
            font-size: 16px;
            text-align: center;
            margin: 0;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            Go<span id="logo">Bus</span>
        </div>

        <div class="header-right">
            <a href="tel:+8801234567890" class="call-btn">
                Call +8801234567890
            </a>

            <a href="{{ route('admin.login') }}" class="login-btn">
                <img src="{{ asset('picture/user_logo.png') }}" alt="User Icon" style="width: 18px; height: 18px; vertical-align: middle;">
                Login
            </a>
        </div>
    </header>

    <img class="backgroundImage" src="{{ asset('picture/indexBackground.jpg') }}" alt="Background Image">

    <div class="promotions-banner">
        @if ($promotions->isEmpty())
            <p class="no-promotions" id="noPromotionsMessage">
                No promotions available at this time.
            </p>

            <div class="scroll-container" id="promotionsScroll" style="display: none;"></div>
        @else
            <p class="no-promotions" id="noPromotionsMessage" style="display: none;">
                No promotions available at this time.
            </p>

            <div class="scroll-container" id="promotionsScroll">
                @foreach ($promotions as $promotion)
                    <div class="promotion-item">
                        @if ($promotion->discount_type === 'Percentage')
                            {{ rtrim(rtrim(number_format($promotion->discount_value, 2), '0'), '.') }}% off
                        @else
                            ৳{{ number_format($promotion->discount_value, 2) }} off
                        @endif

                        on {{ $promotion->route }}. Use this promo code:
                        <span>{{ $promotion->promo_code }}</span>
                    </div>
                @endforeach

                @foreach ($promotions as $promotion)
                    <div class="promotion-item">
                        @if ($promotion->discount_type === 'Percentage')
                            {{ rtrim(rtrim(number_format($promotion->discount_value, 2), '0'), '.') }}% off
                        @else
                            ৳{{ number_format($promotion->discount_value, 2) }} off
                        @endif

                        on {{ $promotion->route }}. Use this promo code:
                        <span>{{ $promotion->promo_code }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="steps">
        <h2>
            <span class="highlight">Buy ticket</span> in 3 easy steps
        </h2>

        <div class="stepContainer">
            <div class="step">
                <div class="icon">
                    <img src="{{ asset('picture/search_logo.png') }}" alt="Search Icon" style="width: 25px; height: 25px; vertical-align: middle;">
                </div>

                <h3>Search</h3>

                <p>
                    Enter your starting point, destination, and travel date to explore available buses.
                </p>

                <div class="stepNumber">1</div>
            </div>

            <div class="step">
                <div class="icon">
                    <img src="{{ asset('picture/check.png') }}" alt="Check Icon" style="width: 25px; height: 25px; vertical-align: middle;">
                </div>

                <h3>Select</h3>

                <p>
                    Choose your preferred bus and pick your seats.
                </p>

                <div class="stepNumber">2</div>
            </div>

            <div class="step">
                <div class="icon">
                    <img src="{{ asset('picture/card.png') }}" alt="Card Icon" style="width: 25px; height: 24px; vertical-align: middle;">
                </div>

                <h3>Pay</h3>

                <p>
                    Complete your booking securely using cards, mobile banking or other payment options.
                </p>

                <div class="stepNumber">3</div>
            </div>
        </div>
    </div>

    <div class="search-box">
        <form action="#" method="GET">
            <div class="select-type">
                <label>
                    <input type="radio" name="travel_type" value="One Way" checked>
                    One Way
                </label>

                <label>
                    <input type="radio" name="travel_type" value="Round Way">
                    Round Way
                </label>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <select name="from" class="form-input">
                        <option value="">Going From</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Rajshahi">Rajshahi</option>
                        <option value="Barisal">Barisal</option>
                        <option value="Sylhet">Sylhet</option>
                        <option value="Khulna">Khulna</option>
                        <option value="Mymensingh">Mymensingh</option>
                        <option value="Bandarban">Bandarban</option>
                        <option value="Cox's Bazar">Cox's Bazar</option>
                        <option value="Chittagong">Chittagong</option>
                    </select>
                </div>

                <div class="input-group">
                    <select name="to" class="form-input">
                        <option value="">Going To</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Rajshahi">Rajshahi</option>
                        <option value="Barisal">Barisal</option>
                        <option value="Rangpur">Rangpur</option>
                        <option value="Sylhet">Sylhet</option>
                        <option value="Khulna">Khulna</option>
                        <option value="Mymensingh">Mymensingh</option>
                        <option value="Bandarban">Bandarban</option>
                        <option value="Cox's Bazar">Cox's Bazar</option>
                        <option value="Chittagong">Chittagong</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <input type="date" name="journey_date" min="{{ date('Y-m-d') }}">
                </div>

                <div class="input-group">
                    <input type="date" name="return_date" disabled>
                </div>
            </div>

            <div class="trending">
                <p><b>Trending Searches:</b></p>
                <span>Dhaka → Rajshahi</span>
                <span>Dhaka → Barisal</span>
                <span>Dhaka → Cox's Bazar</span>
                <span>Dhaka → Chittagong</span>
            </div>

            <button type="submit" class="search-btn">
                Search Bus
            </button>
        </form>
    </div>

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
                <h3>About GoBUS</h3>
                <a href="#">About Us</a>
                <a href="#">Contact Us</a>
                <a href="#">Cancel Ticket</a>
            </div>

            <div class="footerSection">
                <h3>Company Info</h3>
                <a href="#">Terms and Condition</a>
                <a href="#">Privacy Policy</a>
            </div>
        </div>

        <div class="footerBottom">
            Copyright &copy;2025 | All Rights Reserved Designed by
            <span class="designer">Group 1</span>
        </div>
    </footer>

    <script>
        document.querySelectorAll('input[name="travel_type"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                const returnDateInput = document.querySelector('input[name="return_date"]');
                const journeyDateInput = document.querySelector('input[name="journey_date"]');

                if (this.value === 'Round Way') {
                    returnDateInput.disabled = false;
                    returnDateInput.required = true;

                    if (journeyDateInput.value) {
                        returnDateInput.min = journeyDateInput.value;
                    }
                } else {
                    returnDateInput.disabled = true;
                    returnDateInput.required = false;
                    returnDateInput.removeAttribute('min');
                    returnDateInput.value = '';
                }
            });
        });

        document.querySelector('input[name="journey_date"]').addEventListener('change', function () {
            const returnDateInput = document.querySelector('input[name="return_date"]');
            const roundWayInput = document.querySelector('input[value="Round Way"]');

            if (roundWayInput.checked) {
                returnDateInput.min = this.value;
            }
        });

        function formatDiscount(promotion) {
            const value = Number(promotion.discount_value);

            if (promotion.discount_type === 'Percentage') {
                return `${Number.isInteger(value) ? value : value.toFixed(2)}% off`;
            }

            return `৳${value.toFixed(2)} off`;
        }

        function buildPromotionHtml(promotions) {
            let html = '';

            promotions.forEach(function (promotion) {
                html += `
                    <div class="promotion-item">
                        ${formatDiscount(promotion)}
                        on ${promotion.route}. Use this promo code:
                        <span>${promotion.promo_code}</span>
                    </div>
                `;
            });

            promotions.forEach(function (promotion) {
                html += `
                    <div class="promotion-item">
                        ${formatDiscount(promotion)}
                        on ${promotion.route}. Use this promo code:
                        <span>${promotion.promo_code}</span>
                    </div>
                `;
            });

            return html;
        }

        function loadLivePromotions() {
            fetch("{{ route('promotions.live') }}", {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                cache: 'no-store'
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (promotions) {
                    const scrollContainer = document.getElementById('promotionsScroll');
                    const noPromotionsMessage = document.getElementById('noPromotionsMessage');

                    if (!scrollContainer || !noPromotionsMessage) {
                        return;
                    }

                    if (promotions.length === 0) {
                        scrollContainer.innerHTML = '';
                        scrollContainer.style.display = 'none';
                        noPromotionsMessage.style.display = 'block';
                        return;
                    }

                    scrollContainer.innerHTML = buildPromotionHtml(promotions);
                    scrollContainer.style.display = 'flex';
                    noPromotionsMessage.style.display = 'none';
                })
                .catch(function () {
                    // Keep current banner if live update fails.
                });
        }

        setInterval(loadLivePromotions, 10000);
    </script>

</body>
</html>

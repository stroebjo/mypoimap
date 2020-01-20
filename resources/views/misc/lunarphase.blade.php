@php


/**
 * https://stackoverflow.com/a/15816087/723769
 *
 */


// calculate lunar phase (1900 - 2199)
$year = $date->format('Y');
$month = $date->format('n');
$day = $date->format('j');

if ($month < 4) {$year = $year - 1; $month = $month + 12;}
$days_y = 365.25 * $year;
$days_m = 30.42 * $month;
$julian = $days_y + $days_m + $day - 694039.09;
$julian = $julian / 29.53;
$phase = intval($julian);
$julian = $julian - $phase;
$phase = round($julian * 8 + 0.5);
if ($phase == 8) {$phase = 0;}

$moon_phase = [
    'new',
    'waxing_crescent',
    'first_quarter',
    'waxing_gibbous',
    'full',
    'waning_gibbous',
    'last_quarter',
    'waning_crescent'
];
$moon_phase_name = [
    __('New Moon'),
    __('Waxing crescent'),
    __('First Quarter'),
    __('Waxing gibbous'),
    __('Full Moon'),
    __('Waning gibbous'),
    __('Last Quarter'),
    __('Waning crescent'),
];
$moon_emoji = ['🌑', '🌒', '🌓', '🌔', '🌕', '🌖', '🌗', '🌘'];
@endphp

<span class="m-lunarphase m-lunarphase--{{ $moon_phase[$phase] }}" title="{{ $moon_phase_name[$phase] }}">
    {{ $moon_emoji[$phase] }}
</span>

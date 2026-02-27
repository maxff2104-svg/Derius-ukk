<?php

/**
 * Application helper functions required by the project.
 * These are loaded via Composer's autoload.files entry.
 */

if (! function_exists('generateIdPelaporan')) {
    /**
     * Generate a unique id_pelaporan in the format: ASP-YYYYMMDD-XXX
     * where XXX is a zero-padded incremental counter for that day.
     *
     * Note: this implementation uses the database to ensure uniqueness
     * and may be called from a service class when creating a new report.
     *
     * @return string
     */
    function generateIdPelaporan(): string
    {
        $date = date('Ymd');
        $prefix = "ASP-{$date}-";

        // count today's reports and increment (simple approach)
        $count = \App\Models\Aspirasi::whereDate('created_at', date('Y-m-d'))->count();
        $seq = str_pad((string) ($count + 1), 3, '0', STR_PAD_LEFT);

        return $prefix . $seq;
    }
}

if (! function_exists('formatTanggalIndonesia')) {
    /**
     * Format a date string to Indonesian human-readable format: 01 Januari 2023
     *
     * @param string|\DateTimeInterface|null $date
     * @return string
     */
    function formatTanggalIndonesia($date): string
    {
        if (! $date) {
            return '';
        }

        $ts = $date instanceof \DateTimeInterface ? $date->getTimestamp() : strtotime($date);
        if ($ts === false) {
            return (string) $date;
        }

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $d = (int) date('j', $ts);
        $m = (int) date('n', $ts);
        $y = date('Y', $ts);

        return sprintf('%02d %s %s', $d, $months[$m] ?? $m, $y);
    }
}

if (! function_exists('statusBadge')) {
    /**
     * Return an HTML badge for a given status using Bootstrap classes.
     *
     * @param string $status
     * @return string
     */
    function statusBadge(string $status): string
    {
        $colors = config('aspirasi.status_color', []);
        $color = $colors[$status] ?? 'secondary';

        return "<span class=\"badge bg-{$color}\">" . e($status) . "</span>";
    }
}

if (! function_exists('hitungPersentaseKategori')) {
    /**
     * Calculate percentage distribution from associative data [label => count].
     *
     * @param array $data
     * @return array [label => percentage]
     */
    function hitungPersentaseKategori(array $data): array
    {
        $total = array_sum($data);
        if ($total <= 0) {
            return array_map(fn($_) => 0, $data);
        }

        $result = [];
        foreach ($data as $k => $v) {
            $result[$k] = round(($v / $total) * 100, 2);
        }

        return $result;
    }
}

if (! function_exists('isValidNIS')) {
    /**
     * Basic validation for NIS format.
     * Adjust the regex to match your school's NIS rules.
     *
     * @param string $nis
     * @return bool
     */
    function isValidNIS(string $nis): bool
    {
        return (bool) preg_match('/^[0-9A-Za-z\-]{4,20}$/', $nis);
    }
}

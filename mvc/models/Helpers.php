<?php
namespace Site\Models;

use DateTime;

class Helpers
{
    public static function capitalizeWords(string $input): string
    {
        return ucwords(strtolower($input));
    }

    public static function formatToFloat($number, int $decimals = 2): float
    {
        // Sanitize input: remove commas, convert string to numeric
        if (is_string($number)) {
            $number = preg_replace('/[^0-9.\-]/', '', $number);
        }

        // Convert to float
        $number = (float) $number;

        // Round and format to specified decimals
        $rounded = round($number, $decimals);
        $formatted = number_format($rounded, $decimals, '.', '');

        return (float) $formatted;
    }

    public static function getWeekMonday(string $date = null): string 
    {
        //$date must be in format '2025-07-18'
        $dt = $date ? new DateTime($date) : new DateTime();
        $dt->modify('Monday this week');
        return $dt->format('Y-m-d');
    }


    public static function getDateListForYear(int $year = null): array 
    {
        $year = $year ?? (int)date('Y');
        $dates = [];
        $date = new DateTime("$year-01-01");

        while ((int)$date->format('Y') === $year) {
            $dates[] = $date->format('Y-m-d');
            $date->modify('+1 day');
        }

        return $dates;
    }

    public static function getDatesUntilEndOfYear(): array 
    {
        $today = (new DateTime())->format('Y-m-d');
        $allDates = self::getDateListForYear();
        $result = [];

        foreach ($allDates as $index => $date) {
            if ($date >= $today) {
                $result[] = [
                    'day' => $date,
                    'dayValue' => $index
                ];
            }
        }

        return $result;
    }

    public static function getDaysDifference(
        DateTime $date1, 
        DateTime $date2
    ): int
    {
        // Normalize both dates to ignore time
        $date1 = DateTime::createFromFormat(
            'Y-m-d', 
            $date1->format('Y-m-d')
        );
        $date2 = DateTime::createFromFormat(
            'Y-m-d', 
            $date2->format('Y-m-d')
        );

        return (int) $date1->diff($date2)->format('%r%a');
    }

    public static function getDelta(
        int|float $actual, 
        int|float $est
    ): int|float
    {
        return $actual - $est;
    }

    public static function getDeltaRatio(
        float|int $hours_act, 
        float|int $hours_est
    ): float 
    {
        if ($hours_est == 0) {
            return 0.0;
        }

        return round((($hours_act - $hours_est) / $hours_est) * 100, 2);
    }

    public static function getMonths(): array
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $date = DateTime::createFromFormat('!m', $i);
            $months[] = [
                'text' => $date->format('F'),
                'value' => str_pad((string)$i, 2, '0', STR_PAD_LEFT)
            ];
        }

        return $months;
    }

    public static function isEven(int $number): bool 
    {
        return $number % 2 === 0;
    }

    public static function isOverDue(
        DateTime $due_date, 
        DateTime $actual_date
    ): bool
    {
        $due = $due_date->format('Y-m-d');
        $actual = $actual_date->format('Y-m-d');

        return $due >= $actual;
    }

    public static function positiveDelta(
        int|float $actual, 
        int|float $est
    ): bool
    {
        $delta = self::getDelta($actual, $est);
        return $delta > 0;
    }

    public static function processString(?string $input): string
    {
        if ($input === null) {
            return '';
        }
        return self::capitalizeWords(
            rtrim($input)
        );
    }

    public static function queryQuotes(string $string): string
    {
        return "'" . $string  . "'";
    }

    
}

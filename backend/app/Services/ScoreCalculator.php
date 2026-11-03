<?php

namespace App\Services;

/**
 * Score calculator — no database, no AI, no HTTP.
 *
 * Deliberately pure (numbers in, numbers out): the scoring rules change most
 * often and are tested most often, so they must be testable without Postgres.
 *
 * Locked formula (the one used by the Kemendagri IID system, verified against
 * the "Genting" report 73.71-229597-2025: 111.00 = 37 x 3):
 *
 *     indicator score = bobot x bintang
 *     total           = sum(all indicator scores)
 *     maximum         = sum(bobot) x 3
 */
class ScoreCalculator
{
    /** Score for a single indicator. Bobot 1..4, bintang 1..3. */
    public function skorIndikator(int $bobot, int $bintang): float
    {
        return (float) ($bobot * $bintang);
    }

    /**
     * Total score across a list of decisions.
     *
     * @param  array<int, array{bobot:int, bintang:int}>  $keputusan
     */
    public function total(array $keputusan): float
    {
        $total = 0.0;
        foreach ($keputusan as $baris) {
            $total += $this->skorIndikator($baris['bobot'], $baris['bintang']);
        }

        return $total;
    }

    /**
     * Theoretical maximum, e.g. 19 indicators x weight 33 x 3 = 99
     * (or 20 full indicators x 37 x 3 = 111 when video is counted).
     *
     * @param  array<int, int>  $daftarBobot
     */
    public function maksimum(array $daftarBobot): float
    {
        return (float) (array_sum($daftarBobot) * 3);
    }
}

<?php

namespace App\Services;

use App\Models\Indicator;

/**
 * LLM adapter — PLACEHOLDER.
 *
 * The real implementation (OpenAI-style /chat/completions call, retry, rubric
 * prompt) was backed up by the team before this module was agreed on. It is
 * intentionally not wired in yet: the analysis pipeline writes honest
 * placeholders instead, so no number is invented.
 *
 * To activate later: restore the client, keep aktif() gated on
 * LLM_ENABLED, and call it from JalankanAnalisisAi after the OCR stage.
 * The prompt must carry the indicator's own tier rubric — see
 * Indicator::tiers().
 */
class LlmClient
{
    /** The module is off until the team agrees on prompt and rubric. */
    public function aktif(): bool
    {
        return false;
    }

    /**
     * @return array{usulan_bintang:int|null, keyakinan:float|null, ringkasan:string, model:string|null}
     */
    public function nilaiKesesuaian(Indicator $indicator, string $teksBukti): array
    {
        return [
            'usulan_bintang' => null,
            'keyakinan' => null,
            'ringkasan' => 'Modul AI belum aktif — verifikator menilai manual.',
            'model' => 'belum-aktif',
        ];
    }
}

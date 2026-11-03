<?php

namespace Tests\Feature;

use App\Models\Indicator;
use App\Models\IndicatorTier;
use App\Models\Submission;
use App\Models\SubmissionParameter;
use App\Models\User;
use Database\Seeders\MasterSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SubmitKelengkapanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([UserSeeder::class, MasterSeeder::class]);
    }

    public function test_submit_tidak_n_plus_1(): void
    {
        $inovator = User::where('role', 'inovator')->firstOrFail();

        $submission = Submission::create([
            'user_id' => $inovator->id,
            'judul' => 'Uji N+1',
            'opd' => 'Dinas Uji',
            'kategori' => 'layanan',
            'tahun' => 2026,
            'status' => Submission::STATUS_DRAFT,
        ]);

        // Claim 12 indicators, none with evidence: the old code ran one
        // Indicator::find() per parameter inside the loop.
        $indikators = Indicator::where('dalam_scope', true)->take(12)->get();
        foreach ($indikators as $ind) {
            SubmissionParameter::create([
                'submission_id' => $submission->id,
                'indicator_id' => $ind->id,
                'tier_id' => IndicatorTier::where('indicator_id', $ind->id)->value('id'),
                'bintang_diklaim' => 2,
            ]);
        }

        $queries = 0;
        DB::listen(function () use (&$queries) {
            $queries++;
        });

        $response = $this->actingAs($inovator, 'sanctum')
            ->postJson("/api/submissions/{$submission->id}/submit");

        $response->assertStatus(422);

        // 12 parameters produce 12 "tanpa_bukti" messages.
        $kurang = collect($response->json('kurang'));
        $this->assertSame(12, $kurang->where('jenis', 'tanpa_bukti')->count());

        // Guard: the eager-loaded indicator must not add one query per row.
        // Before the fix this was 12 extra queries, so the ceiling catches a
        // regression back to Indicator::find() in the loop.
        $this->assertLessThan(25, $queries, "Terlalu banyak query ({$queries}) — kemungkinan N+1 kembali.");
    }
}

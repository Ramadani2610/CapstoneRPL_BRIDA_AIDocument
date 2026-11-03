<?php

namespace Tests\Feature;

use App\Models\Evidence;
use App\Models\Indicator;
use App\Models\IndicatorTier;
use App\Models\Submission;
use App\Models\SubmissionParameter;
use App\Models\User;
use Database\Seeders\MasterSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EvidenceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([UserSeeder::class, MasterSeeder::class]);
        Storage::fake('local');
    }

    private function pengajuan(User $inovator, array $kodeDiklaim): Submission
    {
        $submission = Submission::create([
            'user_id' => $inovator->id,
            'judul' => 'Uji Bukti',
            'opd' => 'Dinas Uji',
            'kategori' => 'layanan',
            'tahun' => 2026,
            'status' => Submission::STATUS_DRAFT,
        ]);

        foreach ($kodeDiklaim as $kode) {
            $indikator = Indicator::where('kode', $kode)->firstOrFail();
            SubmissionParameter::create([
                'submission_id' => $submission->id,
                'indicator_id' => $indikator->id,
                'tier_id' => IndicatorTier::where('indicator_id', $indikator->id)->value('id'),
                'bintang_diklaim' => 2,
            ]);
        }

        return $submission;
    }

    public function test_upload_bukti_berhasil(): void
    {
        $inovator = User::where('email', 'inovator@brida.test')->firstOrFail();
        $submission = $this->pengajuan($inovator, [21]);
        $indikator = Indicator::where('kode', 21)->firstOrFail();

        $response = $this->actingAs($inovator, 'sanctum')
            ->postJson("/api/submissions/{$submission->id}/evidences", [
                'indicator_kode' => 21,
                'tahun_dokumen' => 2026,
                'file' => UploadedFile::fake()->create('bukti.pdf', 120, 'application/pdf'),
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseCount('evidences', 1);
        $this->assertDatabaseHas('evidences', ['submission_id' => $submission->id, 'indicator_id' => $indikator->id]);
    }

    public function test_upload_tanpa_tier_ditolak(): void
    {
        $inovator = User::where('email', 'inovator@brida.test')->firstOrFail();
        $submission = $this->pengajuan($inovator, []);

        $this->actingAs($inovator, 'sanctum')
            ->postJson("/api/submissions/{$submission->id}/evidences", [
                'indicator_kode' => 21,
                'file' => UploadedFile::fake()->create('bukti.pdf', 120, 'application/pdf'),
            ])->assertStatus(422)
            ->assertJsonPath('message', 'Pilih tingkat untuk indikator #21 dulu sebelum mengunggah berkas.');

        $this->assertDatabaseCount('evidences', 0);
    }

    public function test_upload_pengajuan_orang_lain_404(): void
    {
        $inovator = User::where('email', 'inovator@brida.test')->firstOrFail();
        $pemilik = User::where('email', 'verifikator@brida.test')->firstOrFail();
        $submission = $this->pengajuan($pemilik, [21]);

        $this->actingAs($inovator, 'sanctum')
            ->postJson("/api/submissions/{$submission->id}/evidences", [
                'indicator_kode' => 21,
                'file' => UploadedFile::fake()->create('bukti.pdf', 120, 'application/pdf'),
            ])->assertStatus(404);

        $this->assertDatabaseCount('evidences', 0);
    }

    public function test_upload_setelah_diajukan_409(): void
    {
        $inovator = User::where('email', 'inovator@brida.test')->firstOrFail();
        $submission = $this->pengajuan($inovator, [21]);
        $submission->update(['status' => Submission::STATUS_DIAJUKAN]);

        $this->actingAs($inovator, 'sanctum')
            ->postJson("/api/submissions/{$submission->id}/evidences", [
                'indicator_kode' => 21,
                'file' => UploadedFile::fake()->create('bukti.pdf', 120, 'application/pdf'),
            ])->assertStatus(409);
    }

    public function test_hapus_bukti_mengembalikan_slot(): void
    {
        $inovator = User::where('email', 'inovator@brida.test')->firstOrFail();
        $submission = $this->pengajuan($inovator, [21]);

        $evidence = Evidence::create([
            'submission_id' => $submission->id,
            'indicator_id' => Indicator::where('kode', 21)->firstOrFail()->id,
            'nama_asli' => 'bukti.pdf',
            'path' => 'evidences/'.$submission->id.'/bukti.pdf',
            'tipe_file' => 'pdf',
            'mime' => 'application/pdf',
            'ukuran' => 1024,
        ]);

        $this->actingAs($inovator, 'sanctum')
            ->deleteJson("/api/evidences/{$evidence->id}")
            ->assertStatus(204);

        $this->assertDatabaseCount('evidences', 0);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Polling;
use Illuminate\Support\Facades\Storage;

class GeneratePollingResult extends Command
{
    protected $signature = 'polling:generate-result';
    protected $description = 'Generate hasil polling ke file CSV jika sudah melewati batas waktu';

    public function handle()
    {
        $pollings = Polling::with('options.votes')
            ->whereNotNull('batas_waktu')
            ->where('batas_waktu', '<=', now())
            ->get();

        foreach ($pollings as $polling) {
            $filename = 'polling/hasil_polling_' . $polling->id . '.csv';

            // Jika file sudah ada, skip
            if (Storage::disk('public')->exists($filename)) {
                continue;
            }

            // Simpan ke storage/app/public/polling/
            Storage::disk('public')->put($filename, $this->generateCSV($polling));

            $this->info("Polling ID {$polling->id} disimpan sebagai $filename");
        }

        return 0;
    }

    private function generateCSV($polling)
    {
        $output = fopen('php://temp', 'r+');
        fputcsv($output, ['Opsi', 'Jumlah Suara']);

        foreach ($polling->options as $option) {
            fputcsv($output, [$option->option_text, $option->votes->count()]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }
}

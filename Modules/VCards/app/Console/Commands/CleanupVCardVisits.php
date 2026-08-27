<?php

namespace Modules\VCards\Console\Commands;

use Illuminate\Console\Command;
use Modules\VCards\Models\VCard;
use Modules\VCards\Services\VCardVisitService;

class CleanupVCardVisits extends Command
{
    protected $signature = 'vcards:cleanup-visits {--days=365 : Eliminar visitas más antiguas que este número de días}';
    protected $description = 'Limpia visitas antiguas de vCards según la configuración de retención';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $this->info("Limpiando visitas de vCards más antiguas de {$days} días...");

        $service = new VCardVisitService();
        $totalDeleted = 0;

        $vcards = VCard::where('track_visits', true)->get();

        foreach ($vcards as $vcard) {
            $retentionDays = $vcard->retention_days ?? $days;
            $deleted = $service->cleanupOldVisits($retentionDays);
            if ($deleted > 0) {
                $this->line("  - {$vcard->name}: {$deleted} visitas eliminadas");
                $totalDeleted += $deleted;
            }
        }

        $this->info("Total de visitas eliminadas: {$totalDeleted}");

        return Command::SUCCESS;
    }
}

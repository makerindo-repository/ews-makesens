<?php

namespace App\Console\Commands;

use App\Models\RawData;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class SubscribeMqtt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscriber MQTT data sensor TMA.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mqtt = MQTT::connection();

        $mqtt->subscribe('gps/tracker/pub', function (string $topic, string $message){
            try {
                $data = json_decode($message, true);

                if (isset($data['data'])) {
                    RawData::create([
                        'battery_level' => $data['data']['batteryLevel'] ?? 0,
                        'latitude'      => $data['data']['Latitude'] ?? 0,
                        'longitude'     => $data['data']['Longitude'] ?? 0,
                        'distance'      => $data['data']['Distance'] ?? 0,
                        'status'        => $data['data']['Status'] ?? '-',
                    ]);
                }
                $this->info("Berhasil simpan data ke DB!");
            } catch (\Exception $e) {
                $this->error("Gagal simpan data: " . $e->getMessage());
            }
        });

        $mqtt->loop();
    }
}

<?php

namespace App\Console\Commands;
use App\Notifications\DailyProductExpire as ProductExpireNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\User;

class DailyProductExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'productexpire:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification daily about products expiration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query ="SELECT s.nombre, 
                        s.unidad_medida,
                        id.created_at, 
                        id.fecha_expiracion, 
                        id.cantidad,
                        DATEDIFF(id.fecha_expiracion, now()) expira_en
                FROM supplies s
                    LEFT JOIN inventories i on s.id = i.supply_id  AND i.deleted_at is null
                    LEFT JOIN inventory_details id on i.id = id.inventory_id  AND id.deleted_at is null
                WHERE s.deleted_at is null 
                    AND id.cantidad > 0 
                    AND  DATEDIFF(id.fecha_expiracion, now()) BETWEEN 0 AND 5";
        
        $data = DB::select($query);
        //auth()->user()->notify(new ProductExpireNotification($product));
        User::all()->each(function(User $user) use ($data){
            foreach ($data as $product) {
                $user->notify(new ProductExpireNotification($product));
            }
        });
        $this->info('Notificacion enviada correctamente');
    }
}

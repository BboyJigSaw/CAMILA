<?php

namespace App\Console\Commands;
use App\Notifications\DailyProductQuantity as ProductQuantityNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\User;

class DailyProductQuantity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'productquantity:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification daily about products quantity';

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
                        MAX(id.fecha_expiracion) fecha_expiracion, 
                        i.cantidad_existencia, 
                        i.cantidad_notificacion
                FROM supplies s
                    LEFT JOIN inventories i on s.id = i.supply_id AND i.deleted_at is null
                    LEFT JOIN inventory_details id on i.id = id.inventory_id AND id.deleted_at is null
                WHERE s.deleted_at is null AND i.cantidad_existencia = i.cantidad_notificacion OR i.cantidad_existencia < i.cantidad_notificacion
                GROUP BY s.nombre,  i.cantidad_existencia,s.unidad_medida, i.cantidad_notificacion";
        
        $data = DB::select($query);
        //auth()->user()->notify(new ProductExpireNotification($product));
        User::all()->each(function(User $user) use ($data){
            foreach ($data as $product) {
                $user->notify(new ProductQuantityNotification($product));
            }
        });
        $this->info('Notificacion enviada correctamente');
    }
}

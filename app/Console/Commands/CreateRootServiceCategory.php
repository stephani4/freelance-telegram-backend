<?php

namespace App\Console\Commands;

use App\Http\Services\Telegram\CategoryService;
use Illuminate\Console\Command;

class CreateRootServiceCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-root-service-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CategoryService $service)
    {
        $service->createRoot([
            'name' => 'Главная страница',
            'slug' => 'root'
        ]);
    }
}

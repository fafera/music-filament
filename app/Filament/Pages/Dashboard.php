<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Panel;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getColumns(): int | string | array
    {
        return 1;
    }
}

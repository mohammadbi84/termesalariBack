<?php

namespace App\Console\Commands;

use App\Amazing;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ApplyAmazingDiscounts extends Command
{
    protected $signature = 'amazing:apply';

    protected $description = 'Apply active amazing discounts to products';
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
     * @return mixed
     */
    public function handle()
    {
        Log::info('opperation started');
        $now = Carbon::now();

        $passed_amazings = Amazing::where('active', true)
            ->where('is_passed', false)
            ->where('end_date', '<=', $now)
            ->get();

        $amazings = Amazing::where('active', true)
            ->where('is_passed', false)
            ->where('is_applied', false)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->get();

        foreach ($passed_amazings as $amazing) {
            $prices = $amazing->productable->prices()->where('local', 'تومان')->first();
            if ($prices) {
                if ($prices->offPrice > 0) {
                    if ($prices->offType == 'مبلغ') {
                        $price = $prices->price * $amazing->discount / 100;
                        $off = $prices->offPrice - $price;
                    } else {
                        $off = $prices->offPrice - $amazing->discount;
                    }
                    $prices->offPrice = max(0, $off);
                    $prices->save();
                    $amazing->is_passed = 1;
                    $amazing->save();
                }
            }
            $amazing->is_passed = 1;
            $amazing->save();
        }
        foreach ($amazings as $amazing) {
            $prices = $amazing->productable->prices()->where('local', 'تومان')->first();
            if ($prices) {
                if ($prices->offPrice > 0) {
                    if ($prices->offType == 'مبلغ') {
                        $price = $prices->price * $amazing->discount / 100;
                        $off = $prices->offPrice + $price;
                    } else {
                        $off = $prices->offPrice + $amazing->discount;
                    }
                    $prices->offPrice = $off;
                    $prices->save();
                    $amazing->is_applied = 1;
                    $amazing->save();
                } else {
                    $prices->offType = 'درصد';
                    $prices->offPrice = $amazing->discount;
                    $prices->save();
                    $amazing->is_applied = 1;
                    $amazing->save();
                }
            }
        }

        Log::info('opperation ended');

        $this->info('Amazing discounts applied successfully.');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Client\Models\Client;
use App\Models\User;
use Modules\Finance\Models\Expense;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = DB::table('clients')->first();
        $creator = DB::table('users')->first();

        if (!$client || !$creator) {
            $this->command->error('Perlu minimal satu client dan user di database.');
            return;
        }

        // Buat 25 Pemasukan (Invoice)
        for ($i = 1; $i <= 25; $i++) {
            $total = rand(1000000, 25000000);
            $profit = $total * 0.11;
            $daysAgo = rand(1, 300);
            
            DB::table('invoices')->insert([
                'invoice_number' => 'INV-2026-DUMMY-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'client_id' => $client->id,
                'created_by' => $creator->id,
                'title' => 'Layanan Dummy ' . $i,
                'status' => 'paid',
                'invoice_date' => Carbon::now()->subDays($daysAgo)->format('Y-m-d'),
                'due_date' => Carbon::now()->format('Y-m-d'),
                'total' => $total,
                'pt_profit_percent' => 11,
                'pt_profit_amount' => $profit,
                'user_amount' => $total - $profit,
                'qr_token' => \Illuminate\Support\Str::random(32),
                'created_at' => Carbon::now()->subDays($daysAgo),
                'updated_at' => Carbon::now()->subDays($daysAgo)
            ]);
        }

        // Buat 40 Pengeluaran (Expense)
        $categories = ['Operasional', 'Peralatan', 'Pemasaran', 'Gaji', 'Lainnya'];
        for ($i = 1; $i <= 40; $i++) {
            $daysAgo = rand(1, 300);
            $hasTax = rand(0, 1) == 1;
            
            Expense::create([
                'expense_date' => Carbon::now()->subDays($daysAgo)->format('Y-m-d'),
                'category' => $categories[array_rand($categories)],
                'title' => 'Pengeluaran Dummy (Otomatis) ' . $i,
                'amount' => rand(50000, 3000000),
                'has_tax' => $hasTax,
                'tax_amount' => $hasTax ? rand(5000, 300000) : 0,
                'notes' => 'Generated automatically for testing'
            ]);
        }

        $this->command->info('Berhasil membuat 25 Pemasukan (Invoice) dan 40 Pengeluaran (Expense)');
    }
}

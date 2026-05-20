<?php
$users = \App\Models\User::where('role', '!=', 'director')->get();
$output = "| Nama / Jabatan | Email | Password Sementara |\n";
$output .= "|---|---|---|\n";

foreach ($users as $u) {
    $pass = \Illuminate\Support\Str::random(8);
    $u->update([
        'password' => \Illuminate\Support\Facades\Hash::make($pass),
        'must_change_password' => true
    ]);
    $output .= "| **{$u->name}**<br><small>{$u->position}</small> | `{$u->email}` | `{$pass}` |\n";
}

echo "\n" . $output . "\n";

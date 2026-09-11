<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PpdbRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('no_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->placeholder('Otomatis dibuat saat disimpan')
                    ->disabled(),
                Select::make('jenjang')
                    ->label('Tingkat / Jenjang')
                    ->options([
                        'sd' => '🎒 SD (Sekolah Dasar)',
                        'smp' => '📚 SMP (Menengah Pertama)',
                        'smk' => '💻 SMK (Kejuruan)',
                    ])
                    ->default('sd')
                    ->required(),
                TextInput::make('major_choice')
                    ->label('Pilihan Jurusan (Khusus SMK)')
                    ->placeholder('Contoh: Rekayasa Perangkat Lunak (RPL)'),
                TextInput::make('full_name')->label('Nama Lengkap')->required(),
                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                DatePicker::make('birth_date')->label('Tanggal Lahir'),
                Textarea::make('address')->label('Alamat')->columnSpanFull(),
                TextInput::make('parent_name')->label('Nama Orang Tua/Wali'),
                TextInput::make('parent_phone')->label('No. HP Orang Tua/Wali'),
                Select::make('status')
                    ->label('Status Pendaftaran')
                    ->options([
                        'pending' => 'Pending',
                        'diverifikasi' => 'Diverifikasi',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('pending')
                    ->required(),
                Textarea::make('notes')->label('Catatan')->columnSpanFull(),
            ]);
    }
}

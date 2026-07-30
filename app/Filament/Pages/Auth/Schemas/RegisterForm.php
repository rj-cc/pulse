<?php

namespace App\Filament\Pages\Auth\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class RegisterForm
{
    public static function configure(
        Schema $schema,
        string $userModel,
        Component $emailComponent,
        Component $passwordComponent,
        Component $passwordConfirmationComponent,
    ): Schema {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Personal')
                        ->icon(Heroicon::User)
                        ->completedIcon(Heroicon::HandThumbUp)
                        ->schema([
                            Fieldset::make('Name & Demographics')
                                ->schema([
                                    TextInput::make('first_name')
                                        ->label('First name')
                                        ->validationAttribute('first name')
                                        ->required()
                                        ->maxLength(100)
                                        ->autofocus(),
                                    TextInput::make('last_name')
                                        ->label('Last name')
                                        ->validationAttribute('last name')
                                        ->required()
                                        ->maxLength(100),
                                    TextInput::make('middle_name')
                                        ->label('Middle name')
                                        ->validationAttribute('middle name')
                                        ->maxLength(100),
                                    Select::make('prefix')
                                        ->label('Prefix')
                                        ->validationAttribute('prefix')
                                        ->native(false)
                                        ->options([
                                            'Mr.' => 'Mr.',
                                            'Ms.' => 'Ms.',
                                            'Mrs.' => 'Mrs.',
                                            'Dr.' => 'Dr.',
                                            'Atty.' => 'Atty.',
                                            'Engr.' => 'Engr.',
                                            'Arch.' => 'Arch.',
                                        ])
                                        ->searchable(),
                                    Select::make('suffix')
                                        ->label('Suffix')
                                        ->validationAttribute('suffix')
                                        ->native(false)
                                        ->options([
                                            'Jr.' => 'Jr.',
                                            'Sr.' => 'Sr.',
                                            'I' => 'I',
                                            'II' => 'II',
                                            'III' => 'III',
                                            'IV' => 'IV',
                                            'V' => 'V',
                                            'VI' => 'VI',
                                        ])
                                        ->searchable(),
                                    Radio::make('sex')
                                        ->label('Sex')
                                        ->validationAttribute('sex')
                                        ->inline()
                                        ->options([
                                            'male' => 'Male',
                                            'female' => 'Female',
                                        ]),
                                ])
                                ->columns(['default' => 1, 'sm' => 2])
                                ->columnSpanFull(),
                        ]),
                    Step::make('Work')
                        ->icon(Heroicon::BuildingOffice)
                        ->completedIcon(Heroicon::HandThumbUp)
                        ->schema([
                            Fieldset::make('Employment')
                                ->schema([
                                    TextInput::make('employee_id')
                                        ->label('Employee ID')
                                        ->validationAttribute('employee id')
                                        ->maxLength(50)
                                        ->unique($userModel)
                                        ->nullable(),
                                    DatePicker::make('date_hired')
                                        ->label('Date hired')
                                        ->validationAttribute('date hired'),
                                ])
                                ->columns(['default' => 1, 'sm' => 2])
                                ->columnSpanFull(),
                            Fieldset::make('Assignment')
                                ->schema([
                                    TextInput::make('department')
                                        ->label('Department')
                                        ->validationAttribute('department')
                                        ->maxLength(100),
                                    TextInput::make('division')
                                        ->label('Division')
                                        ->validationAttribute('division')
                                        ->maxLength(100),
                                    TextInput::make('position')
                                        ->label('Position')
                                        ->validationAttribute('position')
                                        ->maxLength(100)
                                        ->columnSpanFull(),
                                ])
                                ->columns(['default' => 1, 'sm' => 2])
                                ->columnSpanFull(),
                        ]),
                    Step::make('Account')
                        ->icon(Heroicon::Key)
                        ->completedIcon(Heroicon::HandThumbUp)
                        ->schema([
                            Grid::make()
                                ->columns(3)
                                ->schema([
                                    Fieldset::make('Login credentials')
                                        ->schema([
                                            $emailComponent,
                                            TextInput::make('username')
                                                ->label('Username')
                                                ->validationAttribute('username')
                                                ->required()
                                                ->maxLength(20)
                                                ->unique($userModel)
                                                ->autocomplete('username'),
                                            $passwordComponent,
                                            $passwordConfirmationComponent,
                                        ])
                                        ->columns(2)
                                        ->columnSpan(2),
                                    FileUpload::make('avatar')
                                        ->label('Avatar')
                                        ->validationAttribute('avatar')
                                        ->image()
                                        ->disk('public')
                                        ->directory('avatars')
                                        ->avatar()
                                        ->nullable()
                                        ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/webp']),
                                ]),
                        ]),
                    Step::make('Consent')
                        ->icon(Heroicon::DocumentText)
                        ->schema([
                            Section::make('Data Privacy Agreement')
                                ->description('Please review and consent to the following terms. By accessing and using this application, you acknowledge and consent to the following:')
                                ->compact()
                                ->schema([
                                    Text::make(new HtmlString(
                                        '<ul class="list-disc space-y-2 ps-5 text-sm text-gray-600 dark:text-gray-400">'
                                        .'<li><strong>Data Collection:</strong> We collect personal data strictly for official personnel management.</li>'
                                        .'<li><strong>Compliance:</strong> All data handling is in compliance with the Data Privacy Act of 2012 (RA 10173).</li>'
                                        .'<li><strong>Security:</strong> You are responsible for maintaining the confidentiality of your credentials. Sharing of accounts is strictly prohibited.</li>'
                                        .'<li><strong>Usage:</strong> The system must be used solely for official business. All activities are logged for auditing purposes.</li>'
                                        .'</ul>'
                                    )),
                                ]),
                            Checkbox::make('privacy_consent')
                                ->label('I have read and consent to the Data Privacy Agreement')
                                ->validationAttribute('privacy consent')
                                ->required()
                                ->accepted()
                                ->dehydrated(false)
                                ->columnSpanFull(),
                        ]),
                ])
                    ->submitAction(new HtmlString(Blade::render(<<<'BLADE'
                        <x-filament::button
                            type="submit"
                            size="md"
                            wire:submit="register"
                        >
                            Register
                        </x-filament::button>
                        BLADE))),
            ]);
    }
}

<?php

namespace App\Filament\Pages\Auth;

use Caresome\FilamentAuthDesigner\Pages\Auth\Register as BaseRegister;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use SensitiveParameter;
use Filament\Notifications\Notification;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Personal')
                        ->description('Your personal details')
                        ->schema([
                            Grid::make()
                                ->columns(['default' => 1, 'sm' => 2])
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
                                    Select::make('sex')
                                        ->label('Sex')
                                        ->validationAttribute('sex')
                                        ->native(false)
                                        ->options([
                                            'male' => 'Male',
                                            'female' => 'Female',
                                        ]),
                                    TextInput::make('prefix')
                                        ->label('Prefix')
                                        ->validationAttribute('prefix')
                                        ->maxLength(10),
                                    TextInput::make('suffix')
                                        ->label('Suffix')
                                        ->validationAttribute('suffix')
                                        ->maxLength(10),
                                ]),
                        ]),
                    Step::make('Work')
                        ->description('Your work information')
                        ->schema([
                            Grid::make()
                                ->columns(['default' => 1, 'sm' => 2])
                                ->schema([
                                    TextInput::make('employee_id')
                                        ->label('Employee ID')
                                        ->validationAttribute('employee id')
                                        ->maxLength(255)
                                        ->unique($this->getUserModel())
                                        ->nullable(),
                                    DatePicker::make('date_hired')
                                        ->label('Date hired')
                                        ->validationAttribute('date hired'),
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
                                ]),
                        ]),
                    Step::make('Account')
                        ->description('Create your login credentials')
                        ->schema([
                            Grid::make()
                                ->columns(3)
                                ->schema([
                                    FileUpload::make('avatar')
                                        ->label('Avatar')
                                        ->validationAttribute('avatar')
                                        ->image()
                                        ->disk('public')
                                        ->directory('avatars')
                                        ->avatar()
                                        ->nullable()
                                        ->columnSpan(1)
                                        ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/webp']),

                                    Grid::make()
                                        ->columns(2)
                                        ->columnSpan(2)
                                        ->schema([
                                            $this->getEmailFormComponent(),
                                            TextInput::make('username')
                                                ->label('Username')
                                                ->validationAttribute('username')
                                                ->required()
                                                ->maxLength(20)
                                                ->unique($this->getUserModel())
                                                ->autocomplete('username'),

                                            $this->getPasswordFormComponent(),
                                            $this->getPasswordConfirmationFormComponent(),
                                        ]),
                                ]),
                        ]),
                    Step::make('Consent')
                        ->description('Data Privacy Agreement')
                        ->schema([
                            Section::make('Data Privacy Agreement')
                                ->description('Please review and consent to the following terms. By accessing and using this application, you acknowledge and consent to the following:')
                                ->compact()
                                ->schema([
                                    Text::make(new HtmlString(
                                        '<ul class="list-disc space-y-2 ps-5 text-sm text-gray-600 dark:text-gray-400">'
                                        . '<li><strong>Data Collection:</strong> We collect personal data strictly for official personnel management.</li>'
                                        . '<li><strong>Compliance:</strong> All data handling is in compliance with the Data Privacy Act of 2012 (RA 10173).</li>'
                                        . '<li><strong>Security:</strong> You are responsible for maintaining the confidentiality of your credentials. Sharing of accounts is strictly prohibited.</li>'
                                        . '<li><strong>Usage:</strong> The system must be used solely for official business. All activities are logged for auditing purposes.</li>'
                                        . '</ul>'
                                    )),
                                ]),
                            Checkbox::make('privacy_consent')
                                ->label('I have read and consent to the Data Privacy Agreement')
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

    /**
     * @return array<\Filament\Actions\Action | \Filament\Actions\ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeRegister(#[SensitiveParameter] array $data): array
    {
        unset($data['privacy_consent']);

        $data['name'] = trim(
            ($data['prefix'] ?? '') . ' ' .
            ($data['first_name'] ?? '') . ' ' .
            (!empty($data['middle_name']) ? mb_substr(trim($data['middle_name']), 0, 1) . '.' : '') . ' ' .
            ($data['last_name'] ?? '') . ' ' .
            ($data['suffix'] ?? '')
        );
        $data['is_active'] = true;
        $data['privacy_consented_at'] = now();

        return $data;
    }

    public function register(): ?RegistrationResponse
    {
        $response = parent::register();

        if ($response) {
            Notification::make()
                ->title('Registration successful')
                ->body('Your account has been created successfully.')
                ->success()
                ->send();
        }

        return $response;
    }
}

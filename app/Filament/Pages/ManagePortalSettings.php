<?php

namespace App\Filament\Pages;

use App\Enums\PortalColorPalette;
use App\Enums\PortalFontStyle;
use App\Models\PortalSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class ManagePortalSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Portal';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    protected ?string $subheading = 'Manage the appearance and content of your portal';

    protected string $view = 'filament.pages.manage-portal-settings';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getRecord()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Tabs::make('Settings')
                        ->tabs([
                            Tab::make('Branding')
                                ->schema([
                                    Section::make('Appearance')
                                        ->description('Color palette and typography used across the portal.')
                                        ->schema([
                                            Select::make('color_palette')
                                                ->label('Color palette')
                                                ->options(PortalColorPalette::class)
                                                ->required()
                                                ->native(false),
                                            Select::make('font_style')
                                                ->label('Font style')
                                                ->options(PortalFontStyle::class)
                                                ->required()
                                                ->native(false),
                                        ])
                                        ->compact()
                                        ->columns(2)
                                        ->columnSpanFull(),
                                    Section::make('Organization')
                                        ->description('Name, tagline, and logo shown in the portal header.')
                                        ->schema([
                                            TextInput::make('organization_name')
                                                ->label('Organization name')
                                                ->required()
                                                ->maxLength(255),
                                            TextInput::make('organization_tagline')
                                                ->label('Tagline')
                                                ->maxLength(255),
                                            FileUpload::make('logo_path')
                                                ->label('Logo')
                                                ->image()
                                                ->disk('public')
                                                ->directory('portal/logos')
                                                ->visibility('public')
                                                ->imagePreviewHeight('120')
                                                ->columnSpanFull(),
                                        ])
                                        ->compact()
                                        ->columns(2)
                                        ->columnSpanFull(),
                                ]),
                            Tab::make('Header')
                                ->schema([
                                    Section::make('Top bar')
                                        ->description('Contact details and label shown in the portal top bar.')
                                        ->schema([
                                            TextInput::make('topbar_phone')
                                                ->label('Phone')
                                                ->maxLength(255),
                                            TextInput::make('topbar_email')
                                                ->label('Email')
                                                ->email()
                                                ->maxLength(255),
                                            TextInput::make('topbar_right_label')
                                                ->label('Header text right')
                                                ->maxLength(255),
                                        ])
                                        ->compact()
                                        ->columns(3)
                                        ->columnSpanFull(),
                                    Section::make('Hero')
                                        ->description('Subtitle and motto shown in the portal hero area.')
                                        ->schema([
                                            Textarea::make('hero_subtitle')
                                                ->label('Subtitle')
                                                ->rows(3)
                                                ->columnSpanFull(),
                                            TextInput::make('hero_motto')
                                                ->label('Motto')
                                                ->maxLength(255)
                                                ->columnSpanFull(),
                                        ])
                                        ->compact()
                                        ->columnSpanFull(),
                                ]),
                            Tab::make('Footer')
                                ->schema([
                                    Fieldset::make('Footer text')
                                        ->schema([
                                            TextInput::make('footer_motto')
                                                ->label('Footer title')
                                                ->maxLength(255),
                                            TextInput::make('footer_copyright')
                                                ->label('Copyright')
                                                ->maxLength(255),
                                            TextInput::make('footer_right_label')
                                                ->label('Footer text right')
                                                ->maxLength(255),
                                        ])
                                        ->columns(3)
                                        ->columnSpanFull(),
                                    Fieldset::make('Footer links')
                                        ->schema([
                                            Repeater::make('footer_links')
                                                ->label('Footer links')
                                                ->table([
                                                    TableColumn::make('Label'),
                                                    TableColumn::make('URL'),
                                                ])
                                                ->schema([
                                                    TextInput::make('label')
                                                        ->required()
                                                        ->maxLength(255),
                                                    TextInput::make('url')
                                                        ->required()
                                                        ->maxLength(255),
                                                ])
                                                ->compact()
                                                ->default([])
                                                ->columnSpanFull(),
                                        ])
                                        ->columnSpanFull(),
                                ]),
                        ])
                        ->columnSpanFull(),
                ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save settings')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->record($this->getRecord())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $record = $this->getRecord();
        $record->fill($data);
        $record->updated_by = Auth::id();
        $record->save();

        Notification::make()
            ->success()
            ->title('Settings saved')
            ->body('You can now view the changes on the portal.')
            ->actions([
                Action::make('View portal')
                    ->url(route('portal.index'))
                    ->label('View portal')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('primary')
                    ->openUrlInNewTab(),
            ])
            ->send();
    }

    public function getRecord(): PortalSetting
    {
        return PortalSetting::current();
    }
}

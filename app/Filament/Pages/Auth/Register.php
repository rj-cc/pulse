<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Pages\Auth\Schemas\RegisterForm;
use Caresome\FilamentAuthDesigner\Pages\Auth\Register as BaseRegister;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use SensitiveParameter;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return RegisterForm::configure(
            $schema,
            userModel: $this->getUserModel(),
            emailComponent: $this->getEmailFormComponent(),
            passwordComponent: $this->getPasswordFormComponent(),
            passwordConfirmationComponent: $this->getPasswordConfirmationFormComponent(),
        );
    }

    /**
     * @return array<Action | ActionGroup>
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
            ($data['prefix'] ?? '').' '.
            ($data['first_name'] ?? '').' '.
            (! empty($data['middle_name']) ? mb_substr(trim($data['middle_name']), 0, 1).'.' : '').' '.
            ($data['last_name'] ?? '').' '.
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

<?php

namespace App\Filament\User\Pages;

use App\Enums\Branch;
use App\Models\User;
use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Enums\UserPosition;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.edit-profile';

    protected static ?string $slug = 'profile';

    protected static ?string $title = 'โปรไฟล์';


    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    public function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (! $user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }

        return $user;
    }

    protected function fillForm(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->callHook('beforeFill');

        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    public function save(): void
    {
        try {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeSave($data);

            $this->callHook('beforeSave');

            $this->handleRecordUpdate($this->getUser(), $data);

            $this->callHook('afterSave');
        } catch (Halt $exception) {
            return;
        }

        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put([
                'password_hash_'.Filament::getAuthGuard() => $data['password'],
            ]);
        }

        $this->data['password'] = null;
        $this->data['passwordConfirmation'] = null;

        $this->getSavedNotification()?->send();

        if ($redirectUrl = $this->getRedirectUrl()) {
            $this->redirect($redirectUrl);
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }

    protected function getSavedNotification(): ?Notification
    {
        $title = $this->getSavedNotificationTitle();

        if (blank($title)) {
            return null;
        }

        return Notification::make()
            ->success()
            ->title($this->getSavedNotificationTitle());
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('filament-panels::pages/auth/edit-profile.notifications.saved.title');
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Forms\Components\Section::make('ข้อมูลโปรไฟล์')
                            ->aside()
                            ->description('อัปเดตข้อมูลโปรไฟล์และที่อยู่อีเมลบัญชีของคุณ')
                            ->schema([
                                Forms\Components\Group::make([
                                    Forms\Components\TextInput::make('name')
                                        ->label('ชื่อ-สกุล')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('phone')
                                        ->label('เบอร์โทรศัพท์')
                                        ->hint('ไม่ต้องใส่ขีดกลาง (-)')
                                        ->regex('/^0\d{8,9}$/')
                                        ->validationAttribute('เบอร์โทรศัพท์')
                                        ->required(),
                                    Forms\Components\Placeholder::make('email')
                                        ->label('อีเมล')
                                        ->content(fn (): string => $this->data['email'] ?? '-'),
                                    Forms\Components\Select::make('position')
                                        ->label('สถานะผู้ใช้')
                                        ->lazy()
                                        ->options([
                                            'student' => 'นักศึกษา',
                                            'lecturer' => 'อาจารย์',
                                            'personnel' => 'บุคคลากร',
                                            'officer' => 'เจ้าหน้าที่',
                                        ]),
                                    Forms\Components\Select::make('branch')
                                        ->label('สาขา')
                                        ->required()
                                        ->options(Branch::class)
                                        ->hidden(function(Forms\Get $get){
                                            if($get('position') != 'student'){
                                                return true;
                                            }
                                        }),
                                ])
                                    ->columnSpan(2),
                            ])
                            ->columns(3),
                        Forms\Components\Section::make('แก้ไขรหัสผ่าน')
                            ->aside()
                            ->description('ตรวจสอบให้แน่ใจว่าบัญชีของคุณใช้รหัสผ่านที่มีความปลอดภัย')
                            ->schema([
                                Forms\Components\Group::make([
                                    Forms\Components\TextInput::make('password')
                                        ->label('รหัสผ่านใหม่')
                                        ->password()
                                        ->rule(Password::default())
                                        ->autocomplete('new-password')
                                        ->dehydrated(fn ($state): bool => filled($state))
                                        ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                                        ->live(debounce: 500)
                                        ->same('passwordConfirmation'),
                                    Forms\Components\TextInput::make('passwordConfirmation')
                                        ->label('ยืนยันรหัสผ่าน')
                                        ->password()
                                        ->required(fn (Get $get): bool => filled($get('password')))
                                        ->dehydrated(false),
                                ])
                                    ->columnSpan(2),
                            ])
                            ->columns(3),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data'),
            ),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    public function getCancelFormAction(): Action
    {
        return Action::make('back')
            ->label(__('filament-panels::pages/auth/edit-profile.actions.cancel.label'))
            ->url(filament()->getUrl())
            ->color('gray');
    }

}


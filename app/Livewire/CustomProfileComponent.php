<?php

namespace App\Livewire;

use Filament\Forms;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Carbon;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasSort;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasUser;

class CustomProfileComponent extends Component implements HasForms
{
    use InteractsWithForms;
    use HasSort;
    use HasUser;

    public ?array $data = [];

    public ?array $customFields = [];
    protected static int $sort = 0;


    public function mount(): void
    {
        $this->user = $this->getUser();

        $data = $this->user->attributesToArray();

        $this->customFields = config('filament-edit-profile.custom_fields');

        $this->form->fill($data['custom_fields'] ?? []);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Section::make('Clone information')
                    ->aside()
                    ->description('Update your clone information. If you want to change your clone URL, you can do it here. ')
                    ->columns(12)
                    ->schema([

                        Components\DatePicker::make('expires_at')
                            ->label('User expiration')
                            ->required()
                            ->closeOnDateSelection()
                            ->placeholder('Select expiration')
                            ->displayFormat('l, j M, Y')
                            ->format('Y-m-d H:i:s')
                            //->helperText(fn () => $this->user->expired ? 'Your user is expired.' : 'Your user is active.')
                            //->maxDate(now())
                            ->minDate(now())
                            ->native(false)
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 4,
                            ])
                            ->readonly(fn () => $this->user->admin),
                        Components\TextInput::make('clone_url')
                            ->label('Clone URL')
                            ->required()
                            ->placeholder('https://...')
                            ->columnSpan([
                                'sm' => 12,
                                'md' => 8,
                            ]),

                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            if(isset($data['expires_at']))
                $data['expires_at'] = Carbon::parse($data['expires_at'])->endOfDay()->format('Y-m-d H:i:s');

            $data['custom_fields'] = $data ?? [];
            $customFields['custom_fields'] = $data['custom_fields'];
            $this->user->update($customFields);
            Notification::make()
                ->success()
                ->title(__('filament-edit-profile::default.saved_successfully'))
                ->send();
        } catch (Halt $exception) {
            return;
        }


    }

    public function render(): View
    {
        return view('livewire.custom-profile-component');
    }
}

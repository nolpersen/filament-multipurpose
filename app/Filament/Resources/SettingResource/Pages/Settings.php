<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use App\Utilities\Constant;
use BladeUI\Icons\Components\Icon;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.resources.setting-resource.pages.settings';

    public ?array $data = [];
    public ?array $setting = [];
    // public $settings = [];

    public function mount(): void
    {
        
        $this->setting = Setting::pluck("value", "name")->toArray();

        $this->form->fill();
        $this->formSetting->fill();
    }

    public function formSetting(Form $form): Form 
    {
        $settings = Setting::orderBy("display_name", "asc")->get();
        $forms = [];
        foreach ($settings as $set) {
            if($set->type == "textinput"){                
                array_push($forms, 
                    TextInput::make("setting.".$set->name)
                    ->label($set->display_name)
                    ->placeholder($set->display_name)
                    ->default($set->value)
                    ->columnSpanFull()
                    ->suffixAction(
                        Action::make('delete')
                            ->hiddenLabel()
                            ->color('danger')
                            ->icon('heroicon-m-trash')
                            ->size('sm')
                            ->action(fn () => $this->removeSetting($set->id))
                            ->requiresConfirmation()
                            ->modalHeading('Delete Setting')
                    )
                );
            }

            if($set->type == "textarea"){                
                array_push($forms, 
                    Textarea::make("setting.".$set->name)
                    ->label($set->display_name)
                    ->rows(10)
                    ->placeholder($set->display_name)
                    ->default($set->value)
                    ->columnSpan("11")
                );
                array_push($forms, 
                    \Filament\Forms\Components\Actions::make([
                        Action::make('delete')
                            ->hiddenLabel()
                            ->color('danger')
                            ->icon('heroicon-m-trash')
                            ->size('sm')
                            ->action(fn () => $this->removeSetting($set->id))
                            ->requiresConfirmation()
                            ->modalHeading('Delete Setting')
                    ])->columns("1")
                );
            }

            if($set->type == "select"){                
                array_push($forms, 
                    Select::make("setting.".$set->name)
                            ->label($set->display_name)
                            ->options((!empty($set->additional_info)?json_decode($set->additional_info, true):[]))
                            ->native(false)
                            ->default($set->value)
                            ->columnSpanFull()
                            ->suffixAction(
                                Action::make('delete')
                                    ->hiddenLabel()
                                    ->color('danger')
                                    ->icon('heroicon-m-trash')
                                    ->size('sm')
                                    ->action(fn () => $this->removeSetting($set->id))
                                    ->requiresConfirmation()
                                    ->modalHeading('Delete Setting')
                            )
                );
            }
        }
        return $form->schema([
            Section::make('General Setting')->schema($forms)->columns(12)
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Create New Setting")->schema([
                    TextInput::make('display_name')
                                            ->required()
                                            ->placeholder("My Setting")
                                            ->columns(1),
                    TextInput::make('name')
                                            ->required()
                                            ->placeholder("my_setting")
                                            ->maxLength(255)
                                            ->columns(1),
                    
                    Select::make('type')
                                            ->options(Constant::$SETTING_TYPE)
                                            ->default('textinput')
                                            ->reactive()
                                            ->required()
                                            ->columns(1),
                    KeyValue::make('additional_info')
                                            ->label('Options')
                                            ->hidden(
                                                fn (callable $get): bool => (($get('type') != "select") && ($get('type') != "checkbox") && ($get('type') != "radio"))
                                            )
                                            ->dehydrateStateUsing(fn ($state) => json_encode($state))
                                            ->columnSpan("full")
                ])
                ->columns(3)
            ])->statePath('data');
    }

    public function submit(): void
    {
        Setting::create($this->form->getState());

        $this->form->fill();

        Notification::make()
            ->title('Setting Added')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->color('success')
            ->send();

        $this->js('window.location.reload()'); 
    }

    public function removeSetting($id){
        $set = Setting::find($id);
        $set->delete();

        Notification::make()
            ->title('Setting Deleted')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->color('success')
            ->send();
    }

    public function saveSetting(){
        
        foreach($this->setting as $key => $val){
            Setting::where("name", $key)->update(["value" => $val]);
        }

        Notification::make()
            ->title('Setting Updated')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->color('success')
            ->send();
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if(($data['type'] == "select") || ($data['type'] == "checkbox") || ($data['type'] == "radio")){
            $data['additional_info'] = json_decode($data['additional_info']);
        }
        
        return $data;
    }

    protected function getForms(): array
{
    return [
        'formSetting',
        'form',
    ];
}
}

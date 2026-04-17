<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\TaskStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('status')
                    ->required()
                    ->options(TaskStatus::class)
                    ->default('todo'),
                DatePicker::make('due_date'),
            ]);
    }
}

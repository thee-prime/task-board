<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use App\TaskStatus;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Wezlo\FilamentKanban\Concerns\HasKanbanBoard;
use Wezlo\FilamentKanban\KanbanBoard;

class ListTasks extends ListRecords
{
    use HasKanbanBoard;

    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    public function kanban(KanbanBoard $kanban): KanbanBoard
    {
        return $kanban
            ->enumColumn('status', TaskStatus::class)
            ->cardTitle(fn ($record) => $record->title)
            ->cardDescription(fn ($record) => $record->description)
            ->cardAction(
                Action::make('edit')
                    ->icon(Heroicon::PencilSquare)
                    ->color('gray')
                    ->schema([
                        TextInput::make('id')->disabled()->hidden(),
                        TextInput::make('title'),
                        Textarea::make('description'),
                        Select::make('status')->options(TaskStatus::class),
                        TextInput::make('due_date'),
                    ])
                    ->fillForm(fn ($record) => $record->toArray())
                    ->action(function ($data, $record) {
                        $record->update($data);
                    })
                    ->modalCancelActionLabel('Close'),
            )
            ->cardFooterActions([
                Action::make('delete')
                    ->icon(Heroicon::Trash)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->delete()),
            ])
            ->columnHeaderAction(CreateAction::make()->label('Create Task'));
    }
}

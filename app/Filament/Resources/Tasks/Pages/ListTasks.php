<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use App\TaskStatus;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ListRecords;
use Wezlo\FilamentKanban\Concerns\HasKanbanBoard;
use Wezlo\FilamentKanban\KanbanBoard;

class ListTasks extends ListRecords
{
    use HasKanbanBoard;

    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function kanban(KanbanBoard $kanban): KanbanBoard
    {
        return $kanban
            ->enumColumn('status', TaskStatus::class)
            ->cardTitle(fn ($record) => $record->title)
            ->cardDescription(fn ($record) => $record->description)
            ->cardAction(
                Action::make('view')
                    ->slideOver()
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('description'),
                    ])
                    ->fillForm(fn ($record) => $record->toArray())
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
            );
    }
}

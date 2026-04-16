<?php

namespace App;

use BackedEnum;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Wezlo\FilamentKanban\Contracts\KanbanStatusEnum;

enum TaskStatus: string implements HasIcon, KanbanStatusEnum
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    public function getLabel(): string
    {
        return match ($this) {
            self::TODO => 'To Do',
            self::IN_PROGRESS => 'In Progress',
            self::DONE => 'Done',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::TODO => 'gray',
            self::IN_PROGRESS => 'blue',
            self::DONE => 'green',
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::TODO => Heroicon::Tag,
            self::IN_PROGRESS => Heroicon::ArrowPath,
            self::DONE => Heroicon::CheckBadge,
        };
    }

    public function getAllowedTransitions(): ?array
    {
        return match ($this) {
            self::TODO => [self::IN_PROGRESS, self::DONE],
            self::IN_PROGRESS => [self::TODO, self::DONE],
            self::DONE => null,
        };
    }

    public function getWipLimit(): ?int
    {
        return match ($this) {
            self::TODO => null,
            self::IN_PROGRESS => 10,
            self::DONE => null,
        };
    }
}

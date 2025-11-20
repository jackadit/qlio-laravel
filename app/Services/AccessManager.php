<?php

namespace App\Services;

use App\Models\SwUser;
use Illuminate\Support\Facades\Auth;

class AccessManager
{
    public const LEVELS = [
        'aucun' => 0,
        'lecture' => 1,
        'ecriture' => 2,
        'modification' => 3,
        'suppression' => 4,
        'gestion' => 5,
    ];

    public const LEVEL_LABELS = [
        0 => 'Aucun',
        1 => 'Lecture',
        2 => 'Écriture',
        3 => 'Modification',
        4 => 'Suppression',
        5 => 'Gestion',
    ];

    public const MODULES = [
        'dashboard' => 'Tableau de bord',
        'users' => 'Utilisateurs',
        'societes' => 'Entreprises',
        'stages' => 'Stages',
        'type-stages' => 'Types de stages',
        'nomenclatures' => 'Nomenclatures',
        'groupes' => 'Groupes & droits',
    ];

    protected ?SwUser $user;

    protected array $cache = [];

    public function __construct(?SwUser $user = null)
    {
        $this->user = $user;
    }

    public function setUser(?SwUser $user): self
    {
        $this->user = $user;
        $this->cache = [];

        return $this;
    }

    public function forUser(?SwUser $user): self
    {
        return $this->setUser($user);
    }

    public function level(string $module): int
    {
        $key = strtolower($module);

        if (!array_key_exists($key, $this->cache)) {
            $this->cache[$key] = $this->resolveLevel($key);
        }

        return $this->cache[$key];
    }

    public function canAtLeast(string $module, int|string $level): bool
    {
        $required = is_string($level)
            ? (self::LEVELS[strtolower($level)] ?? 0)
            : $level;

        return $this->level($module) >= $required;
    }

    public function levelName(string $module): string
    {
        $level = $this->level($module);
        return self::LEVEL_LABELS[$level] ?? 'Inconnu';
    }

    public static function modules(): array
    {
        return self::MODULES;
    }

    public static function levelLabels(): array
    {
        return self::LEVEL_LABELS;
    }

    protected function resolveLevel(string $module): int
    {
        $user = $this->resolveUser();

        if (!$user) {
            return 0;
        }

        $user->loadMissing(['droits', 'groupes.droits']);

        $direct = optional(
            $user->droits->firstWhere('module', $module)
        )->niveau ?? 0;

        $groupLevel = $user->groupes
            ->flatMap(fn ($group) => $group->droits)
            ->filter(fn ($droit) => $droit->module === $module)
            ->max('niveau') ?? 0;

        return max($direct, $groupLevel);
    }

    protected function resolveUser(): ?SwUser
    {
        if ($this->user) {
            return $this->user;
        }

        $authUser = Auth::user();

        return $authUser instanceof SwUser ? $authUser : null;
    }
}

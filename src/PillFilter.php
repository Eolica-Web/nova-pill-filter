<?php

namespace Eolica\NovaPillFilter;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

abstract class PillFilter extends Filter
{
    public $component = 'pill-filter';

    public function __construct()
    {
        $this->setDefaultMeta();
    }

    public function draggable(): self
    {
        return $this->withMeta(['mode' => 'drag']);
    }

    public function single(): self
    {
        return $this->withMeta(['single' => true])->hideClearButton();
    }

    public function clearLabel(string $label): self
    {
        return $this->withMeta(['clearLabel' => $label]);
    }

    public function hideClearButton(): self
    {
        return $this->withMeta(['showClearButton' => false]);
    }

    public function default()
    {
        return [];
    }

    public function jsonSerialize()
    {
        return array_merge(
            [
                'class' => $this->key(),
                'name' => $this->name(),
                'component' => $this->component(),
                'options' => $this->serializeOptions(),
                'currentValue' => $this->default() ?? [],
            ],
            $this->meta()
        );
    }

    private function serializeOptions()
    {
        $container = Container::getInstance();

        return collect($this->options($container->make(Request::class)))
            ->map(function ($value, $key) {
                return array_merge(
                    [
                        'color' => '#3c4b5f',
                        'backgroundColor' => '#eef1f4',
                        'colorActive' => '#ffffff',
                        'backgroundColorActive' => '#4099de',
                    ],
                    is_array($value) ? ($value + ['value' => $key]) : ['label' => $key, 'value' => $value]
                );
            })
            ->values()
            ->all();
    }

    private function setDefaultMeta(): void
    {
        $this->withMeta([
            'mode' => 'wrap',
            'single' => false,
            'showClearButton' => true,
            'clearLabel' => 'Clear'
        ]);
    }
}

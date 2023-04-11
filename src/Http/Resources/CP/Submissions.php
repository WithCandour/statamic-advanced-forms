<?php

namespace WithCandour\StatamicAdvancedForms\Http\Resources\CP;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Statamic\CP\Column;
use Statamic\Fields\Blueprint;
use Statamic\Http\Resources\CP\Concerns\HasRequestedColumns;

class Submissions extends ResourceCollection
{
    use HasRequestedColumns;

    public $collects = Submission::class;

    protected ?Blueprint $blueprint = null;

    protected $columns = null;

    protected ?string $columnPreferenceKey = null;

    public function blueprint(Blueprint $blueprint): self
    {
        $this->blueprint = $blueprint;
        return $this;
    }

    public function columnPreferenceKey(string $key): self
    {
        $this->columnPreferenceKey = $key;
        return $this;
    }

    private function setColumns()
    {
        $columns = $this->blueprint
            ->columns()
            ->map(fn (Column $column) => $column->sortable(false))
            ->ensurePrepended(Column::make('date')->label('Date')->sortable(false));

        if ($key = $this->columnPreferenceKey) {
            $columns->setPreferred($key);
        }

        $this->columns = $columns->rejectUnlisted()->values();
    }

    public function toArray($request)
    {
        $this->setColumns();

        return $this->collection->each(function ($collection) {
            $collection
                ->blueprint($this->blueprint)
                ->columns($this->columns);
        });
    }

    public function with($request)
    {
        return [
            'meta' => [
                'columns' => $this->columns,
            ],
        ];
    }
}

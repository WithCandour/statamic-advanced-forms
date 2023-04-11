<?php

namespace WithCandour\StatamicAdvancedForms\Http\Resources\CP;

use Illuminate\Http\Resources\Json\JsonResource;
use Statamic\Facades\Action;
use Statamic\Statamic;

class Submission extends JsonResource
{
    protected $blueprint;
    protected $columns;

    public function blueprint($blueprint)
    {
        $this->blueprint = $blueprint;

        return $this;
    }

    public function columns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function toArray($request)
    {
        $values = $this->resource->values()?->data() ?? [];

        $defaultValues = [
            'id' => $this->resource->id(),
            'url' => $this->resource->showUrl(),
            'actions' => Action::for($this->resource),
        ];

        return \collect($defaultValues)
            ->merge($values)
            ->merge([
                'date' => $this->resource->date()->format(Statamic::cpDateTimeFormat())
            ]);
    }

    protected function values($extra = [])
    {
        return $this->columns->mapWithKeys(function ($column) use ($extra) {
            $key = $column->field;
            $value = $extra[$key] ?? $this->resource->values()?->get($key) ?? null;

            if (! $field = $this->blueprint->field($key)) {
                return [$key => $value];
            }

            $value = $field
                ->setValue($value)
                ->setParent($this->resource)
                ->preProcessIndex()
                ->value();

            return [$key => $value];
        });
    }
}

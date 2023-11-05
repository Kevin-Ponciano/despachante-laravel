<?php

namespace App\Traits;

use Carbon\Carbon;

trait AttributeModel
{
    public function getCreatedAt(): ?string
    {
        return $this->dataTimeToBr($this->created_at);
    }

    public function dataTimeToBr($value): ?string
    {
        if (! $value) {
            return null;
        }
        $newValue = Carbon::createFromFormat('Y-m-d H:i:s', $value);

        return $newValue->format('d/m/Y').' - '.$newValue->format('H:i');
    }

    public function getUpdatedAt(): ?string
    {
        return $this->dataTimeToBr($this->updated_at);
    }

    public function getDeletedAt(): ?string
    {
        return $this->dataTimeToBr($this->deleted_at);
    }

    public function getConcludedAt(): ?string
    {
        return $this->dataTimeToBr($this->concluded_at);
    }
}

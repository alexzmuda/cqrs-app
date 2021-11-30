<?php

namespace App\Infrastructure\DTO;

use Illuminate\Foundation\Http\FormRequest;

interface RequestInput
{
    public static function createFromRequest(FormRequest $request): self;
}

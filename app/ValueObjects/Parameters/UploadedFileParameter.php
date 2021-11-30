<?php

declare(strict_types=1);

namespace App\ValueObjects\Parameters;

use App\Exceptions\InvalidParameterException;
use Illuminate\Http\UploadedFile;

final class UploadedFileParameter extends AbstractParameter
{
    private ?UploadedFile $uploadedFile;

    /**
     * @param UploadedFile|null $uploadedFile
     * @param bool $isNullable
     * @throws InvalidParameterException
     */
    public function __construct(?UploadedFile $uploadedFile, bool $isNullable = false)
    {
        parent::__construct($isNullable);
        $this->assertCompliance($uploadedFile);
        $this->uploadedFile = $uploadedFile;
    }

    public static function getType(): string
    {
        return 'uploaded_file';
    }

    public function getValue(): ?UploadedFile
    {
        return $this->uploadedFile;
    }
}

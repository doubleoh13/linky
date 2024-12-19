<?php

namespace App\Services\Notion;

use Notion\Pages\Properties\RichTextProperty;
use Notion\Pages\Properties\Title;

class PendingTask extends PendingPage
{
    public function withName(string|Title $title): self
    {
        $title = is_string($title) ? Title::fromString($title) : $title;

        return $this->addProperty('Name', $title);
    }

    public function withDescription(RichTextProperty|string|null $description): self
    {
        if (! $description instanceof RichTextProperty) {
            $description = is_null($description)
                ? RichTextProperty::createEmpty()
                : RichTextProperty::fromString($description);
        }

        return $this->addProperty('Description', $description);
    }
}

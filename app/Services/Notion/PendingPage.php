<?php

namespace App\Services\Notion;

use Notion\Common\Emoji;
use Notion\Common\File;
use Notion\Common\Icon;
use Notion\Pages\Page;
use Notion\Pages\PageParent;
use Notion\Pages\Properties\PropertyInterface;

class PendingPage
{
    private Page $page;

    public function __construct(PageParent $parent, private readonly NotionService $notionService)
    {
        $this->page = Page::create($parent);
    }

    public function add(): void
    {
        $this->notionService->addPage($this->page);
    }

    public function archive(): static
    {
        $this->page = $this->page->archive();

        return $this;
    }

    public function unarchive(): static
    {
        $this->page = $this->page->unarchive();

        return $this;
    }

    public function changeIcon(Emoji|File|Icon $icon): static
    {
        $this->page = $this->page->changeIcon($icon);

        return $this;
    }

    public function removeIcon(): static
    {
        $this->page = $this->page->removeIcon();

        return $this;
    }

    public function changeCover(File $cover): static
    {
        $this->page = $this->page->changeCover($cover);

        return $this;
    }

    public function removeCover(): static
    {
        $this->page = $this->page->removeCover();

        return $this;
    }

    public function addProperty(string $name, PropertyInterface $property): static
    {
        $this->page = $this->page->addProperty($name, $property);

        return $this;
    }

    /**
     * @param  array<string, PropertyInterface>  $properties
     */
    public function changeProperty(array $properties): static
    {
        $this->page = $this->page->changeProperties($properties);

        return $this;
    }

    public function changeTitle(string $title): static
    {
        $this->page = $this->page->changeTitle($title);

        return $this;
    }

    public function changeParent(PageParent $parent): static
    {
        $this->page = $this->page->changeParent($parent);

        return $this;
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    public function __call(string $method, array $parameters): PendingPage
    {
        $this->page->{$method}(...$parameters);

        return $this;
    }
}

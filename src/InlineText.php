<?php

namespace Pdmfc\NovaFields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class InlineText extends Field
{
    /**
     * @var bool
     */
    protected $inlineOnIndex = false;

    /**
     * @var bool
     */
    protected $refreshOnSaving = false;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-inline-text';

    /**
     * The event trigger used to save the field value,
     *
     * @var string
     */
    protected $event = 'keyup.enter';

    /**
     * Allows field to be editable on index view.
     *
     * @param closure|null $callback
     * @return self
     */
    public function inlineOnIndex(callable $callback = null)
    {
        $inline = true;

        if (is_callable($callback)) {
            $inline = call_user_func($callback, resolve(NovaRequest::class));
        }

        $this->inlineOnIndex = $inline;

        return $this;
    }

    /**
     * It updates the resource table when saving the field value.
     *
     * @return self
     */
    public function refreshOnSaving()
    {
        $this->refreshOnSaving = true;

        return $this;
    }

    /**
     *
     */
    public function saveOn(string $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Resolve the field's value.
     *
     * @param  mixed  $resource
     * @param  string|null  $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        $this->withMeta([
            'inlineOnIndex' => $this->inlineOnIndex,
            'refreshOnSaving' => $this->refreshOnSaving,
            'event' => $this->event,
        ]);
    }
}

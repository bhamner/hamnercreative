<?php

namespace App\Services;

class ContentFieldInputBuilder
{
    public function render(string $inputType, string $name, ?string $value = null): ?string
    {
        if (! in_array($inputType, ['text', 'textarea', 'checkbox', 'number'], true)) {
            return null;
        }

        return match ($inputType) {
            'text' => $this->text($name, $value),
            'textarea' => $this->textarea($name, $value),
            'checkbox' => $this->checkbox($name, $value),
            'number' => $this->number($name, $value),
        };
    }

    private function text(string $name, ?string $value): string
    {
        $label = $this->escape(str_replace('_', ' ', ucwords($name)));
        $fieldName = $this->escape('content_'.$name);
        $placeholder = $this->escape($name);
        $escapedValue = $this->escape($value);
        $inputId = $this->escape($name.'_input');

        return '<label for="'.$inputId.'" class="form-label">'.$label.'</label>
        <input type="text" class="form-control" id="'.$fieldName.'" name="'.$fieldName.'" placeholder="'.$placeholder.'"
        value="'.$escapedValue.'" />';
    }

    private function textarea(string $name, ?string $value): string
    {
        $label = $this->escape(str_replace('_', ' ', ucwords($name)));
        $fieldName = $this->escape('content_'.$name);
        $escapedValue = $this->escape($value);
        $inputId = $this->escape($name.'_input');

        return '<label for="'.$inputId.'" class="form-label">'.$label.'</label>
            <textarea rows="3" class="form-control" id="'.$fieldName.'" name="'.$fieldName.'">'.$escapedValue.'</textarea>';
    }

    private function checkbox(string $name, ?string $value): string
    {
        $checked = $value ? 'checked' : '';
        $label = $this->escape(str_replace('_', ' ', ucwords($name)));
        $fieldName = $this->escape('content_'.$name);
        $inputId = $this->escape($name.'_input');

        return '<div class="form-check form-switch">
          <input value="1" name="'.$fieldName.'" class="form-check-input" type="checkbox" role="switch" id="'.$inputId.'" '.$checked.'><label class="form-check-label" for="'.$inputId.'">'.$label.'</label>
        </div>';
    }

    private function number(string $name, ?string $value): string
    {
        $label = $this->escape(str_replace('_', ' ', ucwords($name)));
        $fieldName = $this->escape('content_'.$name);
        $placeholder = $this->escape($name);
        $escapedValue = $this->escape($value);
        $inputId = $this->escape($name.'_input');

        return '<label for="'.$inputId.'" class="form-label">'.$label.'</label>
        <input type="number" min="0" max="100000" class="form-control" id="'.$fieldName.'" name="'.$fieldName.'" placeholder="'.$placeholder.'"
        value="'.$escapedValue.'" />';
    }

    private function escape(?string $value): string
    {
        return e($value ?? '');
    }
}
